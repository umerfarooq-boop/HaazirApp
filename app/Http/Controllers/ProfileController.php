<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\PlumberProfile;
use App\Models\ElectricianProfile;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::with(['plumberProfile', 'electricianProfile', 'userProfile'])->get();

        $data = $profiles->map(function ($profile) {
            if ($profile->role === 'plumber' && $profile->plumberProfile) {
                $imageFile = $profile->plumberProfile->plumber_image;
                $imagePath = public_path('uploads/plumber_image/' . $imageFile);

                return [
                    'full_name' => $profile->plumberProfile->full_name,
                    'experience' => $profile->plumberProfile->experience,
                    'hourly_rate' => $profile->plumberProfile->hourly_rate,
                    'service_area' => $profile->plumberProfile->service_area,
                    'skill' => $profile->plumberProfile->skill,
                    'contact_number' => $profile->plumberProfile->contact_number,
                    'image' => file_exists($imagePath) && !empty($imageFile)
                        ? url('uploads/plumber_image/' . $imageFile)
                        : url('uploads/defaults/no-image.png'),
                    'role' => $profile->role,
                    'profile_id' => $profile->profile_id
                ];
            } elseif ($profile->role === 'electrician' && $profile->electricianProfile) {
                return [
                    'full_name' => $profile->electricianProfile->full_name,
                    'experience' => $profile->electricianProfile->experience,
                    'hourly_rate' => $profile->electricianProfile->hourly_rate,
                    'service_area' => $profile->electricianProfile->service_area,
                    'skill' => $profile->electricianProfile->skill,
                    'contact_number' => $profile->electricianProfile->contact_number,
                    'image' => url('uploads/electrician_image/' . $profile->electricianProfile->electrician_image),
                    'role' => $profile->role,
                    'profile_id' => $profile->profile_id
                ];
            } elseif ($profile->role === 'user' && $profile->userProfile) {
                return [
                    'full_name' => $profile->userProfile->full_name,
                    'short_bio' => $profile->userProfile->short_bio,
                    'location' => $profile->userProfile->location,
                    'contact_number' => $profile->userProfile->contact_number,
                    'image' => url('uploads/user_image/' . $profile->userProfile->user_image),
                    'role' => $profile->role,
                    'profile_id' => $profile->profile_id
                ];
            }
            return null;
        })->filter();

        return response()->json([
            'success' => true,
            'data' => $data->values(),
        ]);
    }

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

            $destinationPath = public_path('uploads/plumber_image');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $plumberImage = $request->file('plumber_image');
            $imageName = time() . '.' . $plumberImage->getClientOriginalExtension();
            $plumberImage->move($destinationPath, $imageName);

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
                'message' => 'Plumber profile created successfully',
                'profile' => $profile,
                'profilePlumber' => $profilePlumber,
            ]);
        } elseif ($request->role === 'electrician') {
            $electricianProfile = new ElectricianProfile();
            $electricianProfile->full_name = $request->full_name;
            $electricianProfile->experience = $request->experience;
            $electricianProfile->skill = $request->skill;
            $electricianProfile->service_area = $request->service_area;
            $electricianProfile->hourly_rate = $request->hourly_rate;
            $electricianProfile->contact_number = $request->contact_number;

            $destinationPath = public_path('uploads/electrician_image');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $electricianImage = $request->file('electrician_image');
            $imageName = time() . '.' . $electricianImage->getClientOriginalExtension();
            $electricianImage->move($destinationPath, $imageName);

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
                'message' => 'Electrician profile created successfully',
                'profile' => $profile,
                'electricianProfile' => $electricianProfile,
            ]);
        } elseif ($request->role === 'user') {
            $userProfile = new UserProfile();
            $userProfile->full_name = $request->full_name;
            $userProfile->short_bio = $request->short_bio;
            $userProfile->location = $request->location;
            $userProfile->contact_number = $request->contact_number;

            $destinationPath = public_path('uploads/user_image');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $userImage = $request->file('user_image');
            $imageName = time() . '.' . $userImage->getClientOriginalExtension();
            $userImage->move($destinationPath, $imageName);

            $userProfile->user_image = $imageName;
            $userProfile->save();

            $profile = new Profile();
            $profile->user_id = Auth::id();
            $profile->profile_id = $userProfile->id;
            $profile->role = $request->role;
            $profile->save();

            return response()->json([
                'success' => true,
                'message' => 'User profile created successfully',
                'profile' => $profile,
                'userProfile' => $userProfile,
            ]);
        }
    }

    public function checkProfile($userId)
    {
        $profile = Profile::with(['userProfile','electricianProfile','plumberProfile'])->where('profile_id', $userId)->get();

        return response()->json([
            'success' => true,
            'message' => 'Record Found',
            'profile' => $profile
        ],201);

        // if ($profile) {
        //     return response()->json([
        //         'profile_exists' => true,
        //         'profile' => $profile,
        //     ]);
        // } else {
        //     return response()->json([
        //         'profile_exists' => false,
        //     ]);
        // }
    }

    // Create button where upload image of problem and send this same request to role wise ServiceProvider like Electrician
    // Plumber 

    // Create button where upload image of problem and send this same request to role wise ServiceProvider like Electrician
    // Plumber 


    // 🚫 Removed live location function here (as per your request)
}
