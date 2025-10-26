<?php snippet('head') ?>

<script>
  // Set data attributes for comic navigation (parent is always the comic page now)
  document.body.dataset.comicId = '<?= $page->parent()->slug() ?>';
  document.body.dataset.pageId = '<?= $page->slug() ?>';
</script>

<!-- Top Navigation Bar -->
<nav class="flex items-center justify-between p-2 md:p-4 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
  <a href="<?= $page->parent()->url() ?>" class="flex items-center gap-1 px-2 py-2 md:px-4 text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
      <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
    </svg>
    <span class="hidden sm:inline">Index</span>
  </a>

  <div class="flex items-center flex-1 justify-center px-2">
    <span class="text-xs md:text-sm text-gray-600 dark:text-gray-400 text-center truncate">
      <?= $page->parent()->title() ?>
    </span>
  </div>

  <!-- Theme Toggle -->
  <button onclick="toggleTheme()" class="flex items-center px-2 py-2 md:px-4 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" title="Toggle theme (T)">
    <svg id="theme-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
      <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-.46-.04-.92-.1-1.36-.98 1.37-2.58 2.26-4.4 2.26-2.98 0-5.4-2.42-5.4-5.4 0-1.81.89-3.42 2.26-4.4-.44-.06-.9-.1-1.36-.1z"/>
    </svg>
  </button>
</nav>

<!-- Main Comic Image -->
<div class="comic-container flex flex-col items-center justify-center min-h-screen py-8 px-4 bg-white dark:bg-gray-900">

  <?php
  // Get the image for this virtual page
  $comicImage = $page->image();
  ?>

  <?php if ($comicImage): ?>
    <img
      src="<?= $comicImage->url() ?>"
      alt="<?= $page->alt()->isNotEmpty() ? $page->alt()->html() : ($page->title()->isNotEmpty() ? $page->title()->html() : 'Comic page') ?>"
      class="comic-image max-w-full h-auto cursor-pointer"
      id="comic-image-clickable"
    >
  <?php else: ?>
    <div class="text-center p-12 bg-gray-100 dark:bg-gray-800 rounded-lg">
      <p class="text-gray-500 dark:text-gray-400">No image uploaded for this page</p>
    </div>
  <?php endif ?>

  <?php if ($page->caption()->isNotEmpty()): ?>
    <p class="mt-6 text-center text-gray-700 dark:text-gray-300 max-w-2xl italic">
      <?= $page->caption()->html() ?>
    </p>
  <?php endif ?>

  <?php if ($page->commentary()->isNotEmpty() && $page->commentary_mode() != 'hidden'): ?>
    <?php if ($page->commentary_mode() == 'expandable'): ?>
      <details class="mt-8 max-w-2xl w-full">
        <summary class="cursor-pointer p-4 bg-gray-100 dark:bg-gray-800 rounded-lg font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
          Author Commentary
        </summary>
        <div class="mt-4 p-4 prose dark:prose-invert">
          <?= $page->commentary()->kt() ?>
        </div>
      </details>
    <?php else: ?>
      <div class="mt-8 max-w-2xl w-full p-6 bg-gray-100 dark:bg-gray-800 rounded-lg">
        <h2 class="text-lg font-bold mb-3 text-gray-900 dark:text-gray-100">Author Commentary</h2>
        <div class="prose dark:prose-invert">
          <?= $page->commentary()->kt() ?>
        </div>
      </div>
    <?php endif ?>
  <?php endif ?>

  <!-- Spacer for fixed bottom nav -->
  <div class="h-24"></div>
</div>

