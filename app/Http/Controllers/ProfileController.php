<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
// use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
  
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            $search = $request->input('search');
            $perPage = $search ? 100000 : 10;
    
            // Base query with ordering by Profile's created_at
            $profilesQuery = Profile::with(['user:id,name,email'])
                ->orderBy('created_at', 'desc'); // Order by Profile's created_at
    
            // Apply search filters
            if ($search) {
                $profilesQuery->when($search, function ($query) use ($search) {
                    $query->where('location', 'like', '%' . $search . '%')
                        ->orWhere('phone_number', 'like', '%' . $search . '%')
                        ->orWhere('date_of_birth', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($subQuery) use ($search) {
                            $subQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        });
                });
            }
    
            // Paginate results based on search
            $profiles = $profilesQuery->paginate($perPage);
    
            return view('profiles.index', compact('profiles', 'search'));
        } else {
            return redirect()->route('login');
        }
    }
    
    


public function create()
    {
      if (auth()->check()){
        // Check if a profile already exists for the authenticated user
        $profile = Profile::where('user_id', auth()->user()->id)->first();

        // If a profile exists, redirect to the home page
        if ($profile) {
            return redirect()->route('home')->with('error', 'The profile information already exist');
        }else{
          return view('profiles.create');
        }
      }else{
        return redirect()->route('login');
      }
        }

    




    public function store(StoreProfileRequest $request)
    {
        $data = $request->validated();

        // Upload profile picture
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        Profile::create($data);

        return redirect()->route('profiles.index')->with('success', 'Profile created successfully.');
    }






    public function show(Profile $profile)
    {
        return view('profiles.show', compact('profile'));
    }
    




//     public function edit(Profile $profile)
//     {
      
// if (auth()->check() && (auth()->user()->role === 'admin' || (auth()->user()->role === 'student' && $profile->user_id === auth()->user()->id))) {
// return view('profiles.edit', compact('profile'));
// } else {
//     return redirect()->route('home');
// }

//     }








//     public function update(UpdateProfileRequest $request, Profile $profile)
//     {
//         $data = $request->validated();

//         // Upload profile picture
//         if ($request->hasFile('profile_picture')) {
//             $data['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
//         }

//         $profile->update($data);

//         return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');
//     }




    public function destroy(Profile $profile)
    {
        $profile->delete();

        return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully.');
    }
}
