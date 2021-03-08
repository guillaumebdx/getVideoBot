<?php


namespace App\Service\Image;


class Color extends ImageConfigurator
{
    public function greyscale($origin)
    {
        $img = $this->manager->make($origin)->greyscale();
        $img->save('generate/' . uniqid(). '.png');
        return $img;
    }

    public function redify($origin)
    {
        $img = $this->manager->make($origin)->colorize(100, 0, 0);
        $img->save('generate/' . uniqid(). '.png');
        return $img;
    }

    public function sepia($origin)
    {
        $img = $this->manager->make($origin)->greyscale();
        $img->colorize(90,60,40);
        $img->save('generate/' . uniqid(). '.png');
        return $img;
    }
}
