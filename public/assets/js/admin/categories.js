function viewInvoice(url) {
    const modal = document.getElementById('invoiceModal');
    const image = document.getElementById('invoiceImage');
    image.src = url;
    modal.style.display = 'flex';
}

function closeModal() {
    document.getElementById('invoiceModal').style.display = 'none';
}



document.addEventListener("DOMContentLoaded", () => {
    const paginationContainer = document.querySelector(".pagination-container");

    if (!paginationContainer) return;

    paginationContainer.addEventListener("click", (event) => {
        const button = event.target.closest("button[data-url]");
        if (!button) return;

        const url = button.getAttribute("data-url");
        if (url) {
            // Redirect to the page URL (reload page with new data)
            window.location.href = url;
        }
    });
});



function updateVerification(id, status) {
    fetch(`/admin/verifications/${id}/verify`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ verified: status })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Show SweetAlert2 message
            Swal.fire({
                icon: status === 1 ? 'success' : 'warning',
                title: status === 1 ? 'Approved!' : 'Rejected',
                text: status === 1 ? 'The product was successfully verified.' : 'The product has been rejected.',
                timer: 2000,
                showConfirmButton: false
            });

            // Get buttons for this product row
            const approveBtn = document.querySelector(`button.approve-btn[data-id="${id}"]`);
            const rejectBtn = document.querySelector(`button.reject-btn[data-id="${id}"]`);

            if (status === 1) {
                // APPROVED: Disable both
                approveBtn.disabled = true;
                rejectBtn.disabled = false;
            } else {
                // REJECTED: Enable Approve, disable Reject
                approveBtn.disabled = false;
                rejectBtn.disabled = true;
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to update verification status.'
            });
        }
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.'
        });
    });
}







