<script>
let isFullscreen = false;

function toggleFullScreen() {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen().then(() => {
      isFullscreen = true;
      sessionStorage.setItem('fullscreen', 'true');
    });
  } else {
    document.exitFullscreen().then(() => {
      isFullscreen = false;
      sessionStorage.setItem('fullscreen', 'false');
    });
  }
}

// Handle page visibility changes
document.addEventListener('visibilitychange', () => {
  if (document.visibilityState === 'visible' && sessionStorage.getItem('fullscreen') === 'true') {
    document.documentElement.requestFullscreen().catch(err => {
      console.log('Fullscreen error:', err);
    });
  }
});

// Restore fullscreen on page load if it was active
if (sessionStorage.getItem('fullscreen') === 'true') {
  document.addEventListener('DOMContentLoaded', () => {
    // Small delay to ensure proper timing
    setTimeout(() => {
      document.documentElement.requestFullscreen().catch(err => {
        console.log('Fullscreen error:', err);
      });
    }, 100);
  });
}

// Modify your link clicks to preserve fullscreen
document.addEventListener('DOMContentLoaded', () => {
  const links = document.querySelectorAll('a');
  links.forEach(link => {
    link.addEventListener('click', (e) => {
      if (document.fullscreenElement) {
        sessionStorage.setItem('fullscreen', 'true');
      }
    });
  });
});
</script>