<?php


namespace App\Service\Image;


use Intervention\Image\ImageManager;

abstract class ImageConfigurator
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(['driver' => 'gd']);
    }
}
