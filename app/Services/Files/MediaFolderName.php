<?php

namespace App\Services\Files;

class MediaFolderName
{
    public static function get_folder_name($media_type)
    {
        if ($media_type == 'image') {
            return 'images';
        }
        elseif ($media_type == 'video') {
            return 'videos';
        }
        elseif ($media_type == 'audio') {
            return 'audios';
        }
        elseif (in_array($media_type, ['doc', 'pdf', 'excel'])) {
            return 'docs';
        }
        elseif (in_array($media_type, ['file', 'zip'])) {
            return 'files';
        }
        else{
            return 'files';
        }
    }

}
