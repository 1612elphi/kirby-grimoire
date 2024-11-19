<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page->title() ?> | <?= $site->name() ?></title>
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="/assets/css/tailwind.css">
    <link rel="stylesheet" href="/assets/css/pages/<?= $site->intendedTemplate() ?>.css">
    <link rel="icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
      <meta name="og:title" content="<?= $page->title() ?>">
      <?php if ($site->intendedTemplate() == 'book'): ?>
      <?php if ($page->cover()->isNotEmpty()): ?>
        <meta property="og:image" content="<?= $page->cover()->toFile()->url() ?>">
      <?php endif ?>
      <?php if ($page->blurb()->isNotEmpty()): ?>
        <meta name="og:description" content="<?= $page->blurb() ?>">
        <meta name="description" content="<?= $page->blurb() ?>">
      <?php endif ?>
      <?php endif ?>
    <?php
    $jsFiles = glob('/assets/js/*.js');
    foreach($jsFiles as $js): ?>
      <script src="<?= $js ?>" defer></script>
    <?php endforeach ?>
  </head>
  
  <script>
    function toggleFullScreen() {
      if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
      } else {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        }
      }
    }
  </script>
  