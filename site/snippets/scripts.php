<script>
// ==================== GRIMOIRE READING FEATURES ====================

// Namespace for all Grimoire settings
const Grimoire = {
  // LocalStorage keys
  KEYS: {
    THEME: 'grimoire_theme',
    FONT_SIZE: 'grimoire_font_size',
    BOOK_PROGRESS: 'grimoire_book_progress',
    CHAPTER_PROGRESS: 'grimoire_chapter_progress',
    READING_POSITION: 'grimoire_reading_position'
  },

  // Utility functions
  storage: {
    get: (key, defaultValue = null) => {
      try {
        const value = localStorage.getItem(key);
        return value !== null ? JSON.parse(value) : defaultValue;
      } catch {
        return defaultValue;
      }
    },
    set: (key, value) => {
      try {
        localStorage.setItem(key, JSON.stringify(value));
      } catch (e) {
        console.warn('LocalStorage not available:', e);
      }
    }
  },

  // Calculate reading time (words per minute)
  calculateReadingTime: (wordCount, wpm = 225) => {
    const minutes = Math.ceil(wordCount / wpm);
    if (minutes < 1) return 'Less than 1 min';
    if (minutes === 1) return '1 min';
    return `${minutes} min`;
  }
};

// ==================== 1. READING PROGRESS BAR ====================

function initReadingProgress() {
  const progressBar = document.getElementById('reading-progress-bar');
  if (!progressBar) return;

  let ticking = false;

  const updateProgress = () => {
    const windowHeight = window.innerHeight;
    const documentHeight = document.documentElement.scrollHeight - windowHeight;
    const scrolled = window.scrollY;
    const progress = (scrolled / documentHeight) * 100;

    progressBar.style.width = `${Math.min(progress, 100)}%`;

    ticking = false;
  };

  window.addEventListener('scroll', () => {
    if (!ticking) {
      window.requestAnimationFrame(updateProgress);
      ticking = true;
    }
  });

  // Initial update
  updateProgress();
}

// ==================== 3. SCROLL POSITION TRACKING ====================

function saveScrollPosition() {
  const bookId = document.body.dataset.bookId;
  const chapterId = document.body.dataset.chapterId;

  if (bookId && chapterId) {
    const position = {
      scroll: window.scrollY,
      timestamp: Date.now()
    };
    const key = `${Grimoire.KEYS.READING_POSITION}_${bookId}_${chapterId}`;
    Grimoire.storage.set(key, position);
  }
}

function restoreScrollPosition() {
  const bookId = document.body.dataset.bookId;
  const chapterId = document.body.dataset.chapterId;

  if (bookId && chapterId) {
    const key = `${Grimoire.KEYS.READING_POSITION}_${bookId}_${chapterId}`;
    const position = Grimoire.storage.get(key);

    if (position && position.scroll > 0) {
      // Delay to ensure page is fully loaded
      setTimeout(() => {
        window.scrollTo(0, position.scroll);
      }, 100);
    }
  }
}

// Save scroll position periodically and on page unload
let scrollTimeout;
window.addEventListener('scroll', () => {
  clearTimeout(scrollTimeout);
  scrollTimeout = setTimeout(saveScrollPosition, 500);
});

window.addEventListener('beforeunload', saveScrollPosition);

// ==================== 4. CHAPTER COMPLETION TRACKING ====================

function markChapterAsRead() {
  const bookId = document.body.dataset.bookId;
  const chapterId = document.body.dataset.chapterId;

  if (!bookId || !chapterId) return;

  const windowHeight = window.innerHeight;
  const documentHeight = document.documentElement.scrollHeight - windowHeight;
  const scrolled = window.scrollY;
  const progress = (scrolled / documentHeight) * 100;

  // Mark as read when scrolled to 90%
  if (progress >= 90) {
    const key = `${Grimoire.KEYS.CHAPTER_PROGRESS}_${bookId}`;
    const chaptersRead = Grimoire.storage.get(key, []);

    if (!chaptersRead.includes(chapterId)) {
      chaptersRead.push(chapterId);
      Grimoire.storage.set(key, chaptersRead);
    }
  }
}

// Check on scroll
window.addEventListener('scroll', () => {
  clearTimeout(window.chapterReadTimeout);
  window.chapterReadTimeout = setTimeout(markChapterAsRead, 1000);
});

// ==================== 5. FONT SIZE CONTROLS ====================

function setFontSize(size) {
  const proseContent = document.querySelector('.prose');
  if (!proseContent) return;

  proseContent.classList.remove('prose-sm', 'prose-lg', 'prose-xl');

  switch(size) {
    case 'small':
      proseContent.classList.add('prose-sm');
      break;
    case 'large':
      proseContent.classList.add('prose-xl');
      break;
    default:
      proseContent.classList.add('prose-lg');
  }

  Grimoire.storage.set(Grimoire.KEYS.FONT_SIZE, size);
}

