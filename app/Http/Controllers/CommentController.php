<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reply;
use App\Models\Comment;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class CommentController extends Controller
{

  public function store(Request $request)
  {
    $request->validate([
      'comment_body' => 'required|string|max:255',
      'content_id'   => 'required|integer|exists:contents,id',
      'parent_id'    => 'nullable|integer|exists:comments,id'
    ]);

    try {
      $comment               = new Comment();
      $comment->content_id   = $request->content_id;
      $comment->user_id      = Auth::user()->id;
      $comment->comment_body = $request->comment_body;
      $comment->parent_id    = $request->parent_id ?? null;
      // $comment->reply_id = 'test';
      $comment->save();

      if ($request->parent_id) {
        // If this is a reply, redirect to the showReplies route
        return redirect()->route('showReplies', ['id' => $request->parent_id])
          ->with('message', 'Reply Posted Successfully!');
      } else {
        // If this is a new comment, redirect back to the comment page
        return redirect()->route('comment', ['id' => $comment->content_id])
          ->with('message', 'Comment Posted Successfully!');
      }
    } catch (\Exception $e) {
      // Log the error message for debugging purposes
      Log::error('Comment Store Error: ' . $e->getMessage());

      return redirect()->back()->with('error', 'An error occurred while posting your comment. Please try again.');
    }
  }

  public function show($id)
  {
    $content = Content::with(['comments' => function ($query) {
      return $query->where('parent_id', null);
    }])->withCount('likes')->findOrFail($id);
    $comments = $content->comments;

    $user = auth()->user();
    $likedContents = $user->likes->pluck('content_id')->toArray();
    $totalLikesCount = $content->likes->count();
    $users = User::with('profile')->where('id', '!=', auth()->id())->get();

    foreach ($comments as $comment) {
      $comment->reply_count = Comment::where('parent_id', $comment->id)->count();
    }
    return view('comment', compact('content', 'users', 'comments', 'likedContents', 'totalLikesCount'));
  }

  public function showReplies($id)
  {
    $reply = Comment::findOrFail($id);
    $content = Content::findOrFail($reply->content_id);
    $replies = Comment::where('parent_id', $reply->id)->get();
    $replyCount = $replies->count();

    $users = User::with('profile')->where('id', '!=', auth()->id())->get();

    // Add reply counts to each reply if needed
    foreach ($replies as $nestedReply) {
      $nestedReply->reply_count = Comment::where('parent_id', $nestedReply->id)->count();
    }

    return view('replies', compact('reply', 'users', 'replies', 'content', 'replyCount'));
  }

  // CommentController.php

  // public function edit(Request $request, $id)
  // {
  //   $request->validate([
  //     'comment_body' => 'required|max:255',
  //   ]);

  //   $reply = Comment::findOrFail($id);
  //   $reply->comment_body = $request->comment_body;
  //   $reply->save();

  //   return redirect()->back()->with('message', 'Reply updated successfully!');
  // }

  // public function remove($id)
  // {
  //   $reply = Comment::findOrFail($id);
  //   $reply->delete();

  //   return redirect()->back()->with('message', 'Comment deleted successfully!');
  // }

  public function remove($id)
  {
    $reply = Comment::findOrFail($id);
    $reply->delete();

    return redirect()->back()->with('message', 'Reply deleted successfully!');
  }

  public function edit(Request $request, $id)
  {
    $request->validate([
      'comment_body' => 'required|max:255',
    ]);

    $reply = Comment::findOrFail($id);
    $reply->comment_body = $request->comment_body;
    $reply->save();

    return redirect()->back()->with('message', 'Reply updated successfully!');
  }
  // ReplyController.php

  // public function editreply(Request $request, $id)
  // {
  //   $reply = Comment::findOrFail($id);
  //   $reply->comment = $request->input('editedReply');
  //   $reply->save();

  //   return redirect()->back()->with('message', 'Reply updated successfully.');
  // }

  // CommentController.php
  public function update(Request $request, $id)
  {
    $request->validate([
      'comment_body' => 'required|string|max:255',
    ]);

    $comment = Comment::findOrFail($id);
    $comment->comment_body = $request->comment_body;
    $comment->save();

    return redirect()->back()->with('message', 'Comment updated successfully!');
  }

  public function destroy($id)
  {
    $comment = Comment::findOrFail($id);
    $comment->delete();

    return redirect()->back()->with('message', 'Comment deleted successfully!');
  }

  // public function destroy(Request $request)
  // {
  //   if (Auth::check()) {
  //     $comment = Comment::where('id', $request->comment_id)->where('user_id', Auth::user()->id)->first();
  //     if ($comment) {
  //       $comment->delete();
  //     }

  //     return response()->json([
  //       'status' => 200,
  //       'message' => 'Comment Deleted Successfully'

  //     ]);
  //   } else {
  //     return response()->json([
  //       'status'   => 401,
  //       'message'  => 'Login to delete this comment'
  //     ]);
  //   }
  // }
  // public function remove(Request $request)
  // {
  //   if (Auth::check()) {
  //     $reply = Comment::where('id', $request->reply_id)->where('user_id', Auth::user()->id)->first();
  //     if ($reply) {
  //       $reply->delete();
  //     }

  //     return response()->json([
  //       'status' => 200,
  //       'message' => 'reply Deleted Successfully'

  //     ]);
  //   } else {
  //     return response()->json([
  //       'status' => 401,
  //       'message' => 'Login to delete this reply'
  //     ]);
  //   }
  // }



  // public function showReply($id)
  // {
  //   $comment = Comment::findOrFail($id);

  //   $content = Content::findOrFail($comment->content_id);
  //   $replies = Comment::where('parent_id', $comment->id)->get();
  //   $replyCount = $replies->count(); // Count the number of replies

  //   $users = User::with('profile')->where('id', '!=', auth()->id())->get(); // Exclude the authenticated use 
  //   // Add reply counts to each reply if needed
  //   foreach ($replies as $reply) {
  //     $reply->reply_count = Comment::where('parent_id', $reply->id)->count();
  //   }
  //   // Set the reply count for the comment being replied to
  //   $comment->reply_count = $replyCount;

  //   return view('reply', compact('comment', 'users', 'replies', 'content', 'replyCount'));
  // }

  // app/Http/Controllers/ReplyController.php



  public function like($id)
  {
    $comment = Comment::findOrFail($id);


    return response()->json([
      'success' => true,
    ]);
  }


  // public function viewProfile($userId)
  // {
  //     // Fetch the user based on the provided user ID
  //     $user = User::find($userId);

  //     // Return the view for the user profile with the user data
  //     return view('auth.layout', compact('user'));
  // }

}
