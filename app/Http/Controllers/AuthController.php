<?php
use App\Models\Admin;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function adminLogin(Request $request)
    {
        // Validate the login request

        // Attempt to authenticate the admin
        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication successful
            return redirect()->intended('/admin/dashboard');
        } else {
            // Authentication failed
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

    public function studentLogin(Request $request)
    {
        // Validate the login request

        // Attempt to authenticate the student
        if (Auth::guard('student')->attempt($credentials)) {
            // Authentication successful
            return redirect()->intended('/student/dashboard');
        } else {
            // Authentication failed
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }
}
