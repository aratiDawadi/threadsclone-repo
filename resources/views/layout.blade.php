<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threads</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="shortcut icon" href="images/threads-logo.icon.png" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/layout.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<style>
    .toast-success {
        background-color: #05f756 !important;
        color: #FFFFFF !important;
    }

    .toast-error {
        background-color: #FF0000 !important;
        color: #FFFFFF !important;
    }

    .toast-success .toast-title,
    .toast-success .toast-message,
    .toast-error .toast-title,
    .toast-error .toast-message {
        color: #FFFFFF !important;
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="sidebar col-md-2">
                <div class="sidebar">
                    <h2><a href="{{ route('dashboard') }}" style="text-decoration: none; color: inherit;">
                            <i class="fab fa-threads"></i> Threads
                        </a></h2>
                    <ul class="list-unstyled">
                        <li class="{{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="sidebar-link"><i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="{{ Route::currentRouteName() == 'search' ? 'active' : '' }}">
                            <a href="{{ route('search') }}" class="sidebar-link"><i class="fas fa-search"></i>
                                Search</a>
                        </li>
                        <li class="{{ Route::currentRouteName() == 'CreateProfile' ? 'active' : '' }}">
                            <a href="{{ route('CreateProfile') }}" class="sidebar-link"><i class="fas fa-user"></i>
                                Profile</a>
                        </li>
                        <li class="">
                            <a href="#" class="sidebar-link" data-bs-toggle="modal"
                                data-bs-target="#exampleModal"><i class="fas fa-plus"></i> Post</a>
                        </li>
                        <li class="">
                            <a href="{{ route('logout') }}" class="sidebar-link"><i class="fas fa-sign-out-alt"></i>
                                Logout</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <div class="main-content col-md-7">
                @yield('content')
            </div>

            <!-- Suggestions -->
            <div class="suggestions col-md-3">
                <div class="user-profile">
                    @if (Auth::user()->profile && Auth::user()->profile->profile_picture)
                        <a href="{{ route('userProfile') }}"> <!-- Add the route to the user's profile page -->
                            <img src="{{ asset('uploads/profile/' . Auth::user()->profile->profile_picture) }}"
                                alt="Profile Picture" height="100" width="100">
                        </a>
                    @else
                        <!-- If the user doesn't have a profile picture, it will show a default image -->
                        <a href="{{ route('userProfile') }}"> <!-- Add the route to the user's profile page -->
                            <img src="{{ asset('default_profile_picture.jpg') }}" alt="Default Profile Picture"
                                height="100" width="100">
                        </a>
                    @endif
                    <span class="username">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
                </div>

                <h5>People You May Know</h5>
                @foreach ($users as $user)
                    <div class="user-profile4">
                        @if ($user->profile && $user->profile->profile_picture)
                            <img src="{{ asset('uploads/profile/' . $user->profile->profile_picture) }}"
                                alt="Profile Picture" height="100" width="100">
                        @else
                            <img src="" alt="Default Profile Picture" height="100" width="100">
                        @endif
                        <div class="username-container">
                            <span class="username">{{ $user->firstname }} {{ $user->lastname }}</span>
                            <span class="user-username">{{ '@' . $user->username }}</span>
                        </div>
                        <!-- Add a button to view the user's profile -->
                        <a href="{{ route('user.Profile', $user->id) }}" class="follow-btn">View</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 style="color:black;" class="modal-title fs-5" id="exampleModalLabel">Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('showPost') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <textarea id="content" placeholder="Content" name="content" rows="8"
                            style="width: 100%; resize: vertical;">{{ old('content') }}</textarea>
                        <div id="contentValidationMessage" style="display: none; color: red; margin-top: 5px;">
                            Content should not exceed 255 characters.
                        </div>
                        <input type="file" style="color:black; margin-top:10px;" name="image" id="imageUpload"
                            accept=".jpeg,.jpg,.png,.gif">
                        <div id="validationMessage" style="display: none; color: red; margin-top: 5px;">
                            Only .jpeg, .jpg, .png, and .gif files are allowed.
                        </div>

                        <div id="validationMessage" style="display: none; color: red; margin-top: 5px;">
                            Image size should be less than 2MB.
                        </div>

                        <div class="modal-footer" style="margin-top: 10px;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-light" id="submitComment">Post Thread</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-links">
                <a href="{{ route('dashboard') }}">Home</a>
                <a href="{{ route('search') }}">Search</a>
                <a href="{{ route('CreateProfile') }}">Profile</a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Post</a>
            </div>
            <p>&copy; 2024 ThreadsClone. All rights reserved.</p>
            <div class="social-icons">
                <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </footer>

    <!-- JavaScript to validate image size and content length -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('imageUpload').addEventListener('change', function(event) {
                const fileInput = event.target;
                const maxFileSizeKB = 2048;
                const allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];

                // Get file details
                const file = fileInput.files[0];
                const fileSizeKB = file.size / 1024;
                const fileExtension = file.name.split('.').pop().toLowerCase();

                // Construct validation message for image
                let imageValidationMessage = '';
                if (fileSizeKB > maxFileSizeKB) {
                    imageValidationMessage += 'Image size should be less than 2MB.<br>';
                }
                if (!allowedExtensions.includes(fileExtension)) {
                    imageValidationMessage += 'Only .jpeg, .jpg, .png, and .gif files are allowed.';
                }

                // Display validation message for image
                const imageValidationDiv = document.getElementById('validationMessage');
                if (imageValidationMessage) {
                    imageValidationDiv.innerHTML = imageValidationMessage;
                    imageValidationDiv.style.display = 'block';
                    fileInput.value = '';
                } else {
                    imageValidationDiv.style.display = 'none';
                }
            });

            // Content length validation
            document.getElementById('content').addEventListener('input', function(event) {
                const contentInput = event.target;
                const maxContentLength = 255;

                // Get content length
                const contentLength = contentInput.value.length;

                // Construct validation message for content length
                const contentValidationMessage = contentLength > maxContentLength ?
                    'Content should not exceed 255 characters.' :
                    '';

                // Display validation message for content length
                const contentValidationDiv = document.getElementById('contentValidationMessage');
                contentValidationDiv.innerHTML = contentValidationMessage;
                contentValidationDiv.style.display = contentValidationMessage ? 'block' : 'none';
            });
        });
    </script>
    @if (session()->has('message'))
        <script>
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "8000",
                "extendedTimeOut": "4000",
                "positionClass": "toast-top-right",
                "toastClass": "toast-success"
            };
            toastr.success('{{ session()->get('message') }}');
        </script>
    @endif

    @if (session()->has('error') || $errors->any())
        <script>
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "8000",
                    "extendedTimeOut": "4000",
                    "positionClass": "toast-top-right",
                    "toastClass": "toast-error"
                };

                @if (session('error'))
                    toastr.error('{{ session()->get('error') }}');
                @endif

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        toastr.error("{{ $error }}");
                    @endforeach
                @endif
            });
            {{ session()->forget('error') }}
        </script>
        @php
            session()->forget('error');
        @endphp
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('.sidebar-link');

            links.forEach(link => {
                link.addEventListener('click', function(event) {
                    // Remove active class from all items
                    links.forEach(l => l.parentElement.classList.remove('active'));
                    // Add active class to the clicked item
                    this.parentElement.classList.add('active');
                });
            });
        });
    </script>
</body>

</html>
