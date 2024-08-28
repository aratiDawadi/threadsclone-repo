<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    public function CreateLoad()
    {
        if (Auth::check()) {
            return view('auth.create-thread');
        } else {
            return redirect('login');
        }
    }

    public function showPost(Request $request)
    {
        // Custom validation to ensure at least one of 'content' or 'image' is provided
        if (empty($request->input('content')) && !$request->hasFile('image')) {
            return redirect()->back()->withInput()->with('error', 'Please add content or an image and try again.');
        }

        $validator    =  Validator::make($request->all(), [
            'content' => 'nullable|string|max: 255',
            'image'   => 'nullable|mimes:jpeg,png,jpg,gif|max: 2048',
        ]);

        if ($validator->fails()) {
            // Combine all error messages into one string
            $errorMessages = implode(' ', $validator->errors()->all());
            return redirect()->back()->withInput()->with('error', $errorMessages);
        }

        try {
            $content          = new Content();
            $content->content = $request->input('content');
            $content->user_id = Auth::user()->id;

            if ($request->hasFile('image')) {
                $file           = $request->file('image');
                $filename       = time() . '.' . $file->getClientOriginalExtension();
                $content->image = $filename;
                $file->move('uploads/image/', $filename);
            }
            $content->save();

            return redirect()->back()->with('message', 'Content posted successfully');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Content Post Error: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->withInput()->with('error', 'An error occurred while posting your content. Please try again.');
        }
    }

    public function deleteContent(int $id)
    {
        // Find the content by ID
        $content = Content::findOrFail($id);

        // Delete the content
        $content->delete();

        return redirect()->back()->with('message', 'Content deleted successfully');
    }

    /*
    find content
    validate content
    update the content with edited content from the request

    */
    public function editContent(Request $request, $id)
    {
        try {
            $content = Content::findOrFail($id);

            // Validate the request
            $request->validate([
                'editedContent' => 'required|string|max:255',
            ]);

            // Update the content with the edited content from the request
            $content->content = $request->editedContent;
            $content->save();
            return redirect()->back()->with('message', 'Content updated successfully');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Content Update Error: ' . $e->getMessage());

            // Redirect back with an error message, old input, and content ID
            return redirect()->back()->withErrors(['editedContent' => $e->getMessage()])->withInput()->with('content_id', $id);
        }
    }
}
