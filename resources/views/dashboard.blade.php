@extends('layout')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('site/dashboard.css') }}"> --}}
<script src="{{ asset('js/dashboard.js') }}"></script>

<style>
    .post {
        background-color: #101012;
        padding: 20px;
        border-radius: 10px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        box-sizing: border-box;
        width: calc(177% - 30px);
        max-width: 1000px;
        margin: 0 auto;
        margin-left: 15px;
        margin-right: 15px;
    }

    .post-content {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .post p {
        color: #ffffff;
        margin: 0;
    }

    .user-details {
        display: flex;
        flex-direction: column;

    }

    .menu-icon {
        position: relative;
        margin-left: auto;
    }

    .dropdown-menu {
        top: 20px;
        left: -90px;
    }

    .dropdown-item {
        cursor: pointer;
    }

    .dropdown-item:hover {
        background-color: #9b9e9c;
    }

    .post img {
        width: 100%;
        height: auto;
        border-radius: 20px;
    }

    .feed {
        padding: 20px;
    }

    .feed1 {
        padding: 20px;
    }

    .feed1 h2 {
        font-weight: bold;
        margin-top: 10px;
        margin-bottom: -10px;
        margin-left: 15px;
    }

    .user-profile2 p {
        margin-left: 60px;
        margin-top: -10px;
        color: #888;
        font-size: 14px;
    }

    .user-profile2 {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-profile2 img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        margin-top: -30px;
    }

    .user-profile2 .username {
        font-size: 17px;
        font-weight: bold;
    }

    .username {
        font-size: 17px;
        font-weight: bold;
        color: #ffffff;
    }

    .timestamp {
        font-size: 14px;
        color: #888;
    }

    .content {
        gap: 10px;
        margin-top: 15px;
    }

    .post-icons {
        display: flex;
        align-items: center;
        font-size: 20px;
        cursor: pointer;

    }

    .post-icons span {
        margin-left: 28px;
        margin-top: 10px;
        align-items: center;
        text-decoration: none;

    }

    .menu-icon {
        cursor: pointer;
        margin-left: 630px;
        margin-top: -7px;
    }

    .pagination-container {
        justify-content: center;
        display: flex;
    }

    .pagination {
        display: inline-block;
    }

    .fa-comment {
        font-size: 20px;
        margin-left: 10px;
        text-decoration: none;
    }

    .like-icon.liked span {
        color: red;
    }

    .likes-list {
        margin-top: 10px;
    }

    .like-icon.liked .material-symbols-outlined {
        color: red;
    }

    .material-icons-outlined {
        {{-- margin-left: 90px; --}}
    }

    .latest-like p {
        font-size: 15px;
        color: #ffffff;
        font-family: 'Arial', sans-serif;
        margin-left: 60px;
        margin-top: -10px;
        cursor: pointer;
    }

    .like-icon.liked {
        color: red;
    }

    .like-count {
        margin-left: 50px;
    }

    .liked-users p {
        margin: 7px;
        margin-left: 55px;
    }
</style>

@section('content')
    <div class="feed1">
        <h2> Home</h2>
    </div>
    @foreach ($contents as $content)
        <!-- Feed -->
        <a href="{{ route('user.Profile', ['user_id' => $content->user->id]) }}" class="post-link"
            style="text-decoration: none; color: inherit;">
            <div class="feed col-md-7">
                <div class="post">
                    @if ($content->user_id === auth()->id())
                        <div class="dropdown menu-icon">
                            <button class="btn btn-secondary dropdown-toggle" style="background-color:101012; "type="button"
                                id="dropdownMenuButton_{{ $content->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                &#8226;&#8226;&#8226;
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark"
                                aria-labelledby="dropdownMenuButton_{{ $content->id }}">
                                <li>
                                    <form id="deleteForm_{{ $content->id }}"
                                        action="{{ route('deleteContent', ['id' => $content->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item button-delete"
                                            onclick="submitForm(event, '{{ $content->id }}')">Delete</button>
                                    </form>
                                </li>
                                <li>
                                    <form id="editForm_{{ $content->id }}"
                                        action="{{ route('editContent', ['id' => $content->id]) }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item button-edit" type="button"
                                            onclick="openEditModal(event, '{{ $content->id }}', '{{ $content->content }}')">Edit</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif

                    <!-- User Profile Picture and Name -->
                    <div class="post-content">
                        <div class="user-profile2">
                            @if ($content->user->profile && $content->user->profile->profile_picture)
                                <img src="{{ asset('uploads/profile/' . $content->user->profile->profile_picture) }}"
                                    alt="Profile Picture">
                            @else
                                <!-- Default Profile Picture -->
                                <img src="" alt="Default Profile Picture">
                            @endif
                            <div class="user-details">
                                <span class="username">{{ $content->user->firstname }}
                                    {{ $content->user->lastname }}</span>
                                <span class="timestamp">{{ $content->created_at->diffForHumans() }}</span>
                                <span class="content">{{ $content->content }}</span>
                            </div>
                        </div>
                        {{-- <p>{{ $content->content }}</p> --}}
                        @if ($content->image)
                            <img src="{{ asset('uploads/image/' . $content->image) }}" alt="">
                        @endif

                        <div class="post-icons">
                            <span onclick="likeContent(event, {{ $content->id }})" id="like-icon-{{ $content->id }}"
                                class="like-icon {{ in_array($content->id, $likedContents) ? 'liked' : '' }}"
                                data-content-id="{{ $content->id }}">
                                <span class="material-icons outlined">favorite</span>
                            </span>
                            <form action="{{ route('content.like', $content->id) }}" method="POST" style="display:none"
                                id="like-form-{{ $content->id }}">
                                @csrf
                            </form>
                            <span id="like-count-{{ $content->id }}"
                                class="like-count">{{ $content->likes_count }}</span>
                            <a href="{{ route('comment', ['id' => $content->id]) }}">
                                <span style="color:white;"class="fas fa-comment"></span>
                            </a>
                            <span class="comment-count">{{ $content->comments->count() }}</span>
                        </div>

                        @if ($content->likes->count() > 0)
                            <div class="latest-like">
                                <p>Liked by:
                                    @php
                                        $latestLike = $content->likes->last();
                                        $remainingLikes = $content->likes->where('id', '!=', $latestLike->id);
                                        $remainingLikesCount = $remainingLikes->count();
                                    @endphp
                                    @if ($latestLike)
                                        {{ $latestLike->user->firstname }} {{ $latestLike->user->lastname }}
                                    @endif
                                    @if ($remainingLikesCount > 0)
                                        and <strong id="other-likes-link-{{ $content->id }}"
                                            onclick="toggleLikedUsers(event, {{ $content->id }}, 'content')">{{ $remainingLikesCount }}
                                            others</strong>
                                    @endif
                                </p>
                                <div id="liked-users-content-{{ $content->id }}" class="liked-users"
                                    style="display: none;">
                                    @foreach ($remainingLikes as $like)
                                        <p>{{ $like->user->firstname }}
                                            {{ $like->user->lastname }}
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @include('comment-section', ['content_id' => $content->id])
                    </div>
                </div>
            </div>
        </a>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal_{{ $content->id }}" tabindex="-1"
            aria-labelledby="editModalLabel_{{ $content->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 style="color: black;" class="modal-title fs-5" id="editModalLabel_{{ $content->id }}">Edit
                            Content</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="content">
                            <div class="comment-box">
                                <form action="{{ route('editContent', ['id' => $content->id]) }}" method="POST">
                                    @csrf
                                    <textarea id="editedContent_{{ $content->id }}" name="editedContent" rows="8" class="form-control">{{ $content->content }}</textarea>
                                    <div id="editContentValidationMessage_{{ $content->id }}"
                                        style="display: none; color: red; margin-top: 5px;">
                                        Edit content should not exceed 255 characters.
                                    </div>
                                    <button class="btn btn-light" type="submit">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="pagination-container">
        @if (session('page'))
            {{ $contents->appends(['page' => session('page')])->links() }}
        @else
            {{ $contents->links() }}
        @endif
    </div>

    <!-- Embed data in a script tag -->
    <script>
        window.contents = @json($contents->pluck('id'));
    </script>
@endsection
