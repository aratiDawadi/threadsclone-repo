@extends('layout')
<link rel="stylesheet" type="text/css" href="{{ asset('site/replies.css') }}">

@section('content')
    <div class="feed col-md-7">
        <div class="post">
            <div class="user-profile3">
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
                <p>{{ $reply->created_at->diffForHumans() }}</p>
            </div>

            <p style="margin-left:20px;">{{ $reply->comment_body }}</p>

            <div class="post-icons">
                <span onclick="likeComment({{ $reply->id }})" id="like-icon-{{ $reply->id }}" class="like-icon"
                    data-reply-id="{{ $reply->id }}">
                    <span class="material-icons outlined"></span>
                </span>

                <a href="{{ route('showReplies', ['id' => $reply->id]) }}">
                    <span class="fas fa-comment"></span>
                </a>
                <span class="reply-count">{{ $replies->count() }}</span>
            </div>
        </div>
    </div>

    <hr>
    <div class="comment-section">
        <div class="comment-box" style="position: relative;">
            <form id="reply-form-{{ $reply->id }}" class="comment-form"
                action="{{ route('comment-reply', ['id' => $reply->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                <input type="hidden" name="content_id" value="{{ $content->id }}">
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <textarea id="comment_body" class="comment_body" name="comment_body" placeholder="Write a reply..." rows="2">{{ old('comment_body') }}</textarea>
                <button type="submit" class="btn btn-light">Reply</button>
            </form>
        </div>
    </div>
    <small class="text-danger error-message" id="comment-body-error"></small>
    <hr>


    @foreach ($replies as $reply)
        <div class="post" style="margin-bottom:20px;">
            <div class="user-profile3">
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
                <p>{{ $reply->created_at->diffForHumans() }}</p>
            </div>
            <p style="margin-left:20px;">{{ $reply->comment_body }}</p>

            @if (Auth::check() && $reply->user_id === Auth::id())
                <div class="dropdown menu-icon" style=" float:right; margin-top:-100px;">
                    <button class="btn btn-secondary dropdown-toggle" style="background-color: #101012;" type="button"
                        id="dropdownMenuButton_{{ $reply->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                        &#8226;&#8226;&#8226;
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton_{{ $reply->id }}">
                        <li>
                            <form id="deleteReplyForm_{{ $reply->id }}"
                                action="{{ route('replies.destroy', ['id' => $reply->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="dropdown-item button-delete"
                                    onclick="submitReplyForm(event, '{{ $reply->id }}')">Delete</button>
                            </form>
                        </li>
                        <li>
                            <button class="dropdown-item button-edit" type="button"
                                onclick="openEditReplyModal('{{ $reply->id }}', '{{ $reply->comment_body }}')">Edit</button>
                        </li>
                    </ul>
                </div>
            @endif


            <!-- Edit Modal for Reply -->
            <div class="modal fade" id="editReplyModal_{{ $reply->id }}" tabindex="-1"
                aria-labelledby="editReplyModalLabel_{{ $reply->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 style="color: black;" class="modal-title fs-5"
                                id="editReplyModalLabel_{{ $reply->id }}">Edit
                                Reply</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="content">
                                <form id="editReplyForm_{{ $reply->id }}"
                                    action="{{ route('replies.update', ['id' => $reply->id]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <textarea style="color: black;" class="form-control" id="editedReply_{{ $reply->id }}" name="comment_body"
                                            rows="8">{{ $reply->comment_body }}</textarea>
                                        <small class="text-danger" id="editReplyValidationMessage_{{ $reply->id }}"
                                            style="display: none; font-size:16px;">Reply cannot exceed 255
                                            characters.</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Reply</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="post-icons">
                <span onclick="likeComment({{ $reply->id }})" id="like-icon-{{ $reply->id }}" class="like-icon"
                    data-reply-id="{{ $reply->id }}">
                    <span class="material-icons outlined"></span>
                </span>
                <a href="{{ route('showReplies', ['id' => $reply->id]) }}">
                    <span class="fas fa-comment"></span>
                </a>
                <span class="reply-count">{{ $reply->reply_count }}</span>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOMContentLoaded event fired');
            const maxLen = 255;

            // Comment body input and error message container
            const commentBody = document.querySelector('.comment_body');
            const errorElement = document.getElementById('comment-body-error');
            console.log(commentBody); // Check if the element is found
            console.log(errorElement); // Check if the error element is found

            commentBody.addEventListener('input', function() {
                console.log('Input event triggered');
                if (commentBody.value.length > maxLen) {
                    errorElement.textContent = `Comment cannot exceed ${maxLen} characters.`;
                } else {
                    errorElement.textContent = '';
                }
            });

            // Form submission listener to prevent submission if character limit is exceeded
            const commentForm = document.querySelector('.comment-form');
            commentForm.addEventListener('submit', function(event) {
                console.log('Form submission event triggered');
                if (commentBody.value.length > maxLen) {
                    errorElement.textContent = `Comment cannot exceed ${maxLen} characters.`;
                    event.preventDefault();
                }
            });

            document.querySelectorAll('[id^=editReplyForm_]').forEach(editReplyForm => {
                const replyId = editReplyForm.id.split('_')[1];
                const editReply = document.getElementById('editedReply_' + replyId);
                const editReplyValidationMessage = document.getElementById('editReplyValidationMessage_' +
                    replyId);

                editReply.addEventListener('input', function() {
                    if (editReply.value.length > maxLen) {
                        editReplyValidationMessage.style.display = 'block';
                    } else {
                        editReplyValidationMessage.style.display = 'none';
                    }
                });

                editReplyForm.addEventListener('submit', function(event) {
                    if (editReply.value.length > maxLen) {
                        editReplyValidationMessage.style.display = 'block';
                        event.preventDefault();
                    }
                });
            });
        });

        function submitReplyForm(event, replyId) {
            event.preventDefault();
            document.getElementById('deleteReplyForm_' + replyId).submit();
        }

        function openEditReplyModal(replyId, commentBody) {
            document.getElementById('editedReply_' + replyId).value = commentBody;
            $('#editReplyModal_' + replyId).modal('show');
        }

        function likeComment(replyId) {
            var likeIcon = document.getElementById('like-icon-' + replyId);

            var formId = 'like-form-' + replyId;
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
                    document.getElementById('like-count-' + replyId).innerText = data.likes_count;

                    if (data.liked) {
                        likeIcon.classList.add('liked');
                        localStorage.setItem('liked_reply_' + replyId, 'true');
                    } else {
                        likeIcon.classList.remove('liked');
                        localStorage.removeItem('liked_reply_' + replyId);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        window.addEventListener('DOMContentLoaded', (event) => {
            var likeIcons = document.querySelectorAll('.like-icon');
            likeIcons.forEach(function(likeIcon) {
                var contentId = likeIcon.getAttribute('data-reply-id');
                var liked = localStorage.getItem('liked_reply_' + contentId);
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
            console.log('DOMContentLoaded event fired');
            const maxLen = 255;

            // Comment body input and error message container
            const commentBody = document.querySelector('.comment_body');
            const errorElement = document.getElementById('comment-body-error');
            console.log(commentBody); // Check if the element is found
            console.log(errorElement); // Check if the error element is found

            commentBody.addEventListener('input', function() {
                console.log('Input event triggered');
                if (commentBody.value.length > maxLen) {
                    errorElement.textContent = `Comment cannot exceed ${maxLen} characters.`;
                } else {
                    errorElement.textContent = '';
                }
            });

            // Form submission listener to prevent submission if character limit is exceeded
            const commentForm = document.querySelector('.comment-form');
            commentForm.addEventListener('submit', function(event) {
                console.log('Form submission event triggered');
                if (commentBody.value.length > maxLen) {
                    errorElement.textContent = `Comment cannot exceed ${maxLen} characters.`;
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
