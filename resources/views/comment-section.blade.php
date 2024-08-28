 <!-- Unique comment form for each content -->
 @if (isset($content->id))
     <form id="comment-form-{{ $content->id }}" class="comment-form" style="display: none;"
         action="{{ route('comment-store') }}" method="POST">
         @csrf
         <div class="comment-input" style="display: flex; align-items: center;">
             <input type="hidden" name="page" value="{{ $contents->currentPage() }}">
             <input type="hidden" name="content_id" value="{{ $content->id }}">
             <input type="hidden" name="user_id" value="{{ Auth::id() }}">
             <input type="hidden" name="parent_id" value="{{ $parent_id ?? null }}">
             <textarea class="comment-body"
                 style="height: 50px; width: calc(100% - 80px); flex: 1; margin-right: 10px; background-color: black; font-size: 20px; color:white;"
                 placeholder="Enter your comment" name="comment_body"></textarea>
             <button type="submit" class="submit-comment"
                 style="background-color: blue; color:white; border: none; padding: 8px 12px; cursor: pointer;">Post</button>
         </div>
     </form>
 @endif
 <script>
     // Add event listeners for toggling comment forms
     var toggleButton = document.getElementById('toggle-comment-form-{{ $content->id }}');
     toggleButton.addEventListener('click', function(e) {
         e.preventDefault();
         toggleCommentForm({{ $content->id }});
     });
     // Function to toggle visibility of comment form
     function toggleCommentForm(contentId) {
         var commentForm = document.getElementById('comment-form-' + contentId);
         if (commentForm.style.display === 'none') {
             commentForm.style.display = 'block';
         } else {
             commentForm.style.display = 'none';
         }
     }
 </script>
