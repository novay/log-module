<?php

/**
 * Clean the url for the front end to display.
 *
 * @param string $link
 * @return echo string
 */
if (!function_exists('showCleanRoutUrl')) {
    function showCleanRoutUrl($link) {
        $parsedUrl = parse_url($link);
        $routeUrl = '';
        
        if (isset($parsedUrl['path'])) {
            $routeUrl .= $parsedUrl['path'];
        }
        
        if (isset($parsedUrl['query'])) {
            $routeUrl .= '?'.$parsedUrl['query'];
        }
        
        echo $routeUrl;
    }
}