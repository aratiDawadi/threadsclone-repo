<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threadsclone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="site/style.css">
    <link rel="shortcut icon" href="images/threads-logo.icon.png" type="image/x-icon">
    {{-- <script src="{{ asset('assets/dashboard.js') }}"></script> --}}


</head>
<body>
     <!-- sidebar starts -->
    <div class="sidebar">
        <i class="fab fa-threads"></i>
        <span class="title">Threads</span>
        <div class="sidebarOption" id="homeSidebarOption">
            <span class="material-symbols-outlined">home</span>
            <h2>Home</h2>
            <script>
                document.getElementById('homeSidebarOption').addEventListener('click', function() {
                    window.location.href = "{{ route('dashboard') }}";
                });
            </script>
        </div>

        <div class="sidebarOption" id="searchSidebarOption">
            <span class="material-symbols-outlined">search</span>
            <h2>Search</h2>
            <script>
                document.getElementById('searchSidebarOption').addEventListener('click', function() {
                    window.location.href = "{{ route('search') }}";
                });
            </script>
        </div>
        <div class="sidebarOption ">
            <span class="fa-regular fa-user"></span>
           <h2 id="profile-link" style="cursor: pointer;">Profile</h2>
            <script>
               document.getElementById('profile-link').addEventListener('click', function() {
               window.location.href = '/user-profile'; // Set the URL to navigate to
               });
            </script>
        </div>

        <div class="sidebarOption" id="createThreads">
            <span class="material-symbols-outlined">add</span>
            <h2>Post</h2> 
            <script>
                document.getElementById('createThreads').addEventListener('click', function() {
                    window.location.href = "{{ route('createPage') }}";
                });
            </script>
        </div>

        <div class="sidebarOption ">
            <span class="material-symbols-outlined">logout</span>
            <h2>Logout</h2>
        </div>
    </div>
     <!-- Modal Markup -->


     
<div style="margin-left:40px;"id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" style="font-size: 30px;">&times;</span>
        <div class="search_header">
            <h2>Create Thread</h2>
        </div>
        <div class="content">
            <div class="comment-box">
                <form action="{{ route('showPost') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <textarea id="content" placeholder="Content" name="content" rows="4"></textarea>
                    <input style="margin-top:10px; font-size:18px;" type="file" name="image" id="imageUpload" accept="image/*">
                    <button id="submitComment">Post Thread</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("createThreads");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<style type="text/css">

/* CSS to position the close button */
.close {
    float: right;
    top: 20px;
    right: 10px;
    cursor: pointer;
}

.comment-box {
    margin-top: 15px;
    width:700px;
}
.comment-box textarea {
    width: 100%;
    flex: 1; 
    margin-right: 10px;
    height: 250px;
    resize: vertical;
    font-size: 22px; 
    box-sizing: border-box;
    padding: 10px; 
    background-color:black;
    color:white;
}
.comment-box button {
    width: 100%; 
    padding: 10px; 
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top:22px;
    font-size:18px;
}
button:hover {
    background-color: #0056b3;
}
.content p{
    padding:15px;
    font-size:25px;
}

.search_header{
  position: sticky;
  margin-top: 30px;
  margin-left:5px;
  z-index: 100;
}
.search_header h2{
  font-size: 30px;
  font-weight: 700;
  color: white;
  
}
</style>
</body>
</html>



