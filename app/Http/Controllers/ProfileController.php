<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\PlumberProfile;
use App\Models\ElectricianProfile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->role === 'plumber') {
            $profilePlumber = new PlumberProfile();
            $profilePlumber->full_name = $request->full_name;
            $profilePlumber->experience = $request->experience;
            $profilePlumber->skill = $request->skill;
            $profilePlumber->service_area = $request->service_area;
            $profilePlumber->hourly_rate = $request->hourly_rate;
            $profilePlumber->contact_number = $request->contact_number;
    
            $plumberImage = $request->file('plumber_image');
            $imageName = time() . '.' . $plumberImage->getClientOriginalExtension();
            $plumberImage->move(public_path('uploads/plumber_image'), $imageName);
    
            $profilePlumber->plumber_image = $imageName;
            $profilePlumber->created_by = Auth::id();
            $profilePlumber->save();
    
            $profile = new Profile();
            $profile->user_id = Auth::id();
            $profile->profile_id = $profilePlumber->id;
            $profile->role = $request->role;
            $profile->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Record Get Successfully',
                'profile' => $profile,
                'profilePlumber' => $profilePlumber
            ]);
        }elseif ($request->role === 'electrician') {
            $electricianProfile = new ElectricianProfile();
            $electricianProfile->full_name = $request->full_name;
            $electricianProfile->experience = $request->experience;
            $electricianProfile->skill = $request->skill;
            $electricianProfile->service_area = $request->service_area;
            $electricianProfile->hourly_rate = $request->hourly_rate;
            $electricianProfile->contact_number = $request->contact_number;
    
            $electricianImage = $request->file('electrician_image');
            $imageName = time() . '.' . $electricianImage->getClientOriginalExtension();
            $electricianImage->move(public_path('uploads/electrician_image'), $imageName);
    
            $electricianProfile->electrician_image = $imageName;
            $electricianProfile->created_by = Auth::id();
            $electricianProfile->save();
    
            $profile = new Profile();
            $profile->user_id = Auth::id();
            $profile->profile_id = $electricianProfile->id;
            $profile->role = $request->role;
            $profile->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Record Get Successfully',
                'profile' => $profile,
                'electricianProfile' => $electricianProfile
            ]);
        } 
        
        elseif ($request->role === 'user') {
            $user = new UserProfile();
            $user->full_name = $request->full_name;
            $user->short_bio = $request->short_bio;
            $user->location = $request->location;
            $user->contact_number = $request->contact_number;
    
            $userImage = $request->file('user_image');
            $imageName = time() . '.' . $userImage->getClientOriginalExtension();
            $userImage->move(public_path('uploads/user_image'), $imageName);
    
            $user->user_image = $imageName;
            $user->save();
    
            $profile = new Profile();
            $profile->user_id = Auth::id();
            $profile->profile_id = $user->id;
            $profile->role = $request->role;
            $profile->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Record Get Successfully',
                'profile' => $profile,
                'user' => $user
            ]);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
