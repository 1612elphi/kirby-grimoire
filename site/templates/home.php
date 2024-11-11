<?php snippet('head') ?>

<nav class="flex items-center justify-center sticky p-8">
  <div class="flex items-center justify-center">
    <?php if ($site->logotoggle()): ?>
      <img src="<?= $site->logo()->toFile()->url() ?>" class="h-6 mr-4">
    <?php endif ?>
    <a href="<?= $site->url() ?>" class="text-2xl font-bold"><?= $site->name() ?></a>
  </div>
  <a href="/panel" class="flex items-center ml-auto px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
      <path d="M20 13H16C16 14.1 15.1 15 14 15H10C8.9 15 8 14.1 8 13H4L2 18V20C2 21.1 2.9 22 4 22H20C21.1 22 22 21.1 22 20V18M6 20C5.11 20 4.66 18.92 5.29 18.29C5.92 17.66 7 18.11 7 19C7 19.55 6.55 20 6 20M10 20C9.11 20 8.66 18.92 9.29 18.29C9.92 17.66 11 18.11 11 19C11 19.55 10.55 20 10 20M14 20C13.11 20 12.66 18.92 13.29 18.29C13.92 17.66 15 18.11 15 19C15 19.55 14.55 20 14 20M18 20C17.11 20 16.66 18.92 17.29 18.29C17.92 17.66 19 18.11 19 19C19 19.55 18.55 20 18 20M18 10V3H6V10H3V12H21V10M8 5H16V6H8M8 7H14V8H8" />
    </svg>
  </a>
</nav>

<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 p-8">
  <?php foreach ($site->children()->listed()->filterBy('template', 'book') as $book): ?>
    <div class="flex flex-col cursor-pointer transition-all hover:shadow-lg hover:scale-105 border border-gray-200 p-4 rounded-lg
      " onclick="window.location.href='<?= $book->url() ?>'">
      <?php if($book->cover()->isNotEmpty()): ?>
        <img src="<?= $book->cover()->toFile()->url() ?>" class="w-full h-full object-cover">
          <?php else: ?>
            <img src="/assets/img/fallback.jpg" class="w-full h-full">
      <?php endif ?>
      <h2 class="mt-4 text-xl font-bold"><?= $book->title() ?></h2>
      <p class="mt-2 text-gray-600"><?= $book->author() ?></p>
    </div>  
  <?php endforeach ?>
</div>

<div class="fixed bottom-0 left-0 right-0 z-50">
  <?php if($site->attribution()): ?>
    <div class="text-center p-4 text-sm text-gray-500">
      Grimoire. Written by rmv. Powered by Kirby CMS. Inspired by ONCE Writebook by 37signals.
    </div>
  <?php endif ?>
</div>