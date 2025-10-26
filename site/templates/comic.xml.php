<?php
header('Content-type: application/xml');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/">
  <channel>
    <title><?= esc($page->title()) ?></title>
    <link><?= esc($page->url()) ?></link>
    <description><?= esc($page->blurb()) ?></description>
    <lastBuildDate><?= date('r', $page->modified()) ?></lastBuildDate>
    <atom:link href="<?= esc($page->url() . '.xml') ?>" rel="self" type="application/rss+xml" />

    <?php foreach($page->children()->flip() as $comicPage): ?>
    <?php
    $pageImage = $comicPage->image();
    ?>
    <item>
      <title><?= esc($comicPage->pagename()->or($comicPage->title())->or('Page ' . ($page->children()->indexOf($comicPage) + 1))) ?></title>
      <link><?= esc($comicPage->url()) ?></link>
      <guid><?= esc($comicPage->url()) ?></guid>
      <pubDate><?= date('r', $comicPage->modified()) ?></pubDate>
      <?php if($comicPage->caption()->isNotEmpty()): ?>
      <description><?= esc($comicPage->caption()) ?></description>
      <?php endif ?>

      <?php if($pageImage): ?>
      <enclosure url="<?= esc($pageImage->url()) ?>" length="<?= $pageImage->size() ?>" type="<?= $pageImage->mime() ?>" />
      <media:content url="<?= esc($pageImage->url()) ?>" medium="image" type="<?= $pageImage->mime() ?>" />
      <?php endif ?>

      <content:encoded><![CDATA[
        <?php if($pageImage): ?>
        <p><img src="<?= $pageImage->url() ?>" alt="<?= esc($comicPage->alt()->or($comicPage->title())) ?>" /></p>
        <?php endif ?>

        <?php if($comicPage->caption()->isNotEmpty()): ?>
        <p><?= $comicPage->caption()->html() ?></p>
        <?php endif ?>

        <?php if($comicPage->commentary()->isNotEmpty() && $comicPage->commentary_mode() != 'hidden'): ?>
        <div class="author-commentary">
          <h3>Author Commentary</h3>
          <?= $comicPage->commentary()->kt() ?>
        </div>
        <?php endif ?>
      ]]></content:encoded>
    </item>
    <?php endforeach ?>

  </channel>
</rss>
