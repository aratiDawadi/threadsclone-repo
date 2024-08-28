@extends('layout')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('site/search.css') }}">

@section('content')
    <div class="search d-flex flex-column flex-grow-1">
        <div class="search_header">
            <h2>Search</h2>
        </div>
        <form action="{{ route('search') }}" method="GET">
            <div class="searchbar">
                <i class="fa fa-search search-icon"></i>
                <input class="searchbar_input" id="searchInput" name="search" placeholder="Search">
            </div>
        </form>
        <div id="search-results-container">
            @include('partials.search-results', ['searchResults' => $searchResults])
        </div>
    </div>
@endsection
