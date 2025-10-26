<?php snippet('head') ?>

<script>
  document.body.dataset.comicId = '<?= $page->slug() ?>';
</script>

<nav class="flex items-center justify-between sticky p-4 md:p-8 z-50">
  <a href="<?= $site->url() ?>" class="flex items-center px-2 py-2 md:px-4 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
      <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
    </svg>
  </a>

  <div class="flex items-center justify-center flex-1 px-2">
    <a href="<?= $site->url() ?>" class="text-lg md:text-2xl font-bold dark:text-gray-100 text-center truncate"><?= $page->title() ?></a>
  </div>

  <div class="flex items-center gap-1 md:gap-2">
    <!-- Theme Toggle -->
    <button onclick="toggleTheme()" class="flex items-center px-2 py-2 md:px-4 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" title="Toggle theme">
      <svg id="theme-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
        <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-.46-.04-.92-.1-1.36-.98 1.37-2.58 2.26-4.4 2.26-2.98 0-5.4-2.42-5.4-5.4 0-1.81.89-3.42 2.26-4.4-.44-.06-.9-.1-1.36-.1z"/>
      </svg>
    </button>

    <!-- RSS Feed -->
    <a href="<?= $page->url() ?>.xml" class="flex items-center px-2 py-2 md:px-4 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" title="RSS Feed">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
        <path d="M6.18 15.64a2.18 2.18 0 0 1 2.18 2.18C8.36 19 7.38 20 6.18 20C5 20 4 19 4 17.82a2.18 2.18 0 0 1 2.18-2.18M4 4.44A15.56 15.56 0 0 1 19.56 20h-2.83A12.73 12.73 0 0 0 4 7.27V4.44m0 5.66a9.9 9.9 0 0 1 9.9 9.9h-2.83A7.07 7.07 0 0 0 4 12.93V10.1z"/>
      </svg>
    </a>
  </div>
</nav>

<div class="flex flex-col md:flex-row mx-4 md:mx-8 gap-6 md:gap-0">
  <div class="w-full md:w-1/3 md:pr-8">
    <?php $coverImage = $page->files()->filterBy('filename', '*=', 'cover')->first() ?: $page->files()->first(); ?>
    <img src="<?= $coverImage ? $coverImage->url() : '/assets/img/fallback.jpg' ?>" alt="<?= $page->title() ?>" class="w-full h-auto mb-4 rounded-lg shadow-lg">
  </div>

  <div class="w-full md:w-2/3 md:pl-8 mb-24">
    <div class="">
      <div class="inline-block px-3 py-1 mb-3 text-xs font-bold tracking-wider uppercase bg-black dark:bg-white text-white dark:text-black rounded">
        Comic
      </div>
      <?php if ($page->seriesname()->isNotEmpty()): ?>
      <p class="text-sm text-gray-500 dark:text-gray-500 mb-2">
        <span class="italic"><?= $page->seriesname() ?></span><?= $page->seriesnumber()->isNotEmpty() ? ' • Volume ' . $page->seriesnumber() : '' ?>
      </p>
      <?php endif ?>
      <h1 class="text-xl md:text-2xl font-bold mb-2 dark:text-gray-100"><?= $page->title() ?></h1>
      <h2 class="text-lg md:text-xl mb-2 dark:text-gray-300"><?= $page->subtitle() ?></h2>
      <h3 class="text-base md:text-lg mb-4 dark:text-gray-400">by <?= $page->author() ?></h3>
      <div class="prose dark:prose-invert">
        <?= $page->blurb()->kt() ?>
      </div>

      <?php
      // Find previous/next in series
      if ($page->seriesname()->isNotEmpty() && $page->seriesnumber()->isNotEmpty()) {
        $currentNumber = $page->seriesnumber()->toInt();
        $seriesItems = $site->children()->listed()->filter(function($item) use ($page) {
          return $item->seriesname()->value() == $page->seriesname()->value();
        })->sortBy('seriesnumber', 'asc');

        $prevInSeries = $seriesItems->filter(function($item) use ($currentNumber) {
          return $item->seriesnumber()->toInt() == $currentNumber - 1;
        })->first();

        $nextInSeries = $seriesItems->filter(function($item) use ($currentNumber) {
          return $item->seriesnumber()->toInt() == $currentNumber + 1;
        })->first();
      ?>
        <?php if ($prevInSeries || $nextInSeries): ?>
        <div class="mt-6 flex gap-4">
          <?php if ($prevInSeries): ?>
          <a href="<?= $prevInSeries->url() ?>" class="flex-1 px-4 py-3 text-sm font-medium border-2 border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors text-center">
            <div class="text-xs text-gray-500 dark:text-gray-500 mb-1">← Previous</div>
            <div><?= $prevInSeries->title() ?></div>
          </a>
          <?php endif ?>

          <?php if ($nextInSeries): ?>
          <a href="<?= $nextInSeries->url() ?>" class="flex-1 px-4 py-3 text-sm font-medium border-2 border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors text-center">
            <div class="text-xs text-gray-500 dark:text-gray-500 mb-1">Next →</div>
            <div><?= $nextInSeries->title() ?></div>
          </a>
          <?php endif ?>
        </div>
        <?php endif ?>
      <?php } ?>

      <?php
      // Get first page from virtual children
      $firstPage = $page->children()->first();
      ?>


      <!-- Comic Progress -->
      <div id="comic-progress" class="mt-6 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 hidden">
        <div class="flex justify-between items-center mb-2">
          <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Reading Progress</span>
          <span id="progress-percentage" class="text-sm text-gray-700 dark:text-gray-300"></span>
        </div>
        <div class="w-full bg-gray-300 dark:bg-gray-700 rounded-full h-2">
          <div id="progress-bar" class="bg-gray-900 dark:bg-gray-100 h-2 rounded-full transition-all" style="width: 0%"></div>
        </div>
      </div>
    </div>

    <hr class="my-8 dark:border-gray-700">

    <!-- Virtual pages from uploaded images -->
    <h2 class="text-xl font-bold mb-4 dark:text-gray-100">Pages</h2>
    <div class="space-y-6">
      <?php
      $pageIndex = 1;
      $inGrid = false;

      foreach($page->children() as $comicPage):
        // Check if this page starts a new chapter
        $isChapterStart = $comicPage->chapterstart()->toBool();
        $chapterTitle = $comicPage->chaptertitle()->value();

        // Close previous grid if starting a new chapter
        if ($isChapterStart && $inGrid) {
          echo '</div>';
          $inGrid = false;
        }

        // Show chapter heading if this is a chapter start
        if ($isChapterStart):
      ?>
        <?php if ($chapterTitle): ?>
          <div class="mt-8 mb-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 border-b-2 border-gray-300 dark:border-gray-700 pb-2">
              <?= $chapterTitle ?>
            </h3>
          </div>
        <?php else: ?>
          <div class="mt-8 mb-4 border-t-2 border-gray-300 dark:border-gray-700"></div>
        <?php endif ?>
      <?php
        endif;

        // Open grid if not already open
        if (!$inGrid) {
          echo '<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">';
          $inGrid = true;
        }
      ?>

      <a href="<?= $comicPage->url() ?>"
         class="page-item block bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-all overflow-hidden"
         data-page-id="<?= $comicPage->slug() ?>">
        <?php
        $pageImage = $comicPage->image();
        ?>
        <?php if ($pageImage): ?>
          <img src="<?= $pageImage->crop(300, 400)->url() ?>" alt="<?= $comicPage->title() ?>" class="w-full h-48 object-cover">
        <?php else: ?>
          <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
            <span class="text-gray-400">No image</span>
          </div>
        <?php endif ?>
        <div class="p-2 text-sm text-center text-gray-500 page-title">Page <?= $pageIndex ?></div>
      </a>
      <?php
      $pageIndex++;
      endforeach;

      // Close final grid
      if ($inGrid) {
        echo '</div>';
      }
      ?>
    </div>
  </div>
