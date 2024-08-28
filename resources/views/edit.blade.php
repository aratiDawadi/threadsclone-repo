@extends('layout')
<link rel="stylesheet" type="text/css" href="{{ asset('site/edit.css') }}">

@section('content')
    <h4 class="edit-heading">Edit User Details</h4>
    <!-- Edit Profile Form -->
    <div class="edit-profile">
        <div class="edit-profile-container">
            <form method="POST" action="{{ route('userProfile') }}" enctype="multipart/form-data" id="edit-profile-form">
                @csrf
                <div class="form-group">
                    <label for="firstname" class="col-form-label">First Name</label>
                    <input type="text" name="firstname" id="firstname" class="form-control"
                        value="{{ old('firstname', $profile->firstname ?? $user->firstname) }}">
                    <small class="text-danger error-message" id="firstname-error"></small>
                </div>
                <div class="form-group">
                    <label for="lastname" class="col-form-label">Last Name</label>
                    <input type="text" name="lastname" id="lastname" class="form-control"
                        value="{{ old('lastname', $profile->lastname ?? $user->lastname) }}">
                    <small class="text-danger error-message" id="lastname-error"></small>
                </div>
                <div class="form-group">
                    <label for="profile_picture" class="col-form-label">Profile Picture</label>
                    <input type="file" id="profile_picture" name="profile_picture" class="form-control">
                    <small class="text-danger error-message" id="profile-picture-error"></small>
                </div>
                <div class="form-group">
                    <label for="bio" class="col-form-label">Bio</label>
                    <textarea id="bio" name="bio" class="form-control large-input" rows="5">{{ old('bio', $profile->bio ?? '') }}</textarea>
                    <small class="text-danger error-message" id="bio-error"></small>
                </div>
                <button type="submit" name="submit" class="btn btn-light save-button">Save</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const maxLenName = 255;
            const maxLenBio = 500;
            const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
            const allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];

            const fields = [{
                    id: 'firstname',
                    errorId: 'firstname-error',
                    maxLen: maxLenName
                },
                {
                    id: 'lastname',
                    errorId: 'lastname-error',
                    maxLen: maxLenName
                },
                {
                    id: 'bio',
                    errorId: 'bio-error',
                    maxLen: maxLenBio
                },
                {
                    id: 'profile_picture',
                    errorId: 'profile-picture-error'
                }
            ];

            fields.forEach(field => {
                const input = document.getElementById(field.id);
                const error = document.getElementById(field.errorId);

                input.addEventListener('input', function() {
                    if (field.id !== 'profile_picture' && input.value.length > field.maxLen) {
                        error.textContent = `This field cannot exceed ${field.maxLen} characters.`;
                    } else {
                        error.textContent = '';
                    }
                });

                if (field.id === 'profile_picture') {
                    input.addEventListener('change', function() {
                        const file = input.files[0];
                        if (file) {
                            if (!allowedFileTypes.includes(file.type)) {
                                error.textContent =
                                    'Only image files (jpeg, png, gif) are allowed.';
                                input.value = ''; // Clear the file input
                            } else if (file.size > maxFileSize) {
                                error.textContent = 'File size cannot exceed 2MB.';
                                input.value = ''; // Clear the file input
                            } else {
                                error.textContent = '';
                            }
                        }
                    });
                }
            });

            // Optional: Prevent form submission if there are errors
            const form = document.getElementById('edit-profile-form');
            form.addEventListener('submit', function(event) {
                let isValid = true;
                fields.forEach(field => {
                    const input = document.getElementById(field.id);
                    const error = document.getElementById(field.errorId);

                    if (error.textContent) {
                        isValid = false;
                    }

                    if (field.id !== 'profile_picture' && input.value.length > field.maxLen) {
                        error.textContent = `This field cannot exceed ${field.maxLen} characters.`;
                        isValid = false;
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
