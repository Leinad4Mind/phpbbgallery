<?php
namespace Shift\AvatarMaker\Shape;


use Intervention\Image\ImageManager;

class Circle extends AbstractShape
{

    /**
     * @param string $backgroundColor
     *
     * @return \Intervention\Image\Image
     */
    public function getShapedImage($backgroundColor)
    {
        $image = $this->getImageManager()->canvas($this->size, $this->size, [0, 0, 0, 0]);
        $image->circle($this->size - 1, $this->size / 2, $this->size / 2, function ($draw) use ($backgroundColor) {
            $draw->background($backgroundColor);
        });

        return $image;
    }


}