<?php

if (! function_exists('fromJSONFile')) {
    /**
     * @param string $file
     * @param null $var
     * @return array
     */
    function fromJSONFile($file = "menu-off", $var = null) : array
    {
        $path = config_path("{$file}.json");
        $_file = file_exists($path) ? $path : config_path("menu-off.json");
        $fileContent = file_get_contents($_file)?:"";

        if(!$fileContent) {
            $result = [];
        } else {
            $result = json_decode($fileContent, true)?:[];
        }

        if(!is_null($var)) {
            $var = array_key_exists($var, $result) ? $var : "all";
            $result = $result[ $var ];
        }
        return $result;
    }
}


/** Application Options */
return [
    // main menu disabled menus
//    'menu-off'  =>  fromJSONFile("menu-off", env('CLINET_NAME', null)),

];
