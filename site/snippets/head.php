<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site->name() ?></title>
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="/assets/css/tailwind.css">
    <link rel="stylesheet" href="/assets/css/pages/<?= $site->intendedTemplate() ?>.css">
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
  