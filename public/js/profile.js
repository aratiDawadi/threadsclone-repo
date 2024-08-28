document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab');
    const totalPosts = document.getElementById('totalPosts');
    const replies = document.getElementById('replies');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            if (this.id === 'totalPostsTab') {
                totalPosts.style.display = 'block';
                replies.style.display = 'none';
            } else if (this.id === 'repliesTab') {
                totalPosts.style.display = 'none';
                replies.style.display = 'block';
            }
        });
    });

    const modals = JSON.parse(document.getElementById('contents-data').textContent);

    modals.forEach(contentId => {
        const editContentInput = document.getElementById(`editedContent_${contentId}`);
        const editContentValidationDiv = document.getElementById(`editContentValidationMessage_${contentId}`);

        editContentInput.addEventListener('input', function(event) {
            const maxContentLength = 255;
            const contentLength = editContentInput.value.length;

            const contentValidationMessage = contentLength > maxContentLength ?
                'Edit content should not exceed 255 characters.' :
                '';

            editContentValidationDiv.innerHTML = contentValidationMessage;
            editContentValidationDiv.style.display = contentValidationMessage ? 'block' : 'none';
        });

        editContentInput.closest('form').addEventListener('submit', function(event) {
            if (editContentInput.value.length > 255) {
                event.preventDefault();
                editContentValidationDiv.innerHTML = 'Edit content should not exceed 255 characters.';
                editContentValidationDiv.style.display = 'block';
            }
        });
    });
});

function toggleLikedUsers(event, contentId, contentType) {
    event.preventDefault();
    var likedUsersContainer = document.getElementById('liked-users-' + contentType + '-' + contentId);
    likedUsersContainer.style.display = likedUsersContainer.style.display === 'none' || likedUsersContainer.style.display === '' ? 'block' : 'none';
}

function likeContent(contentId) {
    var likeIcon = document.getElementById('like-icon-' + contentId);
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
        var likeCountElements = document.querySelectorAll('[id^="like-count-' + contentId + '"]');
        likeCountElements.forEach(function(element) {
            element.innerText = data.likes_count;
        });

        var likeIconElements = document.querySelectorAll('[id^="like-icon-' + contentId + '"]');
        likeIconElements.forEach(function(element) {
            element.innerHTML = data.liked ? '<span class="material-icons filled">favorite</span>' : '<span class="material-icons outlined">favorite</span>';
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
