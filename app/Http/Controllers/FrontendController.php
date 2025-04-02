<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Models\PasswordResets;

class FrontendController extends Controller
{
    public function userLogin(Request $req)
    {
        // Validate the input
        $req->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        $email = $req->input('email');
        $p = md5($req->input('password'));

        // Fetch user data including the password
        $users = DB::select('
            SELECT u.id, u.name, u.email_id, u.password, p.mobile_no, r.id as role_id, r.name as role_name, u.is_email_verify
            FROM users u
            JOIN profile p ON u.id = p.user_id
            JOIN roles r ON r.id = u.role_id
            WHERE u.email_id = ?
        ', [$email]);

        if (count($users) === 0) {
            // Username (email) not found
            return redirect()->back()->with('error', 'Incorrect username.');
        }

        $user = $users[0]; // Assuming there is only one matching user

        // Check password and email verification
        if ($user->password !== $p) {
            // Password does not match
            return redirect()->back()->with('error', 'Incorrect password.');
        }

        if (!$user->is_email_verify) {
            // Email not verified
            return redirect()->back()->with('error', 'Email not verified.');
        }

        // Set session variables
        Session::put('username', $user->name);
        Session::put('role_name', $user->role_name);
        Session::put('user_id', $user->id);
        Session::put('role_id', $user->role_id);
        Session::put('email', $user->email_id);

        // Redirect based on role_id
        switch ($user->role_id) {
            case 4:
                return redirect('admin/dashboard');
            case 1:
                return redirect('/');
            default:
                return redirect('/');
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}
