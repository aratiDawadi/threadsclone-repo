<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $request, Content $content)
    {
        $user  = auth()->user();
        $liked = false;
        if ($user->likes()->where('content_id', $content->id)->exists()) {
            $user->likes()->detach($content);
        } else {
            $user->likes()->attach($content);
            $liked = true;
        }
        $likesCount = $content->likes()->count();

        return response()->json([
            'likes_count'  => $likesCount,
            'liked'        => $liked
        ]);
    }

    public function likedStatus(Content $content)
    {
        // Check if the authenticated user has liked this content
        $liked = auth()->user()->likes()->where('content_id', $content->id)->exists();
        return response()->json([
            'liked' => $liked
        ]);
    }
}
