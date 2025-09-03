@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
           showNotification(`{!! session('success') !!}`, 'success');

        // Immediately clear the flash to prevent second render
        @php
            session()->forget('success');
        @endphp

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

