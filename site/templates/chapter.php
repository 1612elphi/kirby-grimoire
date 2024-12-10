<?php snippet('head') ?>

<nav class="flex items-center justify-between sticky p-8">
  <a href="javascript:history.back()" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
      <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
    </svg>
  </a>

  <div class="flex items-center justify-center flex-1">
    <a href="<?= $page->parent()->url() ?>" class="text-2xl">
      <span class="opacity-50 tracking-wide"><?= $page->parent()->title() ?></span>
      <span class="opacity-50 px-3"> &raquo; </span>
      <span class="font-bold"><?= $page->title() ?></span>
    </a>
  </div>

  <!-- <button onclick="toggleFullScreen()" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
      <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
    </svg>
  </button> -->
</nav>

<?php if ($page->anmode() == "before"): ?>
<div class="prose prose-lg max-w-prose mx-auto">
  <div class="bg-gray-100 p-8 rounded-lg">
    <h1 class="text-2xl font-bold">Author's Note</h1>
    <?= $page->an()->kt() ?>
  </div>
</div>
<?php endif; ?>


<div class="prose prose-lg max-w-prose mx-auto p-8">
  <?= $page->wcontent()->kt() ?>
</div>

<?php if ($page->anmode() == "after"): ?>
<div class="prose prose-lg max-w-prose mx-auto">
  <div class="bg-gray-100 p-8 rounded-lg">
    <h1 class="text-2xl font-bold">Author's Note</h1>
    <?= $page->an()->kt() ?>
  </div>
</div>
<?php endif; ?>

<?php if ($page->hasNextListed()): ?>
<div class="prose prose-lg max-w-prose mx-auto text-center p-8">
  <a href="<?= $page->nextListed()->url() ?>" class="inline-flex items-center px-6 py-3 text-base font-medium border text-black border-black bg-white hover:invert rounded-md transition-colors">
    Read Next: <?= $page->nextListed()->title() ?>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="ml-2">
      <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
    </svg>
  </a>
</div>
<?php endif; ?>

<?php snippet('scripts') ?>