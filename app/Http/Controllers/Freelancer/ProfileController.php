<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->freelancer;

        return view(
            'freelancer.profile.edit',
            [
                'user' => $user,
                'profile' => $profile,
            ]
        );
    }
    public function update(Request $request)
    {

        $request->validate([
            'first_name' => ['required'],
        ]);
        $user = Auth::user();
        return $user->freelancer->birthday->format('d/m/Y ');

        $profile =  $user->freelancer()->findOrFail($user->id);
        $data = $request->except('profile_photo');
        if(empty(!$this->uploadProfilePhoto($request))) {
            Storage::disk('uploads')->delete($user->freelancer->profile_photo_path);
            $data['profile_photo_path'] = $this->uploadProfilePhoto($request);

            }



        $profile->updateOrCreate([
            'user_id' => $user->id,
        ], $data);

        $user->forceFill([
            'name' =>  $data['first_name'] . ' ' . $data['last_name'],
        ])->save();

        return redirect()->route('freelancer.profile.edit')
            ->with('success', 'profile updated');
    }

    protected function uploadProfilePhoto(Request $request)
    {
        if (!$request->hasFile('profile_photo')):
            return;
        endif;

        $file = $request->file('profile_photo');
        if (!$file->isValid()):
            return;
        endif;

        return  $file->store('/profile_photo', [
            'disk' => 'uploads'
        ]);
    }
}
