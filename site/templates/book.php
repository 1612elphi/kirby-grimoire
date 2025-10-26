<?php snippet('head') ?>

<script>
  document.body.dataset.bookId = '<?= $page->slug() ?>';
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
    <img src="<?= $page->cover()->toFile() ? $page->cover()->toFile()->url() : '/assets/img/fallback.jpg' ?>" alt="<?= $page->title() ?>" class="w-full h-auto mb-4 rounded-lg shadow-lg">
  </div>

  <div class="w-full md:w-2/3 md:pl-8 mb-24">
    <div class="">
      <?php if ($page->seriesname()->isNotEmpty()): ?>
      <p class="text-sm text-gray-500 dark:text-gray-500 mb-2">
        <span class="italic"><?= $page->seriesname() ?></span><?= $page->seriesnumber()->isNotEmpty() ? ' • Book ' . $page->seriesnumber() : '' ?>
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

      <!-- Book Progress -->
      <div id="book-progress" class="mt-6 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-700 hidden">
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

    <!-- Total Reading Time -->
    <?php
      $totalWords = 0;
      foreach($page->children() as $chapter) {
        $totalWords += str_word_count($chapter->wcontent()->kt());
      }
      $totalMinutes = ceil($totalWords / 225);
      $hours = floor($totalMinutes / 60);
      $minutes = $totalMinutes % 60;
      $timeEstimate = $hours > 0 ? "{$hours}h {$minutes}m" : "{$minutes} min";
    ?>
    <div class="mb-4">
      <p class="text-sm text-gray-600 dark:text-gray-400">
        <?= $page->children()->count() ?> chapters • <?= number_format($totalWords) ?> words • ~<?= $timeEstimate ?> total reading time
      </p>
    </div>

    <div class="grid gap-4 mt-8">
      <?php foreach($page->children() as $chapter):
        $wordCount = str_word_count($chapter->wcontent()->kt());
        $readingTime = ceil($wordCount / 225);
      ?>
      <a href="<?= $chapter->url() ?>"
         class="chapter-item block p-4 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-all flex justify-between items-center"
         data-chapter-id="<?= $chapter->slug() ?>">
        <h3 class="chapter-title text-lg font-medium dark:text-gray-100 transition-opacity"><?= $chapter->title() ?></h3>
        <span class="chapter-time text-sm text-gray-500 dark:text-gray-400 transition-opacity"><?= $readingTime ?> min</span>
      </a>
      <?php endforeach ?>
    </div>
  </div>
</div>

<script>
// Update book progress on page load
document.addEventListener('DOMContentLoaded', () => {
  const bookId = document.body.dataset.bookId;
  if (!bookId) return;

  // Get chapters read
  const key = `${Grimoire.KEYS.CHAPTER_PROGRESS}_${bookId}`;
  const chaptersRead = Grimoire.storage.get(key, []);

  // Get all chapters
  const chapterItems = document.querySelectorAll('.chapter-item');
  const totalChapters = chapterItems.length;

  if (totalChapters === 0) return;

  // Mark completed chapters with subtle opacity
  chapterItems.forEach(item => {
    const chapterId = item.dataset.chapterId;
    if (chaptersRead.includes(chapterId)) {
      const title = item.querySelector('.chapter-title');
      const time = item.querySelector('.chapter-time');
      title.style.opacity = '0.4';
      time.style.opacity = '0.4';
    }
  });

  // Show progress if any chapters read
  if (chaptersRead.length > 0) {
    const progressPercentage = Math.round((chaptersRead.length / totalChapters) * 100);
    document.getElementById('book-progress').classList.remove('hidden');
    document.getElementById('progress-percentage').textContent = `${chaptersRead.length} of ${totalChapters} chapters (${progressPercentage}%)`;
    document.getElementById('progress-bar').style.width = `${progressPercentage}%`;
  }

  // Find last read chapter and show resume button
  let lastReadChapter = null;
  let lastReadTime = 0;

  chapterItems.forEach(item => {
    const chapterId = item.dataset.chapterId;
    const positionKey = `${Grimoire.KEYS.READING_POSITION}_${bookId}_${chapterId}`;
    const position = Grimoire.storage.get(positionKey);

    if (position && position.timestamp > lastReadTime) {
      lastReadTime = position.timestamp;
      lastReadChapter = item;
    }
  });

  if (lastReadChapter) {
    const resumeBtn = document.getElementById('resume-reading-btn');
    const resumeContainer = document.getElementById('resume-reading-container');
    resumeBtn.href = lastReadChapter.href;
    resumeContainer.classList.remove('hidden');
  }
});
</script>

<?php snippet('scripts') ?>