<?php
namespace App\Models;

class VideoModel {
    public static function getYoutubeVideoId($url) {
        if (empty($url)) {
            return null;
        }
        
        $videoId = null;
        
        $patterns = [
            '/youtube\.com\/watch\?v=([^\&\?\/]+)/',
            '/youtube\.com\/embed\/([^\&\?\/]+)/',
            '/youtube\.com\/v\/([^\&\?\/]+)/',
            '/youtu\.be\/([^\&\?\/]+)/'
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                $videoId = $matches[1];
                break;
            }
        }
        
        return $videoId;
    }

    public static function isYoutubeUrl($url) {
        return !empty(self::getYoutubeVideoId($url));
    }
}