<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reply;
use App\Models\Comment;
use App\Models\Content;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // ProfileController.php

    public function userProfileLoad()
    {
        if (Auth::check()) {
            $user = auth()->user();
            return $this->loadProfileView($user);
        } else {
            return redirect('login');
        }
    }


    public function showProfile(int $user_id)
    {
        $user = User::findOrFail($user_id);
        return $this->loadProfileView($user);
    }

    private function loadProfileView($user)
    {
        $profile = $user->profile;
        $contents = Content::where('user_id', $user->id)->withCount('likes', 'comments')->orderBy('created_at', 'desc')->get();
        $comments = Comment::orderBy('id', 'desc')->get();

        // Get the IDs of contents that the logged-in user has commented on, excluding their own content
        $commentedContentsIds = Comment::where('user_id', $user->id)->whereHas('content', function ($query) use ($user) {
            $query->where('user_id', '!=', $user->id);
        })->pluck('content_id');
        $replies = Content::whereIn('id', $commentedContentsIds)->with(['comments' => function ($query) {
            return $query->where('parent_id', null);
        }])->withCount('comments', 'likes')->get();
        $likedContents = auth()->check() ? auth()->user()->likes->pluck('id')->toArray() : [];
        $isOwner = auth()->check() && $user->id === auth()->id();
        $users = User::with('profile')->where('id', '!=', auth()->id())->get();
        $totalContents = $contents->count();

        return view('Profile', compact('isOwner', 'users', 'profile', 'user', 'contents', 'likedContents', 'comments', 'replies', 'totalContents'));
    }

    public function userProfile(Request $request)
    {
        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'firstname'       => 'nullable|string|max:255',
            'lastname'        => 'nullable|string|max:255',
            'bio'             => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            // Combine all error messages into one string
            $errorMessages = implode(' ', $validator->errors()->all());
            return redirect()->back()->withInput()->with('error', $errorMessages);
        }

        // Attempt to update the profile
        try {
            $user    = Auth::user();
            $profile = Profile::where('user_id', $user->id)->first();

            if (!$profile) {
                $profile          = new Profile();
                $profile->user_id = $user->id;
            }

            if ($request->hasFile('profile_picture')) {
                $file                     = $request->file('profile_picture');
                $filename                 = time() . '.' . $file->getClientOriginalExtension();
                $profile->profile_picture = $filename;
                $file->move('uploads/profile/', $filename);
            }

            $profile->firstname = $request->input('firstname');
            $profile->lastname  = $request->input('lastname');
            $profile->bio       = $request->input('bio');

            // $profile->nonExistentProperty = 'This will cause an exception';

            $profile->save();

            return redirect()->route('userProfile')->with('message', 'Profile updated successfully');
        } catch (\Exception $e) {
            Log::error('Profile Update Error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while updating your profile. Please try again.');
        }
    }

    public function editProfile()
    {
        // Retrieve the authenticated user's profile
        $user = auth()->user();
        $profile = auth()->user()->profile;
        $users = User::with('profile')->where('id', '!=', auth()->id())->get();

        return view('edit', compact('profile', 'users', 'user'));
    }
}
