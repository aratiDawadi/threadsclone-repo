<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function SearchName(Request $request)
    {
        if (Auth::check()) {
            $searchTerm = $request->input('search');
            $query = User::where('id', '!=', auth()->id()); // Exclude logged-in user

            if ($searchTerm) {
                $terms = explode(' ', $searchTerm);
                $query->where(function ($q) use ($terms) {
                    foreach ($terms as $term) {
                        $q->where('firstname', 'LIKE', "%{$term}%")
                            ->orWhere('lastname', 'LIKE', "%{$term}%")
                            ->orWhere('email', 'LIKE', "%{$term}%")
                            ->orWhere('mobile_number', 'LIKE', "%{$term}%")
                            ->orWhere('username', 'LIKE', "%{$term}%");
                    }
                });
            }

            // Apply pagination
            $searchResults = $query->paginate(15);

            if ($request->ajax()) {
                return view('partials.search-results', ['searchResults' => $searchResults])->render();
            }

            // Fetch the users for "People You May Know" excluding the currently authenticated user
            $users = User::with('profile')->where('id', '!=', auth()->id())->get();


            return view('search', ['searchResults' => $searchResults, 'users' => $users]);
        } else {
            return redirect('login');
        }
    }
}
