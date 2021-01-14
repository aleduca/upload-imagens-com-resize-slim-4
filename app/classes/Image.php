<?php

namespace app\classes;

use Exception;

class Image
{
    private $fileName;
    private $fileTemp;
    private $extension;
    private $width;
    private $height;
    private $acceptedExtensions = ['jpg', 'jpeg', 'png'];

    public function __construct($image)
    {
        $this->fileName = $image['file']['name'];
        $this->fileTemp = $image['file']['tmp_name'];
        $this->extension = pathinfo($this->fileName, PATHINFO_EXTENSION);
        list($this->width, $this->height) = getimagesize($this->fileTemp);
    }

    public function upload($widthToResize, $folder)
    {
        if (!in_array($this->extension, $this->acceptedExtensions)) {
            throw new Exception('Extensão não aceita');
        }

        $heigthToResize = ceil($this->height * ($widthToResize / $this->width));
        $newName = time();

        switch ($this->extension) {
          case 'jpeg':
          case 'jpg':
            $fromJpeg = imagecreatefromjpeg($this->fileTemp);
            $imageLayer = imagecreatetruecolor($widthToResize, $heigthToResize);
            imagecopyresampled($imageLayer, $fromJpeg, 0, 0, 0, 0, $widthToResize, $heigthToResize, $this->width, $this->height);
            imagejpeg($imageLayer, './' . $folder . '/' . $newName . '.' . $this->extension);
            break;
          case 'png':
            $fromPng = imagecreatefrompng($this->fileTemp);
            $imageLayer = imagecreatetruecolor($widthToResize, $heigthToResize);
            imagecopyresampled($imageLayer, $fromPng, 0, 0, 0, 0, $widthToResize, $heigthToResize, $this->width, $this->height);
            imagepng($imageLayer, './' . $folder . '/' . $newName . '.' . $this->extension);
            break;

          default:
            throw new Exception('Extensão não aceita');
            break;
        }
    }
}
