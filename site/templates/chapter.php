<?php snippet('head') ?>

<!-- Reading Progress Bar -->
<div id="reading-progress-container">
  <div id="reading-progress-bar"></div>
</div>

<script>
  document.body.dataset.bookId = '<?= $page->parent()->slug() ?>';
  document.body.dataset.chapterId = '<?= $page->slug() ?>';
</script>

<nav class="flex items-center justify-between sticky p-4 md:p-8 z-50">
  <a href="<?= $page->parent()->url() ?>" class="chapter-nav-prev flex items-center px-2 py-2 md:px-4 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
      <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
    </svg>
  </a>

  <div class="flex items-center justify-center flex-1 px-2">
    <a href="<?= $page->parent()->url() ?>" class="text-base md:text-2xl dark:text-gray-100 text-center">
      <span class="opacity-50 tracking-wide hidden md:inline"><?= $page->parent()->title() ?></span>
      <span class="opacity-50 px-1 md:px-3 hidden md:inline"> &raquo; </span>
      <span class="font-bold truncate"><?= $page->title() ?></span>
    </a>
  </div>

  <!-- Reading Controls -->
  <div class="flex items-center gap-1 md:gap-2">
    <!-- Font Size Controls -->
    <div class="hidden md:flex items-center gap-1 mr-2">
      <button onclick="setFontSize('small')" data-font-size="small" class="px-2 py-1 text-xs font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" title="Small text">A-</button>
      <button onclick="setFontSize('default')" data-font-size="default" class="px-2 py-1 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" title="Default text">A</button>
      <button onclick="setFontSize('large')" data-font-size="large" class="px-2 py-1 text-base font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" title="Large text">A+</button>
    </div>

    <!-- Theme Toggle -->
    <button onclick="toggleTheme()" class="flex items-center px-2 py-2 md:px-4 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" title="Toggle theme (T)">
      <svg id="theme-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
        <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-.46-.04-.92-.1-1.36-.98 1.37-2.58 2.26-4.4 2.26-2.98 0-5.4-2.42-5.4-5.4 0-1.81.89-3.42 2.26-4.4-.44-.06-.9-.1-1.36-.1z"/>
      </svg>
    </button>
  </div>
</nav>

<?php if ($page->anmode() == "before"): ?>
<div class="prose prose-lg dark:prose-invert max-w-prose mx-auto">
  <div class="bg-gray-100 dark:bg-gray-800 p-8 rounded-lg">
    <h1 class="text-2xl font-bold dark:text-gray-100">Author's Note</h1>
    <?= $page->an()->kt() ?>
  </div>
</div>
<?php endif; ?>


<div class="prose prose-lg dark:prose-invert max-w-prose mx-auto p-8">
  <?= $page->wcontent()->kt() ?>
</div>

<?php if ($page->anmode() == "after"): ?>
<div class="prose prose-lg dark:prose-invert max-w-prose mx-auto">
  <div class="bg-gray-100 dark:bg-gray-800 p-8 rounded-lg">
    <h1 class="text-2xl font-bold dark:text-gray-100">Author's Note</h1>
    <?= $page->an()->kt() ?>
  </div>
</div>
<?php endif; ?>

<?php if ($page->hasNextListed()): ?>
<div class="prose prose-lg dark:prose-invert max-w-prose mx-auto text-center p-8">
  <a href="<?= $page->nextListed()->url() ?>" class="chapter-nav-next inline-flex items-center px-6 py-3 text-base font-medium border text-black dark:text-white border-black dark:border-white bg-white dark:bg-gray-900 hover:invert rounded-md transition-colors">
    Read Next: <?= $page->nextListed()->title() ?>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="ml-2">
      <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
    </svg>
  </a>
</div>
<?php endif; ?>

<?php snippet('scripts') ?>