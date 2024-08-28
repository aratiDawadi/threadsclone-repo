<?php

// Handle the user login attempt.
namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Comment;
use App\Models\User;
use App\Models\Content;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
  public function login(Request $request)
  {
    // Validate the login request
    $request->validate([
      'email'    => 'required|email',
      'password' => 'required|min:6',
    ]);
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      return redirect::route('dashboard')->with('message', 'Loged in!');
    } else {
      return redirect()->back()->with('error', 'Invalid Email or Password')->withInput();
    }
  }
  public function dashboard()
  {
    if (Auth::check()) {
      // Fetch all the contents with pagination
      $contents = Content::withCount(['comments' => function ($query) {
        $query->whereNull('comments.deleted_at'); // Ensure soft-deleted comments are not counted
      }, 'likes', 'comments'])
        ->orderByDesc('id')
        ->paginate(4);

      // Get the IDs of contents liked by the user
      $user = auth()->user();
      $likedContents = $user->likes->pluck('content_id')->toArray();

      $users = User::with('profile')->where('id', '!=', auth()->id())->get();

      return view('dashboard', compact('contents', 'users', 'likedContents'));
    } else {
      return redirect('login');
    }
  }
}