</div>

<script>
// Update comic progress on page load
document.addEventListener('DOMContentLoaded', () => {
  const comicId = document.body.dataset.comicId;
  if (!comicId) return;

  // Get pages read
  const key = `${Grimoire.KEYS.CHAPTER_PROGRESS}_${comicId}`;
  const pagesRead = Grimoire.storage.get(key, []);

  // Get all pages
  const pageItems = document.querySelectorAll('.page-item, .chapter-item');
  const totalPages = pageItems.length;

  if (totalPages === 0) return;

  // Mark completed pages/chapters with opacity
  pageItems.forEach(item => {
    const pageId = item.dataset.pageId || item.dataset.chapterId;
    if (pagesRead.includes(pageId)) {
      const title = item.querySelector('.page-title, .chapter-title');
      const time = item.querySelector('.chapter-time');
      if (title) title.style.opacity = '0.4';
      if (time) time.style.opacity = '0.4';
    }
  });

  // Show progress if any pages read
  if (pagesRead.length > 0) {
    const progressPercentage = Math.round((pagesRead.length / totalPages) * 100);
    document.getElementById('comic-progress').classList.remove('hidden');
    document.getElementById('progress-percentage').textContent = `${pagesRead.length} of ${totalPages} pages (${progressPercentage}%)`;
    document.getElementById('progress-bar').style.width = `${progressPercentage}%`;
  }

  // Find last read page and show resume button
  let lastReadPage = null;
  let lastReadTime = 0;

  pageItems.forEach(item => {
    const pageId = item.dataset.pageId || item.dataset.chapterId;
    const positionKey = `${Grimoire.KEYS.READING_POSITION}_${comicId}_${pageId}`;
    const position = Grimoire.storage.get(positionKey);

    if (position && position.timestamp > lastReadTime) {
      lastReadTime = position.timestamp;
      lastReadPage = item;
    }
  });

  if (lastReadPage) {
    const resumeBtn = document.getElementById('resume-reading-btn');
    const resumeContainer = document.getElementById('resume-reading-container');
    resumeBtn.href = lastReadPage.href;
    resumeContainer.classList.remove('hidden');
  }
});
</script>

<?php snippet('scripts') ?>
