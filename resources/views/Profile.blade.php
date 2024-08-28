@extends('layout')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('site/profile.css') }}"> --}}
<script src="{{ asset('js/profile.js') }}"></script>
<!-- In your main layout file or the specific Blade template -->
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">


<style>
    .post {
        background-color: #101012;
        padding: 20px;
        border-radius: 10px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        box-sizing: border-box;
        width: calc(176% - 30px);
        max-width: 1000px;
        margin: 0 auto;
        margin-left: 15px;
        margin-right: 15px;
    }

    .profile-card {
        display: flex;
        align-items: flex-start;
        border-radius: 15px;
        padding: 30px;
        position: relative;
    }

    .profile-picture {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-top: 25px;
    }

    .details-container {
        display: flex;
        flex-direction: column;
        margin-left: 20px;
        /* Adjust as needed */
    }

    /* Tabs container */
    .tabs {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        width: 800px;
        margin-left: 29px;
    }

    .tab {
        flex: 1;
        padding: 10px;
        text-align: center;
        background-color: #101012;
        cursor: pointer;
        border: none;
        outline: none;
        transition: background-color 0.3s ease;
    }

    .tab.active,
    .tab:hover {
        background-color: #333333;
    }

    .badge {
        background-color: rgba(59, 130, 246, 0.5);
        border-radius: 12px;
        padding: 5px 8px;
        margin-left: 5px;
        font-size: 15px;
        vertical-align: middle;
    }

    .h {
        width: 800px;
        margin-left: 28px;
    }

    .material-icons.filled {
        color: red;
    }

    .details-container {
        display: flex;
        flex-direction: column;
        margin-left: 1.5rem;
        flex: 1;
    }

    .additional-info {
        margin-top: 35px;
        margin-left: -125px;
    }

    .bio {
        font-size: 18px;
    }

    .edit-profile-icon {
        top: 20px;
        margin-top: 30px;
        right: 20px;
        background-color: #101012;
        border-radius: 5px;
        padding: 10px 20px;
        color: white;
        text-align: center;
        cursor: pointer;
        font-size: 20px;
    }

    .edit-profile-icon a {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .edit-profile-icon a i {
        margin-right: 5px;
    }

    .edit-profile-icon a:hover {
        color: white;
        text-decoration: none;
    }

    .post img {
        width: 100%;
        height: 60%;
        border-radius: 20px;
    }

    .post p {
        color: #ffffff;
        margin-top: -10px;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .feed {
        padding: 20px;
    }

    .join {
        background-color: black;
        color: white;
        text-align: center
    }

    .user-profile2 p {
        margin-left: 55px;
        margin-top: -10px;
        color: #888;
        font-size: 14px;
    }

    .user-profile2 {
        margin-bottom: 20px;
        text-align: left;
    }

    .user-profile2 img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
    }

    .name-username {
        margin-bottom: 10px;
        margin-top: 30px;
    }

    .fullname {
        font-size: 24px;
        font-weight: bold;
    }

    .username1 {
        font-size: 17px;
        margin-top: 5px;
        color: rgb(105 124 137);
    }

    .date {
        font-size: 16px;
    }

    .user-profile2 .username {
        font-size: 17px;
        font-weight: bold;
    }

    .menu-icon {
        cursor: pointer;
        margin-left: 630px;
        margin-top: -7px;
    }

    .like-icon.liked .material-symbols-outlined {
        color: red;
    }

    .latest-like p {
        font-size: 15px;
        margin-left: 18px;
        margin-top: -5px;
        font-family: 'Arial', sans-serif;
    }

    .post-icons {
        font-size: 20px;
        cursor: pointer;
        margin-left: 33px;
    }

    .post-icons span {
        padding: 8px;
        color: white;
        margin-top: -5px;
    }

    .dropdown {
        margin-left: 700px;
    }

    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }

    .fa-comment {
        font-size: 20px;
        margin-left: 10px;
    }

    .timestamps {
        margin-left: 20px;
    }
</style>


