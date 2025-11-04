<?php

if (!function_exists('storage_url')) {
    /**
     * Generate storage URL without /public in path
     */
    function storage_url($path = null)
    {
        $baseUrl = rtrim(config('app.url', 'http://localhost'), '/');
        
        // Remove /public if exists in base URL
        $baseUrl = str_replace('/public', '', $baseUrl);
        
        if ($path) {
            $path = ltrim($path, '/');
            return $baseUrl . '/storage/' . $path;
        }
        
        return $baseUrl . '/storage';
    }
}

