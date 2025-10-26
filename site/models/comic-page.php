<?php

use Kirby\Cms\Page;
use Kirby\Cms\File;

class ComicPagePage extends Page
{
    /**
     * Override image() to retrieve the actual image file from the parent comic
     * Since this is a virtual page, we need to fetch the file from the parent
     */
    public function image(string $filename = null): File|null
    {
        // If no filename specified, get the image that created this virtual page
        if (!$filename) {
            return $this->parent()->images()
                ->template('comic-page')
                ->findBy('name', $this->slug());
        }

        // Otherwise, use default behavior
        return parent::image($filename);
    }

    /**
     * Override files() to return the image file as a collection
     */
    public function files(): \Kirby\Cms\Files
    {
        $image = $this->image();
        if ($image) {
            return $this->parent()->images()->filter(function($file) use ($image) {
                return $file->id() === $image->id();
            });
        }
        return parent::files();
    }
}
