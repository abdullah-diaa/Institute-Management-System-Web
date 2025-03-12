<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Profile;



class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index'); // Path to the main settings blade
    }

    public function editName()
{
    $user = Auth::user();

    // Check if the user can update the name based on last_name_update
    $canEditName = true; // Default to true (user can edit name)
    $lastNameUpdate = $user->last_name_update;

    if ($lastNameUpdate && $lastNameUpdate->diffInMonths(now()) < 1) {
        $canEditName = false; // User cannot edit name if less than 1 month since last update
    }

    return view('settings.name', compact('user', 'canEditName'));
}


    // Method to update the name
    public function updateName(Request $request)
    {
        $user = Auth::user();
    
        // Validation for name
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        // Check if the user can update the name based on last_name_update
        $lastNameUpdate = $user->last_name_update;
        if ($lastNameUpdate && $lastNameUpdate->diffInMonths(now()) < 1) {
            return redirect()->back()->with('error', 'You can only change your name once every month.');
        }
    
        // Update the name
        $user->name = $request->input('name');
        $user->last_name_update = now(); // Update the last_name_update field with the current timestamp
        $user->save();
    
        return redirect()->route('settings.index')->with('success', 'Your name has been updated successfully.');
    }

   // Method to edit phone number
   public function editPhoneNumber()
{
    $user = Auth::user();

    // Check if the user can update the phone number based on last_phone_update
    $canEditPhoneNumber = true; // Default to true (user can edit phone number)
    $lastPhoneUpdate = $user->Profile->last_phone_update; // Access last_phone_update from Profile

    if ($lastPhoneUpdate && $lastPhoneUpdate->diffInMonths(now()) < 1) {
        $canEditPhoneNumber = false; // User cannot edit phone number if less than 1 month since last update
    }

    return view('settings.phone_number', compact('user', 'canEditPhoneNumber'));
}


public function updatePhoneNumber(Request $request)
{
    $user = Auth::user();

    // Validation for phone number
    $request->validate([
        'phone_number' => 'required|string|max:15', // Adjust max length as needed
    ]);

    // Check if the user can update the phone number based on last_phone_update
    $lastPhoneUpdate = $user->Profile->last_phone_update; // Access last_phone_update from Profile
    if ($lastPhoneUpdate && $lastPhoneUpdate->diffInMonths(now()) < 1) {
        return redirect()->back()->with('error', 'You can only change your phone number once every month.');
    }

    // Update the phone number
    $user->Profile->phone_number = $request->input('phone_number');
    $user->Profile->last_phone_update = now(); // Update the last_phone_update field with the current timestamp
    $user->Profile->save();

    return redirect()->route('settings.index')->with('success', 'Your phone number has been updated successfully.');
}
   // Method to show profile info form
    public function profileInfo()
    {
        $user = Auth::user();
        $location = $user->profile->location; // Assuming location is in the 'profiles' table
        $dateOfBirth = $user->profile->date_of_birth; // Assuming date_of_birth is in 'profiles' table
        $gender = $user->gender; // Assuming gender is in 'users' table

        return view('settings.profile_info', compact('location', 'dateOfBirth', 'gender'));
    }

    // Method to update location and date of birth
    public function updateProfileInfo(Request $request)
    {
        $user = Auth::user();

        // Validate location and date_of_birth fields
        $request->validate([
            'location' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
        ]);

        // Check if the authenticated user is the one making the changes
        if ($user->id == Auth::id()) {
            $user->profile->location = $request->input('location');
            $user->profile->date_of_birth = $request->input('date_of_birth');
            $user->profile->save();

            return redirect()->back()->with('success', 'Profile information updated successfully!');
        }

        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    // Method to update gender
    public function updateGender(Request $request)
    {
        $user = Auth::user();

        // Validate the gender field
        $request->validate([
            'gender' => 'required|in:male,female',
        ]);

        // Check if the authenticated user is the one making the changes
        if ($user->id == Auth::id()) {
            $user->gender = $request->input('gender');
            $user->save();

            return redirect()->back()->with('success', 'Gender updated successfully!');
        }

        return redirect()->back()->with('error', 'Unauthorized action.');
    }




    public function editPasswordReset()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
    
        // Return the password reset view
        return view('settings.password_reset', compact('user'));
    }
    


    public function changePassword(Request $request)
    {

       

        // Validate the input
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed', // Ensure it matches confirm_password
        ]);
    
        $user = Auth::user();
    
        // Check if the old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'The provided password does not match your current password.']);
        }
    
        // Update the password
        $user->password = Hash::make($request->new_password);

        $user->save();
    
        return redirect()->route('settings.index')->with('success', 'Your password has been changed successfully.');
    }




    public function editProfilePicture()
    {
        // Ensure the authenticated user can only edit their profile
        $user = auth()->user();
        
        // Pass the user data to the view if needed
        return view('settings.profile_picture', compact('user'));
    }
    

    public function updateProfilePicture(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust size and formats as needed
        ]);
    
        // Ensure the authenticated user can only update their profile
        $user = auth()->user();
    
        // If there's an existing profile picture, delete it
        if ($user->profile->profile_picture) {
            Storage::delete($user->profile->profile_picture);
        }
    
        // Store the new profile picture
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
    
        // Update the user's profile picture path in the database
        $user->profile->profile_picture = $path;
        $user->profile->save();
    
        // Redirect back with a success message
        return redirect()->route('profiles.show', ['profile' => $user->profile])->with('success', 'Profile picture updated successfully.');
    }

    
}
