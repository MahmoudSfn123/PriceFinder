<!-- Join the Conversation Section (for homepage) -->
<section class="join-conversation-section">
    <div class="container">
        <div class="conversation-content">
            <div class="conversation-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
            <h2 class="conversation-title">Join the Conversation</h2>
            <p class="conversation-description">
                Share tips, ask questions, and connect with other savvy shoppers in our community forum.
            </p>
            <a href="{{ route('discussions.index') }}" class="conversation-btn">
                Explore Discussions
            </a>
        </div>
    </div>
</section>

<style>
    /* Base Styles */
/* * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background-color: #f9fafb;
    color: #111827;
    line-height: 1.6;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Header Styles
.header {
    background-color: white;
    border-bottom: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 10;
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 0;
}

.logo {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    color: inherit;
}

.logo-icon {
    color: #f97316;
}

.logo-text {
    font-size: 1.5rem;
    font-weight: bold;
}

.nav {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.nav-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: none;
    border: none;
    color: #6b7280;
    text-decoration: none;
    border-radius: 0.375rem;
    transition: all 0.2s ease;
}

.nav-button:hover {
    background-color: #f3f4f6;
    color: #111827;
}

.cta-button {
    background-color: #f97316;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.cta-button:hover {
    background-color: #ea580c;
}

/* Main Content
.main {
    padding: 3rem 0;
}

/* Page Header
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.header-content h1 {
    margin: 0;
}

.page-title {
    font-size: 2.5rem;
    font-weight: bold;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.page-description {
    font-size: 1.125rem;
    color: #6b7280;
    margin: 0;
}

.new-discussion-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background-color: #3b82f6;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.new-discussion-btn:hover {
    background-color: #2563eb;
}

.btn-icon {
    width: 16px;
    height: 16px;
}

/* Discussions Card
.discussions-card {
    background-color: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.discussions-list {
    list-style: none;
}

.discussion-item {
    border-bottom: 1px solid #e5e7eb;
    transition: background-color 0.2s ease;
}

.discussion-item:last-child {
    border-bottom: none;
}

.discussion-item:hover {
    background-color: rgba(249, 250, 251, 0.5);
}

.discussion-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 1.5rem;
}

.discussion-info {
    flex-grow: 1;
}

.discussion-category {
    font-size: 0.875rem;
    font-weight: 500;
    color: #3b82f6;
    margin-bottom: 0.25rem;
}

.discussion-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    text-decoration: none;
    margin-bottom: 0.5rem;
    display: block;
    transition: color 0.2s ease;
}

.discussion-title:hover {
    color: #2563eb;
}

.discussion-author {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

.author-name {
    font-weight: 500;
    color: #374151;
}

.discussion-stats {
    flex-shrink: 0;
    margin-left: 1.5rem;
    text-align: right;
}

.replies-count {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.5rem;
    color: #6b7280;
    margin-bottom: 0.25rem;
}

.replies-icon {
    width: 16px;
    height: 16px;
}

.reply-count {
    font-weight: bold;
}

.last-reply {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
} */

/* Join the Conversation Section */
.join-conversation-section {
    padding: 5rem 0;
    background-color: #fef3e2;
    margin-bottom: 50px;
}

.conversation-content {
    text-align: center;
    max-width: 80rem;
    margin: 0 auto;
}



.conversation-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 4rem;
    height: 4rem;
    background: linear-gradient(135deg, #f97316, #ea580c);
    border-radius: 1rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 10px 25px rgba(249, 115, 22, 0.3);
}

.conversation-icon svg {
    color: white;
}

.conversation-title {
    font-size: 3rem;
    font-weight: bold;
    color: #111827;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.conversation-description {
    font-size: 1.25rem;
    color: #6b7280;
    max-width: 40rem;
    margin: 0 auto 2rem auto;
    line-height: 1.6;
}

.conversation-btn {
    display: inline-flex;
    align-items: center;
    background-color: #F28123;
    color: white;
    text-decoration: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-size: 1rem;
    font-weight: bold;
    transition: all 0.3s ease;
    transform: translateY(0);
}

.conversation-btn:hover {
    background-color: #051922;
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 10px 40px -10px rgba(242, 129, 35, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .discussion-content {
        flex-direction: column;
        gap: 1rem;
    }

    .discussion-stats {
        margin-left: 0;
        text-align: left;
    }

    .conversation-title {
        font-size: 2rem;
    }

    .conversation-description {
        font-size: 1.125rem;
    }

    .header-content {
        flex-direction: column;
        gap: 1rem;
    }

    .nav {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 640px) {
    .page-title {
        font-size: 2rem;
    }

    .new-discussion-btn {
        width: 100%;
        justify-content: center;
    }

    .conversation-title {
        font-size: 1.875rem;
    }
}

</style>
