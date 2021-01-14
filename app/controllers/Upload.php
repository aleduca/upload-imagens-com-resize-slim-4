<?php

namespace app\controllers;

use Exception;
use app\classes\Image;

class Upload
{
    public function upload($request, $response)
    {
        try {
            $upload = new Image($_FILES);
            $upload->upload(300, 'uploads');
        } catch (Exception $e) {
            var_dump('error', $e->getMessage());
        }
        return $response;
    }
}
