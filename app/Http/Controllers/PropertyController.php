<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Profile;
use App\Models\Property;
use App\Models\Range;
use App\Models\Activity;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;



class PropertyController extends Controller
{
    public function addProperty()
    {
        $data['range'] = DB::table('price_range')->get();
        $data['category'] = DB::table('property_category')->get();
        $data['subcategory'] = DB::table('property_subcategory')->get(); 
        $data['localities'] = DB::table('localities')->get();
        $data['property_status'] = DB::table('property_status')->get();
        return view('property.addProperty',compact('data'));
    }

    public function insertProperty(Request $request){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

        DB::beginTransaction();

        try {
            // Save the property details
            $p = new Property;
            $p->title = $request->property_title;
            $p->meta_title = $request->meta_title; 
            $p->meta_description = $request->meta_description; 
            $p->meta_keywords = $request->meta_keywords; 
            $p->property_type_id = $request->property_type;
            $p->builder_name = $request->builder_name;
            $p->property_details = $request->property_description;
            $p->address = $request->property_address;
            $p->property_subcategory_id = $request->property_subcategory_id;
            // Handle Amenities
            $locality = DB::table('localities')->where('id', $request->localitie)->value('name');
            $property_status = DB::table('property_status')
            ->where('id', $request->property_status)
            ->value('status_name');

            $amenities = $request->input('amenities', []); // Default to an empty array if null
            $p->facilities = implode(', ', $amenities);

            $p->creator_id = $request->creator_id;
            $p->price_range_id = $request->price_range;
            $p->contact = $request->contact_number;
            $p->area = $request->area;
            $p->builtup_area = $request->builtup_area;
            $p->localities = $locality;
            $p->property_status = $property_status ?? 'Default Status';
            $p->beds = $request->beds;
            $p->baths = $request->baths;
            $p->balconies = $request->balconies;
            $p->parking = $request->parking;
            $p->city = $request->city;
            $p->email = $request->email_id;
            $p->select_bhk = json_encode($request->select_bhk);
            $p->s_price = $request->s_price;
            $p->rera = $request->rera;
            $p->land_type = $request->land_type;
            $p->location = $request->input('location');
            $p->latitude = $request->input('latitude');
            $p->longitude = $request->input('longitude');
            $p->boucher = $this->handleFileUpload($request, 'property_voucher', 'property_brochures');

            // Handle nearby locations
            $nearby_locations = $request->input('nearby', []); // Default to empty array if null
            $p->nearby_locations = json_encode($nearby_locations);
            $p->is_featured = $request->has('is_featured') ? 1 : 0;
            // Save the property record
            $p->save();

            // Save multiple images in the `property_images` table
            if ($request->hasFile('property_images')) {
                foreach ($request->file('property_images') as $property_image) {
                    $image_name = substr(str_shuffle($permitted_chars), 0, 8) . time() . '.' . $property_image->extension();
                    $image_path = "property_photos/" . $image_name;
                    $property_image->move(public_path('property_photos'), $image_path);

                    // Insert into `property_images` table
                    DB::table('property_images')->insert([
                        'properties_id' => $p->id, // Use the correct property ID
                        'image_url' => $image_path,
                        'is_featured' => 0, // Default to non-featured
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Commit transaction if successful
            DB::commit();
            return response()->json(['status' => 1, 'msg' => 'Property added successfully']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 0, 'msg' => $e->getMessage()]);
        }
    }

/**
 * Handle file uploads for single files.
 * 
 * @param Request $request
 * @param string $inputName - The name of the input field in the request
 * @param string $folder - The folder where the file should be saved
 * @return string - The file path of the uploaded file
 */
private function handleFileUpload(Request $request, $inputName, $folder)
{
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    if ($request->hasFile($inputName)) {
        $file_name = substr(str_shuffle($permitted_chars), 0, 8) . time() . '.' . $request->file($inputName)->extension();
        $file_path = "$folder/" . $file_name;
        $request->file($inputName)->move(public_path($folder), $file_path);
        return $file_path;
    }
    return ""; // Return an empty string if no file was uploaded
}

public function allProperties()
{
    $role_id = Session::get('role_id'); 
    $user_id = Session::get('user_id'); 

    // Main Query
    $query = DB::table('properties')
        ->join('price_range', 'properties.price_range_id', '=', 'price_range.range_id')
        ->join('property_category', 'properties.property_type_id', '=', 'property_category.pid')
        ->where('properties.is_active', 1)
        ->select(
            'properties.properties_id',
            'properties.title',
            'properties.property_type_id',
            'properties.builder_name',
            'properties.select_bhk',
            'properties.land_type',
            'properties.address',
            'properties.rera',
            'properties.facilities',
            'properties.s_price',
            'properties.beds',
            'properties.baths',
            'properties.balconies',
            'properties.parking',
            'properties.builtup_area',
            'properties.contact',
            'price_range.from_price',
            'price_range.to_price',
            'property_category.category_name', // Ensure this is selected
            'properties.is_featured',
            'properties.image'
        );

    if ($role_id == 3) {
        $query->where('properties.creator_id', $user_id);
    }

    // Fetch All Properties (Curated)
    $data['allProperties'] = $query->paginate(50);
    

    // Fetch Only Featured Properties
    $data['featuredProperties'] = DB::table('properties')
        ->join('price_range', 'properties.price_range_id', '=', 'price_range.range_id')
        ->join('property_category', 'properties.property_type_id', '=', 'property_category.pid')
        ->where('properties.is_active', 1)
        ->where('properties.is_featured', 1) // Fetch only featured properties
        ->select(
            'properties.properties_id',
            'properties.title',
            'properties.property_type_id',
            'properties.builder_name',
            'properties.select_bhk',
            'properties.land_type',
            'properties.address',
            'properties.rera',
            'properties.facilities',
            'properties.s_price',
            'properties.beds',
            'properties.baths',
            'properties.balconies',
            'properties.parking',
            'properties.builtup_area',
            'properties.contact',
            'price_range.from_price',
            'price_range.to_price',
            'property_category.category_name', // Fix: Ensure category_name is included
            'properties.image'
        )
        ->paginate(10);

    return view('property.allProperties', compact('data'));
}


    public function toggleFeatured(Request $request)
    {
        $updated = DB::table('properties')
            ->where('properties_id', $request->property_id)
            ->update(['is_featured' => $request->is_featured]);

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'Featured status updated successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Property not found or no changes made!'
        ]);
    }
    public function pendingProperties()
    {
            $data['allProperties'] = DB::table('properties')
        ->join('price_range', 'properties.price_range_id', '=', 'price_range.range_id')
        ->join('property_category', 'properties.property_type_id', '=', 'property_category.pid')
        ->where('properties.is_active',0)
        ->select('properties.properties_id', 'properties.title', 'properties.property_type_id', 'properties.builder_name','properties.select_bhk', 'properties.land_type',
        'properties.address','properties.facilities', 'properties.rera', 'properties.s_price', 'properties.builtup_area', 'properties.beds', 'properties.baths', 'properties.balconies', 'properties.parking', 'properties.contact', 'price_range.from_price', 'price_range.to_price', 'property_category.category_name')
        ->paginate(50);
        
        return view('property.pendingProperties',compact('data'));
    }

    public function viewDetails($property_id) {
        // Fetch property details
        $data['propertie_details'] = DB::select('SELECT * 
            FROM properties AS p
            JOIN price_range AS pr ON p.price_range_id = pr.range_id
            JOIN property_category AS pc ON pc.pid = p.property_type_id
            WHERE p.properties_id = ?', [$property_id]
        );
    
        // Fetch all images for the property
        $data['property_images'] = DB::table('property_images')
        ->where('properties_id', $property_id)
        ->get();
    
        return view('property.propertyDetails', compact('data'));
    }
    public function activate(Request $request){
        $updatePropertie = array(
            'is_active'=> 1
        );

        try{        
            $property_id = $request->propertie_id;    
            $update_propertie = DB::table('properties')->where('properties_id',$property_id)->update($updatePropertie);
           
            if($update_propertie){

                //activity logs
                $username = Session::get('username');
                $user_id = Session::get('user_id');
                $details = "Property Activated successfully by ".$username; 
                app(UsersController::class)->insertActivityLogs($user_id, $details);
                //end of activity logs   

                return response()->json(['status'=>1,'msg'=>'Propertie is successfully activated !']);
            }
        }catch (\Exception $e) {
            DB::rollback();            
            dd($e->getMessage());
        }
    }

    public function editProperty($property_id) {
        $data['range'] = DB::table('price_range')->get();
        $data['category'] = DB::table('property_category')->get();
        $data['propertie_details'] = DB::select('SELECT * 
                                                 FROM properties AS p
                                                 JOIN price_range AS pr ON p.price_range_id = pr.range_id
                                                 JOIN property_category AS pc ON pc.pid = p.property_type_id
                                                 WHERE p.properties_id = ?', [$property_id]);
    
        // Fetch existing images for the property
        $data['property_images'] = DB::table('property_images')
                                      ->where('properties_id', $property_id)
                                      ->get();
    
        return view('property.editProperty', compact('data'));
    }
    
    public function updatePropertie(Request $request) {
        try {
            // Validate request
            $request->validate([
                'propertie_id' => 'required|integer|exists:properties,properties_id',
                'property_title' => 'required|string|max:255',
                'meta_title' => 'required|string|max:255',
                'meta_description' => 'required|string|max:255',
                'meta_keywords' => 'required|string|max:255',
                'property_type_id' => 'required|integer',
                'builder_name' => 'nullable|string|max:255',
                's_price' => 'nullable|numeric',
                'select_bhk' => 'nullable|integer',
                'property_description' => 'nullable|string',
                'property_address' => 'nullable|string',
                'email_id' => 'nullable|email|max:255',
                'contact_number' => 'nullable|string|max:255',
                'price_range' => 'nullable|integer',
                'creator_id' => 'nullable|integer',
                'property_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'property_voucher' => 'nullable|mimes:pdf|max:4096',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'beds' => 'nullable|integer',
                'baths' => 'nullable|integer',
                'balconies' => 'nullable|integer',
                'parking' => 'nullable|integer',
                'localities' => 'nullable|string',
                'city' => 'nullable|string',
                'property_status' => 'nullable|string',
            ]);
    
            $propertie_id = $request->propertie_id;
    
            // Fetch property
            $property = DB::table('properties')->where('properties_id', $propertie_id)->first();
            if (!$property) {
                return response()->json(['status' => 0, 'msg' => 'Property not found']);
            }
    
            // Store old image and voucher
            $old_image = $property->image;
            $old_boucher = $property->boucher;
    
            // Generate new filenames
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $property_image_name = $old_image;
            $boucher_name = $old_boucher;
    
            // Handle Property Image Upload
            if ($request->hasFile('property_image')) {
                $property_image_name = substr(str_shuffle($permitted_chars), 0, 8) . time() . '.' . $request->property_image->extension();
                $request->property_image->move(public_path('property_photoes'), $property_image_name);
            }
    
            // Handle Boucher Upload
            if ($request->hasFile('property_voucher')) {
                $boucher_name = "property_bouchers/" . substr(str_shuffle($permitted_chars), 0, 8) . time() . '.' . $request->property_voucher->extension();
                $request->property_voucher->move(public_path('property_bouchers'), $boucher_name);
            }
    
            // Prepare update data
            $updateProperty = [
                'title' => $request->property_title,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
                'property_type_id' => $request->property_type_id,
                'builder_name' => $request->builder_name ?? '',
                's_price' => $request->s_price ?? 0,
                'select_bhk' => $request->select_bhk ?? 0,
                'property_details' => $request->property_description ?? '',
                'address' => $request->property_address ?? '',
                'email' => $request->email_id ?? '',
                'contact' => $request->contact_number ?? '',
                'price_range_id' => $request->price_range ?? 0,
                'creator_id' => $request->creator_id ?? 0,
                'image' => $property_image_name,
                'boucher' => $boucher_name,
                'facilities' => $request->amenities ?? '',
                'area' => $request->area ?? 0,
                'builtup_area' => $request->builtup_area ?? 0,
                'city' => $request->city ?? '',
                'rera' => $request->rera ?? '',
                'beds' => $request->beds ?? 0,
                'baths' => $request->baths ?? 0,
                'balconies' => $request->balconies ?? 0,
                'parking' => $request->parking ?? 0,
                'localities' => $request->localities ?? '',
                'location' => $request->location ?? '',
                'latitude' => $request->latitude ?? 0,
                'longitude' => $request->longitude ?? 0,
                'land_type' => $request->land_type ?? '',
                'property_status' => $request->property_status ?? 'Default Status',
                'updated_at' => now()
            ];
    
            // Start transaction
            DB::beginTransaction();
    
            // Debugging: Print Update Query
            DB::enableQueryLog();
    
            // Perform update
            $affectedRows = DB::table('properties')->where('properties_id', $propertie_id)->update($updateProperty);
            
            if ($affectedRows === 0) {
                return response()->json(['status' => 0, 'msg' => 'No changes detected!']);
            }
    
            // Handle multiple images upload
            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $image) {
                    $imageName = "property_photoes/" . time() . rand(1000, 9999) . '.' . $image->extension();
                    $image->move(public_path('property_photoes'), $imageName);
    
                    DB::table('property_images')->insert([
                        'properties_id' => $propertie_id,
                        'image_url' => $imageName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
    
            // Commit transaction
            DB::commit();
    
            // Insert activity logs
            $username = Session::get('username', 'Unknown User');
            $user_id = Session::get('user_id', 0);
            $details = "Property Updated successfully by " . $username;
            app(UsersController::class)->insertActivityLogs($user_id, $details);
    
            return response()->json(['status' => 1, 'msg' => 'Property updated successfully!', 'query' => DB::getQueryLog()]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }    
    

    public function deletePropertie(Request $request){
          //activity logs
          $username = Session::get('username');
          $user_id = Session::get('user_id');
          $details = "Property id - [". $request->propertie_id  ."] deleted successfully by ".$username; 
          app(UsersController::class)->insertActivityLogs($user_id, $details);
      //end of activity logs   

        try{ 
            $propertie_id = $request->propertie_id;    
            $propertie = DB::table('properties')->where('properties_id', $propertie_id)->delete();

          
            if($propertie){
                return response()->json(['status'=>1,'msg'=>'Propertie deleted successfully !']);
            }
        }catch (\Exception $e) {
            DB::rollback();            
            dd($e->getMessage());
        }
    }
    public function uploadTinyMCEImage(Request $request) {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/tinymce'), $filename);
            $url = asset('uploads/tinymce/' . $filename);
    
            return response()->json(['location' => $url]);
        }
        
        return response()->json(['error' => 'Image upload failed'], 400);
    }
    public function getLocalities()
    {
        $localities = DB::table('localities')->get();
        $selectedLocalities = DB::table('selected_localities')->pluck('locality_id')->toArray();
    
        return view('admin.select_localities', compact('localities', 'selectedLocalities'));
    }
    public function storeLocalities(Request $request)
    {
        $request->validate([
            'localities' => 'required|array|max:3',
            'localities.*' => 'exists:localities,id'
        ]);
    
        // Remove old selected localities
        DB::table('selected_localities')->truncate();
    
        // Insert new selected localities
        foreach ($request->localities as $locality) {
            DB::table('selected_localities')->insert([
                'locality_id' => $locality
            ]);
        }
    
        return redirect()->back()->with('success', 'Localities updated successfully!');
    }

}
