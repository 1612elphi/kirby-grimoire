<?php
header('Content-type: application/xml');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title><?= esc($page->title()) ?></title>
    <link><?= esc($page->url()) ?></link>
    <description><?= esc($page->blurb()) ?></description>
    <lastBuildDate><?= date('r', $page->modified()) ?></lastBuildDate>
    <atom:link href="<?= esc($page->url() . '.xml') ?>" rel="self" type="application/rss+xml" />
    
    <?php foreach($page->children()->listed()->sortBy('date', 'desc') as $chapter): ?>
    <item>
      <title><?= esc($chapter->title()) ?></title>
      <link><?= esc($chapter->url()) ?></link>
      <guid><?= esc($chapter->url()) ?></guid>
      <pubDate><?= date('r', $chapter->modified()) ?></pubDate>
      <?php if($chapter->subtitle()->isNotEmpty()): ?>
      <description><?= esc($chapter->subtitle()) ?></description>
      <?php endif ?>
      <content:encoded><![CDATA[
        <?= $chapter->wcontent()->kt() ?>
        <?php if($chapter->anmode() != 'not' && $chapter->an()->isNotEmpty()): ?>
        <div class="authors-note">
          <h3>Author's Note</h3>
          <?= $chapter->an()->kt() ?>
        </div>
        <?php endif ?>
      ]]></content:encoded>
    </item>
    <?php endforeach ?>
    
  </channel>
</rss>