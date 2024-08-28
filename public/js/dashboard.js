// validation of edit contentent

document.addEventListener('DOMContentLoaded', function() {
    const modals = window.contents;

    modals.forEach(contentId => {
        const editContentInput = document.getElementById(`editedContent_${contentId}`);
        const editContentValidationDiv = document.getElementById(`editContentValidationMessage_${contentId}`);

        // Validate content length on input
        editContentInput.addEventListener('input', function(event) {
            const maxContentLength = 255;
            const contentLength = editContentInput.value.length;

            const contentValidationMessage = contentLength > maxContentLength ?
                'Edit content should not exceed 255 characters.' :
                '';

            editContentValidationDiv.innerHTML = contentValidationMessage;
            editContentValidationDiv.style.display = contentValidationMessage ? 'block' : 'none';
        });

        // Handle form submission
        editContentInput.closest('form').addEventListener('submit', function(event) {
            if (editContentInput.value.length > 255) {
                event.preventDefault();
                editContentValidationDiv.innerHTML = 'Edit content should not exceed 255 characters.';
                editContentValidationDiv.style.display = 'block';
            }
        });
    });
});


// like and unlike in content //
function likeContent(event, contentId) {
    event.preventDefault();
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

// To show other liked users in content //
function toggleLikedUsers(event, contentId, type) {
    event.preventDefault();
    var likedUsers = document.getElementById('liked-users-' + type + '-' + contentId);
    var link = document.getElementById('other-likes-link-' + type + '-' + contentId);

    // Toggle the display of liked users' names
    if (likedUsers.style.display === 'none') {
        likedUsers.style.display = 'block';
    } else {
        likedUsers.style.display = 'none';
    }
}

//  To delete the content//
function submitForm(event, contentId) {
    event.preventDefault();
    // Trigger form submission
    document.getElementById('deleteForm_' + contentId).submit();
}

// To open the editmodal of content //
function openEditModal(event, contentId, contentValue) {
    event.preventDefault();
    document.getElementById('editedContent_' + contentId).value = contentValue;

    // Show the edit modal
    $('#editModal_' + contentId).modal('show');
}


