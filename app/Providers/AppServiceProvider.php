<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('frontend.layouts.footer', function ($view) {
            $allServices = DB::table('services')->select('id', 'service_name')->get();
            $allInsights = DB::table('insights')->select('id', 'insights_name')->get();
            $allIndustries = DB::table('industries')->select('id', 'industries_name')->get();
    
            $view->with([
                'allServices' => $allServices,
                'allInsights' => $allInsights,
                'allIndustries' => $allIndustries,
            ]);
        });
    
         // Header Composer (for dynamic Insights & Industries menu)
         View::composer('frontend.layouts.header', function ($view) {
            // Insights
            $insightCategories = DB::table('insights_category as c')
                ->leftJoin('insights_subcategory as s', 'c.pid', '=', 's.pid')
                ->select('c.pid', 'c.category_name', 's.insights_subcategory_id', 's.name')
                ->get()
                ->groupBy('pid');
    
            $structuredInsights = $insightCategories->map(function ($items, $pid) {
                $categoryName = $items->first()->category_name;
    
                $subcategories = $items->map(function ($item) {
                    return [
                        'id' => $item->insights_subcategory_id,
                        'name' => $item->name,
                    ];
                })->filter(fn($sub) => $sub['name'] !== null);
    
                return [
                    'category_name' => $categoryName,
                    'subcategories' => $subcategories,
                ];
            });
    
            // Industries
            $industryCategories = DB::table('industries_category as c')
                ->leftJoin('industries_subcategory as s', 'c.pid', '=', 's.pid')
                ->select('c.pid', 'c.category_name', 's.industries_subcategory_id', 's.name')
                ->get()
                ->groupBy('pid');
    
            $structuredIndustries = $industryCategories->map(function ($items, $pid) {
                $categoryName = $items->first()->category_name;
    
                $subcategories = $items->map(function ($item) {
                    return [
                        'id' => $item->industries_subcategory_id,
                        'name' => $item->name,
                    ];
                })->filter(fn($sub) => $sub['name'] !== null);
    
                return [
                    'category_name' => $categoryName,
                    'subcategories' => $subcategories,
                ];
            });
    
            // Services
            $serviceCategories = DB::table('property_category as c')
                ->leftJoin('property_subcategory as s', 'c.pid', '=', 's.pid')
                ->select('c.pid', 'c.category_name', 's.property_subcategory_id', 's.name')
                ->get()
                ->groupBy('pid');
    
            $structuredServices = $serviceCategories->map(function ($items, $pid) {
                $categoryName = $items->first()->category_name;
    
                $subcategories = $items->map(function ($item) {
                    return [
                        'id' => $item->property_subcategory_id,
                        'name' => $item->name,
                    ];
                })->filter(fn($sub) => $sub['name'] !== null);
    
                return [
                    'category_name' => $categoryName,
                    'subcategories' => $subcategories,
                ];
            });
    
            $view->with([
                'insightMenuData' => $structuredInsights,
                'industriesMenuData' => $structuredIndustries,
                'serviceMenuData' => $structuredServices,
            ]);
        });

    }
}