<?php

namespace App\Services\Files;

class MediaTypeService
{
    public static function get_media_type(string $extenstion): string
    {
        if (in_array($extenstion, ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
            return 'image';
        }
        else if (in_array($extenstion, ['mp4', 'avi', 'mov'])) {
            return 'video';
        }
        else if (in_array($extenstion, ['xls', 'xlsx'])) {
            return 'excel';
        }
        else if (in_array($extenstion, ['doc', 'docx', 'txt'])) {
            return 'doc';
        }
        else if ($extenstion =='pdf') {
            return 'pdf';
        }
        else if (in_array($extenstion, ['zip', 'rar', 'tar'])) {
            return 'zip';
        }
        else if ($extenstion == 'mp3') {
            return 'audio';
        }
        else {
            return 'file';
        }
    }
}
