<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Basic Meta -->
    <title><?= $page->title() ?> | <?= $site->name() ?></title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="/assets/css/tailwind.css">
    <link rel="stylesheet" href="/assets/css/pages/<?= $site->intendedTemplate() ?>.css">
    
    <!-- Favicons -->
    <link rel="icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    
    <!-- Open Graph / Twitter Cards -->
    <?php
    // Set default values
    $ogTitle = $page->title() . ' | ' . $site->name();
    $ogDescription = '';
    $ogImage = '';
    $ogType = 'website';
    
    // Page-specific meta handling
    switch($page->intendedTemplate()->name()) {
        case 'book':
            $ogType = 'book';
            if($page->blurb()->isNotEmpty()) {
                $ogDescription = $page->blurb()->excerpt(160);
            }
            if($page->cover()->isNotEmpty()) {
                $ogImage = $page->cover()->toFile()->url();
            }
            break;
            
        case 'chapter':
            $ogType = 'article';
            if($page->wcontent()->isNotEmpty()) {
                $ogDescription = $page->wcontent()->excerpt(160);
            }
            // Try to get cover from parent book
            if($page->parent()->cover()->isNotEmpty()) {
                $ogImage = $page->parent()->cover()->toFile()->url();
            }
            break;
            
        case 'default':
            if($page->text()->isNotEmpty()) {
                $ogDescription = $page->text()->excerpt(160);
            }
            break;
    }
    ?>
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= $ogTitle ?>">
    <meta property="og:type" content="<?= $ogType ?>">
    <meta property="og:url" content="<?= $page->url() ?>">
    <?php if($ogDescription): ?>
    <meta property="og:description" content="<?= $ogDescription ?>">
    <?php endif ?>
    <?php if($ogImage): ?>
    <meta property="og:image" content="<?= $ogImage ?>">
    <?php endif ?>
    <meta property="og:site_name" content="<?= $site->name() ?>">
    
    <!-- Twitter Cards -->
    <meta name="twitter:card" content="<?= $ogImage ? 'summary_large_image' : 'summary' ?>">
    <meta name="twitter:title" content="<?= $ogTitle ?>">
    <?php if($ogDescription): ?>
    <meta name="twitter:description" content="<?= $ogDescription ?>">
    <?php endif ?>
    <?php if($ogImage): ?>
    <meta name="twitter:image" content="<?= $ogImage ?>">
    <?php endif ?>
    
    <!-- Standard Meta -->
    <?php if($ogDescription): ?>
    <meta name="description" content="<?= $ogDescription ?>">
    <?php endif ?>
    
    <!-- Scripts -->
    <?php
    $jsFiles = glob('/assets/js/*.js');
    foreach($jsFiles as $js): ?>
        <script src="<?= $js ?>" defer></script>
    <?php endforeach ?>

</head>