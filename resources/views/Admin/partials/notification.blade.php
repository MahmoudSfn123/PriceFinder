<script>
function showNotification(message, type = "info") {
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

    Object.assign(notification.style, {
        position: "fixed",
        top: "1.5rem",
        left: "50%",           // <-- center horizontally
        transform: "translateX(-50%)",  // <-- center horizontally by shifting half width left
        backgroundColor: type === "success" ? "#16a34a" :
                         type === "error" ? "#dc2626" :
                         "#2563eb",
        color: "#fff",
        padding: "1rem 1.5rem",
        borderRadius: "0.5rem",
        boxShadow: "0 5px 15px rgba(0,0,0,0.1)",
        zIndex: "9999",
        transition: "opacity 0.3s ease, transform 0.3s ease"
    });

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = 0;
        notification.style.transform = "translateX(-50%) translateY(-10px)";  // shift up with same horizontal center
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        showNotification(@json(session('success')), 'success');
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        showNotification(@json(session('error')), 'error');
    });
</script>
@endif

@if(session('info'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        showNotification(@json(session('info')), 'info');
    });
</script>
@endif
