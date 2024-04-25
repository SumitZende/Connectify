<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function  index(User $user)
    {
        return Inertia::render('Profile/View', [
            'mustVerifyEmail' => $user   instanceof MustVerifyEmail,
            'status' => session('status'),
            'success'=> session('success'),
            'user'=> new UserResource($user)
        ]);
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return to_route('profile',$request->user())->with('success',"Your Profile Details are Updated Successfully !!!");
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public  function  updateImages(Request $request)
    {
        $data = $request->validate([
            'cover'=>['nullable','image'],
            'avatar'=>['nullable','image']
        ]);
        $avatar =$data['avatar'] ?? null;
        /** @var UploadedFile $cover */
        $cover = $data['cover'] ?? null;
        $user = $request->user();
        $success="";
        if($cover){
            if($user->cover_path){
                Storage::disk('public')->delete($user->cover_path);
            }
            $path =$cover->store('userCover-'.$user->id,'public');
            $user->update(['cover_path' => $path]);
            $success="Cover Image Updated Successfully !!";
        }
        if($avatar){
            if($user->avatar_path){
                Storage::disk('public')->delete($user->avatar_path);
            }
            $path =$avatar->store('userAvatar-'.$user->id,'public');
            $user->update(['avatar_path' => $path]);
            $success="Avatar Updated Successfully !!";
        }

        return back()->with('success',$success);


    }
}
