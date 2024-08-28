@extends('layout')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('site/comment.css') }}"> --}}
<link rel="shortcut icon" href="images/threads-logo.icon.png" type="image/x-icon">

<style>
    .comment-box {
        position: relative;
        margin: 25px auto;
        border-radius: 10px;
        margin-left: 25px;
    }

    .menu-icon {
        position: relative;
        margin-left: auto;
        cursor: pointer;
        margin-left: 630px;
        margin-top: -7px;
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

    .comment-form textarea {
        width: calc(94% - 100px);
        color: white;
        background-color: black;
        border: none;
        border-radius: 5px;
        box-sizing: border-box;
        display: inline-block;
        vertical-align: middle;
    }

    .comment-form button {
        background-color: #007bff;
        border: none;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        display: inline-block;
        vertical-align: middle;
        margin-left: 20px;
    }

    .feed {
        padding: 20px;
    }

    .error-message {
        font-size: 16px;
        margin-left: 12px;
    }

    .like-count {
        color: #ff0000;
        margin-left: -35px;
        margin-top: 20px;
    }

    .post img {
        width: 100%;
        height: 60%;
        border-radius: 20px;
    }

    .comment-count {
        margin-top: -50px;
        margin-left: -12px;
        font-size: 18px;
        color: #888;
    }

    .reply-count1 {
        margin-left: 20px;
        font-size: 18px;
        color: white;
    }

    .latest-like p {
        font-size: 15px;
        font-family: 'Arial', sans-serif;
        margin-left: 22px;

    }

    .fa-comment {
        font-size: 20px;
        margin-left: 10px;
        margin-top: -5px;
        color: white;
    }

    .fa-comment1 {
        font-size: 20px;
        margin-left: 20px;
        margin-top: -5px;
        color: white;
    }

    .like-icon.liked span {
        color: red;
    }

    .likes-list {
        margin-top: 10px;
    }

    .like-icon.liked .material-symbols-outlined {
        color: red;
        margin-top: 25px;
    }

    .post-icons {
        align-items: center;
        margin-top: 5px;
        font-size: 20px;
        cursor: pointer;
        margin-left: 20px;
    }

    .post-icons span {
        margin-right: 10px;
        padding: 10px;
        color: white;
        margin-top: -15px;
    }

    .delete-icon {
        float: right;
        margin-top: -40px;
        color: white;
        cursor: pointer;
    }

    .user-profile3 {
        margin-bottom: 20px;
        text-align: left;
    }

    .user-profile3 img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
    }

    .user-profile3 .username {
        font-size: 17px;
        font-weight: bold;
    }

    .post {
        background-color: #101012;
        padding: 20px;
        margin-bottom: 10px;
        border-radius: 10px;
        width: calc(176% - 30px);
        margin-top: 13px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        box-sizing: border-box;
        margin: 0 auto;
        margin-left: 15px;
        margin-right: 15px;
    }

    .post p {
        color: #ffffff;
        margin-top: -10px;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .user-profile3 p {
        margin-left: 50px;
        margin-top: -10px;
        color: #888;
        font-size: 14px;
    }
</style>


@section('content')
    <div class="feed col-md-7">
        <div class="post" style="background-color:#101012;">
            <!-- User Profile Picture and Name -->
            <div class="user-profile3">
                @if ($content->user->profile && $content->user->profile->profile_picture)
                    {{-- To make the multiple users profile visual --}}
                    <a href="{{ route('user.Profile', ['user_id' => $content->user->id]) }}">
                        <img src="{{ asset('uploads/profile/' . $content->user->profile->profile_picture) }}"
                            alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">
                    </a>
                @else
                    <a href="{{ route('user.Profile', ['user_id' => $content->user->id]) }}">
                        <!-- Default Profile Picture -->
                        <img src="images/no pic.png" alt="Default Profile Picture"
                            style="width: 50px; height: 50px; border-radius: 50%;">
                    </a>
                @endif
                <span class="username">{{ $content->user->firstname }} {{ $content->user->lastname }}</span>
                <!-- Display the time when the post was created -->
                <p> {{ $content->created_at->diffForHumans() }}</p>
            </div>

            <p style="margin-left:45px;">{{ $content->content }}</p>
            @if ($content->image)
                <img src="{{ asset('uploads/image/' . $content->image) }}" alt="">
            @endif

            <div class="post-icons">
                <span onclick="likeContent({{ $content->id }})" id="like-icon-{{ $content->id }}" class="like-icon"
                    data-content-id="{{ $content->id }}">
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
                <span id="like-count-{{ $content->id }}" class="like-count">{{ $content->likes_count }}</span>

                <a href="{{ route('comment', ['id' => $content->id]) }}"><span class="fas fa-comment"></span></a>
                <span class="comment-count">{{ $content->comments->count() }}</span>
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
                                $remainingLikesCount = $content->likes->count() - 1; // Subtracting 1 for the latest like
                            @endphp
                            @if ($remainingLikesCount > 0)
                                and <strong id="other-likes-link-{{ $content->id }}"
                                    onclick="toggleLikedUsers({{ $content->id }})">{{ $remainingLikesCount }}
                                    others</strong>
                            @endif
                        </p>
                    </div>
                    <div id="liked-users-{{ $content->id }}"
                        style="display: none; font-size:15px; margin-top:60px;margin-left:-230px;">
                        @foreach ($content->likes as $like)
                            @if (!$loop->last)
                                {{ $like->user->firstname . ' ' . $like->user->lastname }},
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Horizontal lines -->
    <hr style="border-top: 1px solid #fff; margin-top: 20px; margin-bottom: 20px; margin-left:25px; margin-right:25px;">

    <!-- Comment Section -->
    <div class="comment-section">
        <!-- Comment Box -->
        <div class="comment-box">
            <form id="comment-form-{{ $content->id }}" class="comment-form" action="{{ route('comment-store') }}"
                method="POST">
                @csrf
                <input type="hidden" name="content_id" value="{{ $content->id }}">
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <textarea id="comment" class="comment-body" name="comment_body" placeholder="Write a comment..." rows="2">{{ old('comment_body') }}</textarea>
                <button type="submit" class="btn btn-light">Comment</button>
            </form>
        </div>
    </div>
    <!-- Error Message for Character Limit -->
    <small class="text-danger error-message" id="comment-body-error"></small>
    <hr style="border-top: 1px solid #fff; margin-top: 20px; margin-bottom: 20px;  margin-left:25px; margin-right:25px;">

    @foreach ($comments as $comment)
        <div class="feed col-md-7">
            <div class="post">
                <div class="user-profile3">
                    <!-- Display user's profile picture -->
                    <a href="{{ route('user.Profile', ['user_id' => $comment->user->id]) }}">
                        @if ($comment->user->profile && $comment->user->profile->profile_picture)
                            <img src="{{ asset('uploads/profile/' . $comment->user->profile->profile_picture) }}"
                                alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">
                        @else
                            <!-- Default Profile Picture -->
                            <img src="" alt="Default Profile Picture"
                                style="width: 50px; height: 50px; border-radius: 50%;">
                        @endif
                    </a>

                    <span class="username">{{ $comment->user->firstname }}
                        {{ $comment->user->lastname }}</span>
                    <!-- Display the time when the post was created -->
                    @if ($comment->created_at)
                        <p>{{ $comment->created_at->diffForHumans() }}</p>
                    @endif
                </div>
                <p style="margin-left:45px;">{{ $comment->comment_body }}</p>

                <!-- Dropdown menu for comment actions -->
                @if (Auth::check() && $comment->user_id === Auth::id())
                    <div class="dropdown menu-icon" style=" float:right; margin-top:-115px;">
                        <button class="btn btn-secondary dropdown-toggle" style="background-color: #101012;" type="button"
                            id="dropdownMenuButton_{{ $comment->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                            &#8226;&#8226;&#8226;
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark"
                            aria-labelledby="dropdownMenuButton_{{ $comment->id }}">
                            <li>
                                <form id="deleteCommentForm_{{ $comment->id }}"
                                    action="{{ route('comments.destroy', ['id' => $comment->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item button-delete"
                                        onclick="submitCommentForm(event, '{{ $comment->id }}')">Delete</button>
                                </form>
                            </li>
                            <li>
                                <form id="editCommentForm_{{ $comment->id }}"
                                    action="{{ route('comments.update', ['id' => $comment->id]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="dropdown-item button-edit" type="button"
                                        onclick="openEditCommentModal('{{ $comment->id }}', '{{ $comment->comment_body }}')">Edit</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endif

                <div class="post-icons1">
                    <span onclick="likeComment({{ $comment->id }})" id="like-icon-{{ $comment->id }}" class="like-icon"
                        data-comment-id="{{ $comment->id }}">
                        <span class="material-icons outlined"></span>
                        <a href="{{ route('showReplies', ['id' => $comment->id]) }}"><span
                                class="fas fa-comment"></span></a>
                        <span class="reply-count1">{{ $comment->reply_count }}</span>
                </div>
            </div>
        </div>
        <!-- Edit Modal for Comment -->
        <div class="modal fade" id="editCommentModal_{{ $comment->id }}" tabindex="-1"
            aria-labelledby="editCommentModalLabel_{{ $comment->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 style="color: black;" class="modal-title fs-5"
                            id="editCommentModalLabel_{{ $comment->id }}">Edit Comment</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="content">
                            <form id="editCommentForm_{{ $comment->id }}"
                                action="{{ route('comments.update', ['id' => $comment->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <textarea style="color: black;" class="form-control" id="editedComment_{{ $comment->id }}" name="comment_body"
                                        rows="8"></textarea>
                                    <small class="text-danger" id="editCommentValidationMessage_{{ $comment->id }}"
                                        style="display: none; font-size:16px;">Comment cannot exceed 255
                                        characters.</small>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Comment</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function submitCommentForm(event, commentId) {
            event.preventDefault();
            document.getElementById('deleteCommentForm_' + commentId).submit();
        }

        function openEditCommentModal(commentId, commentBody) {
            document.getElementById('editedComment_' + commentId).value = commentBody;
            $('#editCommentModal_' + commentId).modal('show');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const maxLen = 255;

            document.querySelectorAll('.comment-body').forEach(commentBody => {
                const errorElement = document.getElementById('comment-body-error');

                commentBody.addEventListener('input', function() {
                    if (commentBody.value.length > maxLen) {
                        errorElement.textContent = `Comment cannot exceed ${maxLen} characters.`;
                    } else {
                        errorElement.textContent = '';
                    }
                });

                const commentForm = document.querySelector('.comment-form');
                commentForm.addEventListener('submit', function(event) {
                    if (commentBody.value.length > maxLen) {
                        errorElement.textContent = `Comment cannot exceed ${maxLen} characters.`;
                        event.preventDefault();
                    }
                });
            });

            document.querySelectorAll('[id^=editCommentForm_]').forEach(editCommentForm => {
                const commentId = editCommentForm.id.split('_')[1];
                const editComment = document.getElementById('editedComment_' + commentId);
                const editCommentValidationMessage = document.getElementById(
                    'editCommentValidationMessage_' + commentId);

                editComment.addEventListener('input', function() {
                    if (editComment.value.length > maxLen) {
                        editCommentValidationMessage.style.display = 'block';
                    } else {
                        editCommentValidationMessage.style.display = 'none';
                    }
                });

                editCommentForm.addEventListener('submit', function(event) {
                    if (editComment.value.length > maxLen) {
                        editCommentValidationMessage.style.display = 'block';
                        event.preventDefault();
                    }
                });
            });
        });

        function likeComment(commentId) {
            var likeIcon = document.getElementById('like-icon-' + commentId);

            var formId = 'like-form-' + commentId;
            var form = document.getElementById(formId);

            fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('like-count-' + commentId).innerText = data.likes_count;

                    if (data.liked) {
                        likeIcon.classList.add('liked');
                        localStorage.setItem('liked_comment_' + commentId, 'true');
                    } else {
                        likeIcon.classList.remove('liked');
                        localStorage.removeItem('liked_comment_' + commentId);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        window.addEventListener('DOMContentLoaded', (event) => {
            var likeIcons = document.querySelectorAll('.like-icon');
            likeIcons.forEach(function(likeIcon) {
                var contentId = likeIcon.getAttribute('data-comment-id');
                var liked = localStorage.getItem('liked_comment_' + contentId);
                if (liked === 'true') {
                    likeIcon.classList.add('liked');
                } else {
                    likeIcon.classList.remove('liked');
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const maxLen = 255;

            const commentBody = document.querySelector('.comment-body');
            const errorElement = document.getElementById('comment-body-error');

            commentBody.addEventListener('input', function() {
                if (commentBody.value.length > maxLen) {
                    errorElement.textContent = `Comment cannot exceed ${maxLen} characters.`;
                } else {
                    errorElement.textContent = '';
                }
            });

            const commentForm = document.querySelector('.comment-form');
            commentForm.addEventListener('submit', function(event) {
                if (commentBody.value.length > maxLen) {
                    errorElement.textContent = `Comment cannot exceed ${maxLen} characters.`;
                    event.preventDefault();
                }
            });

            @foreach ($comments as $comment)
                const editComment = document.getElementById('editedComment_{{ $comment->id }}');
                const editCommentValidationMessage = document.getElementById(
                    'editCommentValidationMessage_{{ $comment->id }}');

                editComment.addEventListener('input', function() {
                    if (editComment.value.length > maxLen) {
                        editCommentValidationMessage.style.display = 'block';
                    } else {
                        editCommentValidationMessage.style.display = 'none';
                    }
                });

                const editCommentForm = document.getElementById('editCommentForm_{{ $comment->id }}');
                editCommentForm.addEventListener('submit', function(event) {
                    if (editComment.value.length > maxLen) {
                        editCommentValidationMessage.style.display = 'block';
                        event.preventDefault();
                    }
                });
            @endforeach
        });
    </script>


    <script>
        function likeComment(commentId) {
            var likeIcon = document.getElementById('like-icon-' + commentId);
            var iconSpan = likeIcon.querySelector('.material-symbols-outlined');

            var formId = 'like-form-' + commentId;
            var form = document.getElementById(formId);

            fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update like count
                    document.getElementById('like-count-' + commentId).innerText = data.likes_count;

                    // Toggle icon color
                    if (data.liked) {
                        likeIcon.classList.add('liked');
                        localStorage.setItem('liked_comment_' + commentId, 'true');
                    } else {
                        likeIcon.classList.remove('liked');
                        localStorage.removeItem('liked_comment_' + commentId);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
        // Check and apply liked status on page load
        window.addEventListener('DOMContentLoaded', (event) => {
            var likeIcons = document.querySelectorAll('.like-icon');
            likeIcons.forEach(function(likeIcon) {
                var contentId = likeIcon.getAttribute('data-comment-id');
                var liked = localStorage.getItem('liked_comment_' + commentId);
                if (liked === 'true') {
                    likeIcon.classList.add('liked');
                } else {
                    likeIcon.classList.remove('liked');
                }
            });
        });
    </script>

    <script>
        function likeContent(contentId) {
            var likeIcon = document.getElementById('like-icon-' + contentId);
            var iconSpan = likeIcon.querySelector('.material-symbols-outlined');

            var formId = 'like-form-' + contentId;
            var form = document.getElementById(formId);

            fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update like count
                    document.getElementById('like-count-' + contentId).innerText = data.likes_count;

                    // Toggle icon color
                    if (data.liked) {
                        likeIcon.classList.add('liked');
                        localStorage.setItem('liked_content_' + contentId, 'true');
                    } else {
                        likeIcon.classList.remove('liked');
                        localStorage.removeItem('liked_content_' + contentId);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
        // Check and apply liked status on page load
        window.addEventListener('DOMContentLoaded', (event) => {
            var likeIcons = document.querySelectorAll('.like-icon');
            likeIcons.forEach(function(likeIcon) {
                var contentId = likeIcon.getAttribute('data-content-id');
                var liked = localStorage.getItem('liked_content_' + contentId);
                if (liked === 'true') {
                    likeIcon.classList.add('liked');
                } else {
                    likeIcon.classList.remove('liked');
                }
            });
        });
    </script>

    <script>
        function toggleLikedUsers(contentId) {
            var likedUsers = document.getElementById('liked-users-' + contentId);
            var link = document.getElementById('other-likes-link-' + contentId);

            // Toggle the display of liked users' names
            if (likedUsers.style.display === 'none') {
                likedUsers.style.display = 'block';
            } else {
                likedUsers.style.display = 'none';
            }
        }
    </script>
@endsection
