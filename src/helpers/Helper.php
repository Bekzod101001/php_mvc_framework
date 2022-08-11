<?php

namespace app\helpers;

class Helper
{
    public static function emailIsValid(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function beautifiedDump(mixed $data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public static function getFilesOfDirectory(string $path)
    {
        $filePaths = scandir($path);
        return array_filter($filePaths, function($filePath){
            if($filePath === '..' || $filePath === '.') return false;

            return true;
        });
    }
}