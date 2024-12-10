<?php snippet('head') ?>

<nav class="flex items-center justify-between sticky p-8">
  <a href="javascript:history.back()" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
      <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
    </svg>
  </a>

  <div class="flex items-center justify-center flex-1">
    <a href="<?= $site->url() ?>" class="text-2xl font-bold"><?= $page->title() ?></a>
  </div>
  
  <a href="<?= $page->url() ?>.xml" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
      <path d="M6.18 15.64a2.18 2.18 0 0 1 2.18 2.18C8.36 19 7.38 20 6.18 20C5 20 4 19 4 17.82a2.18 2.18 0 0 1 2.18-2.18M4 4.44A15.56 15.56 0 0 1 19.56 20h-2.83A12.73 12.73 0 0 0 4 7.27V4.44m0 5.66a9.9 9.9 0 0 1 9.9 9.9h-2.83A7.07 7.07 0 0 0 4 12.93V10.1z"/>
    </svg>
  </a>

  <button onclick="toggleFullScreen()" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
      <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
    </svg>
  </button>
</nav>

<div class="flex mx-8">
  <div class="w-1/3 pr-8">
    <img src="<?= $page->cover()->toFile() ? $page->cover()->toFile()->url() : '/assets/img/fallback.jpg' ?>" alt="<?= $page->title() ?>" class="w-full h-auto mb-4 rounded-lg shadow-lg">
  </div>

  <div class="w-2/3 pl-8 mb-24">
    <div class="">
      <h1 class="text-2xl font-bold mb-2"><?= $page->title() ?></h1>
      <h2 class="text-xl mb-2"><?= $page->subtitle() ?></h2>
      <h3 class="text-lg mb-4">by <?= $page->author() ?></h3>
      <div class="prose">
        <?= $page->blurb()->kt() ?>
      </div>
    </div>
    <hr class="my-8">
    <div class="grid gap-4 mt-8">
      <?php foreach($page->children() as $chapter): ?>
      <a href="<?= $chapter->url() ?>" class="block p-4 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors flex justify-between items-center">
        <h3 class="text-lg font-medium"><?= $chapter->title() ?></h3>
        <span class="text-sm text-gray-500"><?= str_word_count($chapter->wcontent()->kt()) ?> words</span>
      </a>
      <?php endforeach ?>
    </div>
  </div>
</div>

