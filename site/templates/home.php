<?php snippet('head') ?>

<nav class="flex items-center justify-between sticky p-8 z-50">
  <div class="flex items-center justify-center">
    <?php if ($site->logotoggle() && $site->logo()->isNotEmpty() && $site->logo()->toFile()): ?>
      <img src="<?= $site->logo()->toFile()->url() ?>" class="h-6 mr-4">
    <?php endif ?>
    <a href="<?= $site->url() ?>" class="text-2xl font-bold dark:text-gray-100"><?= $site->name() ?></a>
  </div>

  <div class="flex items-center gap-2 ml-auto">
    <!-- Theme Toggle -->
    <button onclick="toggleTheme()" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" title="Toggle theme">
      <svg id="theme-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
        <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-.46-.04-.92-.1-1.36-.98 1.37-2.58 2.26-4.4 2.26-2.98 0-5.4-2.42-5.4-5.4 0-1.81.89-3.42 2.26-4.4-.44-.06-.9-.1-1.36-.1z"/>
      </svg>
    </button>

    <a href="/panel" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
        <path d="M20 13H16C16 14.1 15.1 15 14 15H10C8.9 15 8 14.1 8 13H4L2 18V20C2 21.1 2.9 22 4 22H20C21.1 22 22 21.1 22 20V18M6 20C5.11 20 4.66 18.92 5.29 18.29C5.92 17.66 7 18.11 7 19C7 19.55 6.55 20 6 20M10 20C9.11 20 8.66 18.92 9.29 18.29C9.92 17.66 11 18.11 11 19C11 19.55 10.55 20 10 20M14 20C13.11 20 12.66 18.92 13.29 18.29C13.92 17.66 15 18.11 15 19C15 19.55 14.55 20 14 20M18 20C17.11 20 16.66 18.92 17.29 18.29C17.92 17.66 19 18.11 19 19C19 19.55 18.55 20 18 20M18 10V3H6V10H3V12H21V10M8 5H16V6H8M8 7H14V8H8" />
      </svg>
    </a>
  </div>
</nav>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-8 p-4 md:p-8">
  <?php
  // Get both books and comics
  $books = $site->children()->listed()->filterBy('template', 'book');
  $comics = $site->children()->listed()->filterBy('template', 'comic');
  $allContent = $books->merge($comics)->sortBy('num', 'asc');
  ?>

  <?php foreach ($allContent as $item):
    $rating = $item->rating()->or('sfw')->value();
    $isBlurred = in_array($rating, ['nsfw', 'nsfl']);
  ?>
    <div class="flex flex-col cursor-pointer transition-all hover:shadow-lg hover:scale-105 border border-gray-200 dark:border-gray-700 p-4 rounded-lg dark:bg-gray-800 relative content-card"
         data-rating="<?= $rating ?>"
         data-url="<?= $item->url() ?>"
         <?= !$isBlurred ? 'onclick="window.location.href=\'' . $item->url() . '\'"' : '' ?>>

      <!-- Type Badge -->
      <?php if ($site->showtypebadge()->toBool()): ?>
      <div class="absolute top-6 left-6 z-10 px-2 py-1 text-xs font-bold tracking-wider uppercase <?= $item->intendedTemplate() == 'comic' ? 'bg-black dark:bg-white text-white dark:text-black' : 'bg-white dark:bg-black text-black dark:text-white border border-black dark:border-white' ?> rounded">
        <?= $item->intendedTemplate() == 'comic' ? 'COMIC' : 'BOOK' ?>
      </div>
      <?php endif ?>

      <!-- Rating Badge -->
      <?php if ($rating !== 'sfw'): ?>
      <div class="absolute top-6 right-6 z-10 px-2 py-1 text-xs font-bold tracking-wider uppercase bg-red-600 dark:bg-red-500 text-white rounded">
        <?= strtoupper($rating) ?>
      </div>
      <?php endif ?>

      <!-- Cover Image -->
      <div class="relative cover-container">
        <?php if($item->cover()->isNotEmpty()): ?>
          <img src="<?= $item->cover()->toFile()->url() ?>" class="w-full h-full object-cover rounded cover-image <?= $isBlurred ? 'blur-xl' : '' ?>">
        <?php else: ?>
          <img src="/assets/img/fallback.jpg" class="w-full h-full rounded cover-image <?= $isBlurred ? 'blur-xl' : '' ?>">
        <?php endif ?>

        <?php if ($isBlurred): ?>
        <div class="absolute inset-0 flex items-center justify-center bg-black/30 rounded unblur-overlay">
          <button class="px-4 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-md font-medium hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors unblur-btn">
            Click to reveal
          </button>
        </div>
        <?php endif ?>
      </div>

      <h2 class="mt-4 text-xl font-bold dark:text-gray-100"><?= $item->title() ?></h2>
      <?php if ($item->seriesname()->isNotEmpty()): ?>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-500 italic">
        <?= $item->seriesname() ?><?= $item->seriesnumber()->isNotEmpty() ? ' #' . $item->seriesnumber() : '' ?>
      </p>
      <?php endif ?>
      <p class="mt-2 text-gray-600 dark:text-gray-400"><?= $item->author() ?></p>
    </div>
  <?php endforeach ?>
</div>

<div class="fixed bottom-0 left-0 right-0 z-50">
  <?php if($site->attribution()): ?>
  <div class="text-center p-4 text-sm text-gray-500 dark:text-gray-400 bg-white/80 dark:bg-gray-900/80 backdrop-blur">
    Grimoire. Written by <a href="https://rmv.fyi" class="hover:text-gray-700 dark:hover:text-gray-300">rmv</a>. Powered by Kirby CMS. Inspired by ONCE Writebook by 37signals.
  </div>
  <?php endif ?>
</div>

<script>
// Handle NSFW/NSFL content blur/unblur
document.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.content-card');

  cards.forEach(card => {
    const rating = card.dataset.rating;
    const url = card.dataset.url;
    const unblurBtn = card.querySelector('.unblur-btn');

    if (!unblurBtn) return; // SFW content, skip

    unblurBtn.addEventListener('click', (e) => {
      e.stopPropagation(); // Prevent card click

      if (rating === 'nsfl') {
        // NSFL requires confirmation
        const confirmed = confirm(
          'This content is marked as NSFL (Not Safe for Life) and may contain extremely disturbing material.\n\n' +
          'Are you sure you want to reveal this content?'
        );

        if (!confirmed) return;
      }

      // Unblur the image
      const coverImage = card.querySelector('.cover-image');
      const overlay = card.querySelector('.unblur-overlay');

      coverImage.classList.remove('blur-xl');
      overlay.remove();

      // Make the card clickable
      card.style.cursor = 'pointer';
      card.addEventListener('click', () => {
        window.location.href = url;
      });
    });
  });
});
</script>

<?php snippet('scripts') ?>