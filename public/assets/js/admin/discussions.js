/**
 * Toggle lock/unlock for a discussion
 */
function toggleLockDiscussion(id, isLocked) {
    const url = isLocked
        ? `/admin/discussions/${id}/unlock`
        : `/admin/discussions/${id}/lock`;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showCustomAlert(data.message, 'success', () => {
                location.reload();
            });
        } else {
            showCustomAlert('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Request failed', error);
        showCustomAlert('Something went wrong.', 'error');
    });
}

function deleteDiscussion(id) {
    if (!confirm('Are you sure you want to delete this discussion? This action cannot be undone.')) {
        return;
    }

    fetch(`/admin/discussions/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showCustomAlert(data.message, 'success', () => {
                // Redirect to discussions list
                window.location.href = '/admin/discussions';
            });
        } else {
            showCustomAlert('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Delete request failed', error);
        showCustomAlert('Something went wrong.', 'error');
    });
}
function deletePost(replyId) {
    if (!confirm('Are you sure you want to delete this reply?')) {
        return; // User cancelled
    }

    fetch(`/admin/replies/${replyId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showCustomAlert(data.message, 'success');

            // Option 1: Remove the reply element from DOM
            const replyElement = document.querySelector(`.post.reply[data-id="${replyId}"]`);
            if (replyElement) {
                replyElement.remove();
            }

            // Option 2: Or simply reload page to refresh discussion details
            // location.reload();
        } else {
            showCustomAlert(data.message || 'Failed to delete reply.', 'error');
        }
    })
    .catch(error => {
        console.error('Error deleting reply:', error);
        showCustomAlert('An error occurred while deleting the reply.', 'error');
    });
}

/**
 * Show a custom alert at the top center
 * @param {string} message - The alert message
 * @param {string} type - success | error | warning
 * @param {function|null} callback - Optional callback after alert hides
 */
function showCustomAlert(message, type = 'success', callback = null) {
    const alertBox = document.getElementById('custom-alert');
    alertBox.className = `alert ${type}`;
    alertBox.textContent = message;
    alertBox.classList.remove('d-none');

    // Wait 5 seconds, then hide and run optional callback
    setTimeout(() => {
        alertBox.classList.add('d-none');
        if (typeof callback === 'function') {
            callback();
        }
    }, 2000);
}


/**
 * Optional: Handle pagination button clicks
 */
document.addEventListener("DOMContentLoaded", () => {
    const paginationContainer = document.querySelector(".pagination-container");

    if (!paginationContainer) return;

    paginationContainer.addEventListener("click", (event) => {
        const button = event.target.closest("button[data-url]");
        if (!button) return;

        const url = button.getAttribute("data-url");
        if (url) {
            window.location.href = url;
        }
    });
});