@section('content')
    <div class="profile-card">
        @if ($profile && $profile->profile_picture)
            <img src="{{ asset('uploads/profile/' . $profile->profile_picture) }}" alt="Profile Picture"
                class="profile-picture" />
        @else
            <img src="" alt="Default Profile Picture" class="profile-picture">
        @endif

        <div class="details-container">
            <div class="name-username">
                <span class="fullname">{{ $user->firstname ?? '' }} {{ $user->lastname ?? '' }}</span><br>
                <span class="username1">{{ '@' . $user->username }}</span>
            </div>

            <div class="additional-info">
                <span class="bio">{{ $profile->bio ?? '' }}</span>
                <div class="rounded date">
                    <span class="join">Joined {{ $user->created_at->format('F j, Y') }}</span>
                </div>
            </div>
        </div>

        @if ($isOwner)
            <div class="edit-profile-icon">
                <a href="{{ route('editProfile') }}">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        @endif
    </div>

    <!-- Horizontal line -->
    <hr class="h">
    <!-- Toggle buttons for posts and replies -->
    <div class="tabs">
        <div class="tab active" id="totalPostsTab">Threads<span style="font-size:15px;"
                class="badge">{{ $totalContents }}</span></div>
        <div class="tab" id="repliesTab">Replies</div>
    </div>
    <!-- Container for toggled content -->
    <div id="contentContainer">
        <div id="totalPosts" class="content-section">
            @foreach ($contents as $content)
                <div class="feed col-md-7">
                    <div class="post">
                        @if ($isOwner)
                            <div class="dropdown menu-icon">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton_{{ $content->id }}" data-bs-toggle="dropdown"
                                    style="background-color:101012;"aria-expanded="false">
                                    •••
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark"
                                    aria-labelledby="dropdownMenuButton_{{ $content->id }}">
                                    <li>
                                        <form id="deleteForm_{{ $content->id }}"
                                            action="{{ route('deleteContent', ['id' => $content->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item button-delete" type="submit">Delete</button>
                                        </form>
                                    </li>
                                    <li>
                                        <button class="dropdown-item button-edit" type="button" data-bs-toggle="modal"
                                            data-bs-target="#editModal_{{ $content->id }}">Edit</button>
                                    </li>
                                </ul>
                            </div>
                        @endif

                        {{-- edit Content --}}
                        <div class="modal fade" id="editModal_{{ $content->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel_{{ $content->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 style="color: black;" class="modal-title fs-5"
                                            id="editModalLabel_{{ $content->id }}">
                                            Edit Content</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="content">
                                            <div class="comment-box">
                                                <form action="{{ route('editContent', ['id' => $content->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <textarea id="editedContent_{{ $content->id }}" name="editedContent" rows="8" class="form-control"
                                                        onclick="stopPropagation(event)" onkeypress="stopPropagation(event)">{{ $content->content }}</textarea>
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

                        <div class="user-profile2">
                            @if ($content->user->profile && $content->user->profile->profile_picture)
                                <a href="{{ route('user.Profile', ['user_id' => $content->user->id]) }}">
                                    <img src="{{ asset('uploads/profile/' . $content->user->profile->profile_picture) }}"
                                        alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">
                                </a>
                            @else
                                <a href="{{ route('user.Profile', ['user_id' => $content->user->id]) }}">
                                    <img src="" alt="Default Profile Picture"
                                        style="width: 50px; height: 50px; border-radius: 50%;">
                                </a>
                            @endif
                            <span class="username">{{ $content->user->firstname }} {{ $content->user->lastname }}</span>
                            <p> {{ $content->created_at->diffForHumans() }}</p>
                        </div>

                        <p style="margin-left:50px;">{{ $content->content }}</p>
                        @if ($content->image)
                            <img src="{{ asset('uploads/image/' . $content->image) }}" alt="">
                        @endif

                        <div class="post-icons">
                            <span onclick="likeContent({{ $content->id }})" id="like-icon-{{ $content->id }}"
                                class="like-icon" data-content-id="{{ $content->id }}">
                                @if (in_array($content->id, $likedContents))
                                    <span class="material-icons filled">favorite</span>
                                @else
                                    <span class="material-icons outlined">favorite</span>
                                @endif
                            </span>

                            <form action="{{ route('content.like', $content->id) }}" method="POST" style="display:none"
                                id="like-form-{{ $content->id }}">
                                @csrf
                            </form>
                            <span id="like-count-{{ $content->id }}" style="margin-left:-5px;"
                                class="like-count">{{ $content->likes_count }}</span>
                            <a href="{{ route('comment', ['id' => $content->id]) }}"style="text-decoration: none;">
                                <span class="fas fa-comment"></span>
                            </a>

                            {{ $content->comments->count() }}
                            @if ($content->likes->count() > 0)
                                <div class="latest-like">
                                    <p>Liked by:
                                        @php
                                            $latestLike = $content->likes->last();
                                            if ($latestLike) {
                                                echo $latestLike->user->firstname . ' ' . $latestLike->user->lastname;
                                            }
                                        @endphp

                                        @php
                                            $remainingLikes = $content->likes->where('id', '!=', $latestLike->id);
                                            $remainingLikesCount = $remainingLikes->count();
                                        @endphp
                                        @if ($remainingLikesCount > 0)
                                            and <strong id="other-likes-link-{{ $content->id }}"
                                                onclick="toggleLikedUsers(event, {{ $content->id }}, 'content')">{{ $remainingLikesCount }}
                                                others</strong>
                                        @endif
                                    </p>
                                    <div id="liked-users-content-{{ $content->id }}" class="liked-users"
                                        style="display: none;">
                                        @foreach ($remainingLikes as $like)
                                            <p>{{ $like->user->firstname }} {{ $like->user->lastname }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Replies Section (Initially hidden) -->
    <div id="replies" class="content-section" style="display: none;">
        @foreach ($replies as $reply)
            <div class="feed col-md-7">
                <div class="post">
                    <!-- User Profile Picture and Name -->
                    <div class="user-profile2">
                        @if ($reply->user->profile && $reply->user->profile->profile_picture)
                            <a href="{{ route('user.Profile', ['user_id' => $reply->user->id]) }}">
                                <img src="{{ asset('uploads/profile/' . $reply->user->profile->profile_picture) }}"
                                    alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">
                            </a>
                        @else
                            <a href="{{ route('user.Profile', ['user_id' => $reply->user->id]) }}">
                                <img src="" alt="Default Profile Picture"
                                    style="width: 50px; height: 50px; border-radius: 50%;">
                            </a>
                        @endif
                        <span class="username">{{ $reply->user->firstname }} {{ $reply->user->lastname }}</span>
                        <p> {{ $reply->created_at->diffForHumans() }}</p>
                    </div>

                    <p style="margin-left:50px;">{{ $reply->content }}</p>
                    @if ($reply->image)
                        <img src="{{ asset('uploads/image/' . $reply->image) }}" alt="">
                    @endif

                    <div class="post-icons">
                        <span onclick="likeContent({{ $reply->id }})" id="like-icon-{{ $reply->id }}"
                            class="like-icon" data-content-id="{{ $reply->id }}">
                            @if (in_array($reply->id, $likedContents))
                                <span class="material-icons filled">favorite</span>
                            @else
                                <span class="material-icons outlined">favorite</span>
                            @endif
                        </span>
                        <form action="{{ route('content.like', $reply->id) }}" method="POST" style="display:none"
                            id="like-form-{{ $reply->id }}">
                            @csrf
                        </form>
                        <span id="like-count-{{ $reply->id }}" style="margin-left:-5px;"
                            class="like-count">{{ $reply->likes_count }}</span>
                        <a href="{{ route('comment', ['id' => $reply->id]) }}"><span class="fas fa-comment"></span></a>
                        <span class="comment-count">{{ $reply->comments_count }}</span>

                        @if ($reply->likes->count() > 0)
                            <div class="latest-like">
                                <p>Liked by:
                                    @php
                                        $latestLike = $reply->likes->last();
                                        if ($latestLike) {
                                            echo $latestLike->user->firstname . ' ' . $latestLike->user->lastname;
                                        }
                                    @endphp

                                    @php
                                        $remainingLikes = $reply->likes->where('id', '!=', $latestLike->id);
                                        $remainingLikesCount = $remainingLikes->count();
                                    @endphp
                                    @if ($remainingLikesCount > 0)
                                        and <strong id="other-likes-link-{{ $reply->id }}"
                                            onclick="toggleLikedUsers(event, {{ $reply->id }}, 'reply')">{{ $remainingLikesCount }}
                                            others</strong>
                                    @endif
                                </p>
                                <div id="liked-users-reply-{{ $reply->id }}" class="liked-users"
                                    style="display: none;">
                                    @foreach ($remainingLikes as $like)
                                        <p>{{ $like->user->firstname }} {{ $like->user->lastname }}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Embed data in a script tag -->
    <script id="contents-data" type="application/json">
        @json($contents->pluck('id'))
    </script>
@endsection
