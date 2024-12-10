    <script>
    // Function to toggle fullscreen
    function toggleFullScreen() {
      if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().then(() => {
          localStorage.setItem('isFullscreen', 'true');
        });
      } else {
        document.exitFullscreen().then(() => {
          localStorage.setItem('isFullscreen', 'false');
        });
      }
    }

    // Check and restore fullscreen state on page load
    document.addEventListener('DOMContentLoaded', () => {
      if (localStorage.getItem('isFullscreen') === 'true') {
        document.documentElement.requestFullscreen().catch(err => {
          console.log('Error attempting to enable fullscreen:', err);
        });
      }
    });
    </script>
