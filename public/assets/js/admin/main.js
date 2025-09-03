function showNotification(message, type = "info") {
    // Remove existing notification if any
    const existing = document.querySelector('.notification');
    if (existing) existing.remove();

    const notification = document.createElement("div");
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fa-solid fa-${type === "success" ? "check" : type === "error" ? "times" : "info"}-circle"></i>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(notification);

    // Auto-remove after 5s
    setTimeout(() => {
        notification.classList.add("slide-out");
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

document.addEventListener('DOMContentLoaded', function () {
        const closeButtons = document.querySelectorAll('.error__close');

        closeButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const errorBox = btn.closest('.error');
                if (errorBox) {
                    errorBox.style.display = 'none';
                }
            });
        });
    });
