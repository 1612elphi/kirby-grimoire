<?php

use Kirby\Cms\Page;
use Kirby\Cms\Pages;

class ComicPage extends Page
{
    /**
     * Override children() to generate virtual pages from uploaded images
     * Each image file with the comic-page template becomes a virtual page
     */
    public function children(): Pages
    {
        $pages = [];

        // Get all images with the comic-page template
        $images = $this->images()->template('comic-page');

        foreach ($images as $image) {
            $pages[] = [
                'slug'     => $image->name(),  // Use filename without extension
                'num'      => $image->sort()->value(),  // Respect manual sorting
                'template' => 'comic-page',
                'model'    => 'comic-page',
                'content'  => $image->content()->toArray(),  // Pass file metadata as page content
            ];
        }

        return Pages::factory($pages, $this);
    }
}