<!-- Fixed Bottom Navigation Bar - Floating with blur -->
<nav class="fixed bottom-2 md:bottom-6 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-sm md:max-w-2xl px-2 md:px-0">
  <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md rounded-full shadow-lg border border-gray-200/50 dark:border-gray-700/50 px-2 md:px-4 py-2 md:py-3">
    <div class="flex items-center justify-center gap-1 md:gap-2">
    <?php
    // Determine navigation context
    $parent = $page->parent();
    $siblings = $parent->children()->listed();

    $firstPage = $siblings->first();
    $lastPage = $siblings->last();
    $prevPage = $page->hasPrevListed() ? $page->prevListed() : null;
    $nextPage = $page->hasNextListed() ? $page->nextListed() : null;
    ?>

      <!-- First -->
      <?php if ($firstPage && $page->id() != $firstPage->id()): ?>
        <a href="<?= $firstPage->url() ?>" class="p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 rounded-full transition-colors" title="First Page (Home)" id="nav-first">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
            <path d="M18.41 16.59L13.82 12l4.59-4.59L17 6l-6 6 6 6zM6 6h2v12H6z"/>
          </svg>
        </a>
      <?php else: ?>
        <span class="p-2 text-gray-400 dark:text-gray-600 cursor-not-allowed opacity-50">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
            <path d="M18.41 16.59L13.82 12l4.59-4.59L17 6l-6 6 6 6zM6 6h2v12H6z"/>
          </svg>
        </span>
      <?php endif ?>

      <!-- Previous -->
      <?php if ($prevPage): ?>
        <a href="<?= $prevPage->url() ?>" class="p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 rounded-full transition-colors" title="Previous Page (←)" id="nav-prev">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
            <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
          </svg>
        </a>
      <?php else: ?>
        <span class="p-2 text-gray-400 dark:text-gray-600 cursor-not-allowed opacity-50">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
            <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
          </svg>
        </span>
      <?php endif ?>

      <!-- Index -->
      <a href="<?= $parent->url() ?>" class="px-2 md:px-4 py-1.5 md:py-2 text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100/50 dark:bg-gray-800/50 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-full transition-colors mx-1 md:mx-2" title="Index (I or Esc)">
        Index
      </a>

      <!-- Next -->
      <?php if ($nextPage): ?>
        <a href="<?= $nextPage->url() ?>" class="p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 rounded-full transition-colors" title="Next Page (→)" id="nav-next">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
            <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
          </svg>
        </a>
      <?php else: ?>
        <span class="p-2 text-gray-400 dark:text-gray-600 cursor-not-allowed opacity-50">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
            <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
          </svg>
        </span>
      <?php endif ?>

      <!-- Last -->
      <?php if ($lastPage && $page->id() != $lastPage->id()): ?>
        <a href="<?= $lastPage->url() ?>" class="p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100/50 dark:hover:bg-gray-700/50 rounded-full transition-colors" title="Last Page (End)" id="nav-last">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
            <path d="M5.59 7.41L10.18 12l-4.59 4.59L7 18l6-6-6-6zM16 6h2v12h-2z"/>
          </svg>
        </a>
      <?php else: ?>
        <span class="p-2 text-gray-400 dark:text-gray-600 cursor-not-allowed opacity-50">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
            <path d="M5.59 7.41L10.18 12l-4.59 4.59L7 18l6-6-6-6zM16 6h2v12h-2z"/>
          </svg>
        </span>
      <?php endif ?>
    </div>

    <!-- Page Counter -->
    <div class="text-center mt-1 md:mt-2 text-xs text-gray-600 dark:text-gray-400">
      <?= $siblings->indexOf($page) + 1 ?> / <?= $siblings->count() ?>
    </div>
  </div>
</nav>

<script>
// Comic page navigation
document.addEventListener('DOMContentLoaded', () => {
  // Click on image to advance to next page
  const comicImage = document.getElementById('comic-image-clickable');
  const nextLink = document.getElementById('nav-next');
  const prevLink = document.getElementById('nav-prev');
  const firstLink = document.getElementById('nav-first');
  const lastLink = document.getElementById('nav-last');

  if (comicImage && nextLink) {
    comicImage.addEventListener('click', (e) => {
      // Only advance if clicking on the image itself
      if (e.target === comicImage && nextLink.tagName === 'A') {
        nextLink.click();
      }
    });
  }

  // Keyboard navigation for comic pages
  document.addEventListener('keydown', (e) => {
    // Don't trigger if user is typing in an input
    if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;

    // Previous page: Arrow Left or A
    if ((e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') && prevLink && prevLink.tagName === 'A') {
      e.preventDefault();
      prevLink.click();
    }

    // Next page: Arrow Right or D
    if ((e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') && nextLink && nextLink.tagName === 'A') {
      e.preventDefault();
      nextLink.click();
    }

    // First page: Home
    if (e.key === 'Home' && firstLink && firstLink.tagName === 'A') {
      e.preventDefault();
      firstLink.click();
    }

    // Last page: End
    if (e.key === 'End' && lastLink && lastLink.tagName === 'A') {
      e.preventDefault();
      lastLink.click();
    }
  });
});
</script>

<?php snippet('scripts') ?>
