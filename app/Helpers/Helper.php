<?php

if(!defined('DIRECTORY_SEPARATOR_L')) {
    /**
     * opposite of DIRECTORY_SEPARATOR
     */
    @define("DIRECTORY_SEPARATOR_L", "/");
}

/**
 * @param $path
 *
 * @return string
 */
function fixPath($path) {
    $path = str_ireplace(DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR_L, $path);
    $path = str_ireplace(DIRECTORY_SEPARATOR_L . DIRECTORY_SEPARATOR_L, DIRECTORY_SEPARATOR_L, $path);
    return trim($path);
}