function initFontSize() {
  const savedSize = Grimoire.storage.get(Grimoire.KEYS.FONT_SIZE, 'default');
  setFontSize(savedSize);

  // Update button states
  document.querySelectorAll('[data-font-size]').forEach(btn => {
    btn.classList.toggle('active', btn.dataset.fontSize === savedSize);
  });
}

// ==================== 6. DARK/LIGHT THEME TOGGLE ====================

function setTheme(theme) {
  if (theme === 'dark') {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }

  Grimoire.storage.set(Grimoire.KEYS.THEME, theme);

  // Update toggle button icon
  const themeIcon = document.getElementById('theme-icon');
  if (themeIcon) {
    if (theme === 'dark') {
      // Sun icon (to switch to light)
      themeIcon.innerHTML = '<path d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM2 13h2c.55 0 1-.45 1-1s-.45-1-1-1H2c-.55 0-1 .45-1 1s.45 1 1 1zm18 0h2c.55 0 1-.45 1-1s-.45-1-1-1h-2c-.55 0-1 .45-1 1s.45 1 1 1zM11 2v2c0 .55.45 1 1 1s1-.45 1-1V2c0-.55-.45-1-1-1s-1 .45-1 1zm0 18v2c0 .55.45 1 1 1s1-.45 1-1v-2c0-.55-.45-1-1-1s-1 .45-1 1zM5.99 4.58c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0s.39-1.03 0-1.41L5.99 4.58zm12.37 12.37c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0 .39-.39.39-1.03 0-1.41l-1.06-1.06zm1.06-10.96c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06zM7.05 18.36c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06z"/>';
    } else {
      // Moon icon (to switch to dark)
      themeIcon.innerHTML = '<path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-.46-.04-.92-.1-1.36-.98 1.37-2.58 2.26-4.4 2.26-2.98 0-5.4-2.42-5.4-5.4 0-1.81.89-3.42 2.26-4.4-.44-.06-.9-.1-1.36-.1z"/>';
    }
  }
}

function toggleTheme() {
  const currentTheme = Grimoire.storage.get(Grimoire.KEYS.THEME, 'light');
  setTheme(currentTheme === 'dark' ? 'light' : 'dark');
}

function initTheme() {
  const savedTheme = Grimoire.storage.get(Grimoire.KEYS.THEME, 'light');
  setTheme(savedTheme);
}

// ==================== 7. DISTRACTION-FREE READING MODE ====================

function initDistractionFreeMode() {
  const nav = document.querySelector('nav');
  if (!nav) return;

  let lastScrollTop = 0;
  let ticking = false;

  const handleScroll = () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > lastScrollTop && scrollTop > 100) {
      // Scrolling down
      nav.classList.add('nav-hidden');
    } else {
      // Scrolling up
      nav.classList.remove('nav-hidden');
    }

    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    ticking = false;
  };

  window.addEventListener('scroll', () => {
    if (!ticking) {
      window.requestAnimationFrame(handleScroll);
      ticking = true;
    }
  });

  // Show nav on hover near top
  nav.addEventListener('mouseenter', () => {
    nav.classList.remove('nav-hidden');
  });
}

// ==================== 8. KEYBOARD SHORTCUTS ====================

function initKeyboardShortcuts() {
  document.addEventListener('keydown', (e) => {
    // Don't trigger if user is typing in an input
    if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;

    // T key - Toggle theme
    if (e.key === 't' || e.key === 'T') {
      e.preventDefault();
      toggleTheme();
    }

    // Check if we're on a comic page (has comic navigation)
    const isComicPage = document.querySelector('.comic-nav') !== null;

    if (isComicPage) {
      // Comic-specific navigation
      const firstLink = document.getElementById('nav-first');
      const prevLink = document.getElementById('nav-prev');
      const nextLink = document.getElementById('nav-next');
      const lastLink = document.getElementById('nav-last');
      const indexLink = document.querySelector('.comic-nav-btn-primary');

      // Arrow Left or A - Previous page
      if ((e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') && prevLink) {
        e.preventDefault();
        prevLink.click();
      }

      // Arrow Right or D - Next page
      if ((e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') && nextLink) {
        e.preventDefault();
        nextLink.click();
      }

      // Home - First page
      if (e.key === 'Home' && firstLink) {
        e.preventDefault();
        firstLink.click();
      }

      // End - Last page
      if (e.key === 'End' && lastLink) {
        e.preventDefault();
        lastLink.click();
      }

      // Escape or I - Index
      if ((e.key === 'Escape' || e.key === 'i' || e.key === 'I') && indexLink) {
        e.preventDefault();
        indexLink.click();
      }
    } else {
      // Regular book navigation
      const nextLink = document.querySelector('a[href*="nextListed"]') ||
                       document.querySelector('.chapter-nav-next');
      const prevLink = document.querySelector('.chapter-nav-prev');

      if (e.key === 'ArrowRight' && nextLink) {
        e.preventDefault();
        nextLink.click();
      }

      if (e.key === 'ArrowLeft' && prevLink) {
        e.preventDefault();
        prevLink.click();
      }
    }
  });
}

// ==================== 9. COMIC PAGE PROGRESS TRACKING ====================

function markComicPageAsViewed() {
  const comicId = document.body.dataset.comicId;
  const pageId = document.body.dataset.pageId;

  if (!comicId || !pageId) return;

  // Mark page as viewed immediately
  const key = `${Grimoire.KEYS.CHAPTER_PROGRESS}_${comicId}`;
  const pagesRead = Grimoire.storage.get(key, []);

  if (!pagesRead.includes(pageId)) {
    pagesRead.push(pageId);
    Grimoire.storage.set(key, pagesRead);
  }

  // Also save timestamp for "last read" functionality
  const positionKey = `${Grimoire.KEYS.READING_POSITION}_${comicId}_${pageId}`;
  Grimoire.storage.set(positionKey, {
    scroll: 0, // Comics don't need scroll position
    timestamp: Date.now()
  });
}

// ==================== INITIALIZATION ====================

document.addEventListener('DOMContentLoaded', () => {
  initTheme();
  initFontSize();
  initReadingProgress();
  initDistractionFreeMode();
  initKeyboardShortcuts();
  restoreScrollPosition();

  // Mark comic page as viewed if on comic page
  if (document.body.dataset.pageId && document.body.dataset.comicId) {
    markComicPageAsViewed();
  }
});

// Expose globally for onclick handlers
window.toggleTheme = toggleTheme;
window.setFontSize = setFontSize;
window.Grimoire = Grimoire;
</script>

<style>
/* Reading progress bar */
#reading-progress-container {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: transparent;
  z-index: 9999;
}

#reading-progress-bar {
  height: 100%;
  background: linear-gradient(90deg, #000000, #404040);
  width: 0%;
  transition: width 0.1s ease;
}

.dark #reading-progress-bar {
  background: linear-gradient(90deg, #ffffff, #d1d5db);
}

/* Nav hiding animation */
nav {
  transition: transform 0.3s ease, opacity 0.3s ease;
}

nav.nav-hidden {
  transform: translateY(-100%);
  opacity: 0;
}

/* Font size button active state */
[data-font-size].active {
  background-color: #000000 !important;
  color: white !important;
}

.dark [data-font-size].active {
  background-color: #ffffff !important;
  color: black !important;
}

/* ==================== COMIC STYLES ==================== */

/* Comic container */
.comic-container {
  padding-bottom: 8rem; /* Extra space for fixed nav */
}

/* Comic image */
.comic-image {
  max-height: 90vh;
  width: auto;
  margin: 0 auto;
  display: block;
}

/* Comic navigation bar */
.comic-nav {
  backdrop-filter: blur(10px);
  box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Comic navigation buttons */
.comic-nav-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: white;
  background-color: transparent;
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 0.375rem;
  transition: all 0.2s;
  text-decoration: none;
}

.comic-nav-btn:hover {
  background-color: rgba(255, 255, 255, 0.1);
  border-color: rgba(255, 255, 255, 0.5);
}

.comic-nav-btn-primary {
  background-color: rgba(255, 255, 255, 0.2);
  border-color: rgba(255, 255, 255, 0.5);
}

.comic-nav-btn-primary:hover {
  background-color: rgba(255, 255, 255, 0.3);
}

/* Dark mode comic nav */
.dark .comic-nav-btn {
  color: black;
  border-color: rgba(0, 0, 0, 0.3);
}

.dark .comic-nav-btn:hover {
  background-color: rgba(0, 0, 0, 0.1);
  border-color: rgba(0, 0, 0, 0.5);
}

.dark .comic-nav-btn-primary {
  background-color: rgba(0, 0, 0, 0.2);
  border-color: rgba(0, 0, 0, 0.5);
}

.dark .comic-nav-btn-primary:hover {
  background-color: rgba(0, 0, 0, 0.3);
}

/* Mobile adjustments for comic nav */
@media (max-width: 640px) {
  .comic-nav-btn {
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
  }

  .comic-image {
    max-height: 80vh;
  }
}
</style>