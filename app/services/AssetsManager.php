<?php namespace App\Services;

use Illuminate\Filesystem\Filesystem;
use \Config;

class AssetsManager 
{
    protected $filesystem;
    protected $path;

    public function __construct(Filesystem $filesystem) 
    {
        $this->filesystem = $filesystem;
        $this->path = app_path();
    }
    
    public function assets() 
    {
        $assets = array();
        $data = $this->getData();
        foreach ($data as $groupName => $group) {
            $assets[$groupName] = array();
            foreach ($group as $filetype => $files) {
                $assets[$groupName][$filetype] = array();
                foreach ($files as $key => $value) {
                    if (Config::get('lama.isdev')) {
                        // Development
                        $assets[$groupName][$filetype] = array_merge($assets[$groupName][$filetype], $this->getAssets($value));
                    } else {
                        // Prodution
                        array_push($assets[$groupName][$filetype], $key);
                    }
                }
            }
        }
        return $assets;
    }
    
    protected function getAssets($pattern) 
    {
        $files = array();
        if(is_array($pattern)){
            foreach($pattern as $path){
                $files = array_merge($files,$this->getAssets($path));  
            } 
        }
        else{
          $pattern= str_replace('public/','',$pattern);
          $files = $this->rglob($pattern); 
        }
        return $files;
    }
    
    protected function getFile() 
    {
        return $this->filesystem->get($this->path.'/config/assets.json');
    }
    
    protected function getData() 
    {
        $data = json_decode($this->getFile(), true);
        $case = json_last_error();
        if(($data === null) || ($case !== JSON_ERROR_NONE)){
           switch ($case) {
                case JSON_ERROR_DEPTH:
                    $error = ' - Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $error = ' - Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $error = ' - Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    $error = ' - Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    $error = ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                default:
                    $error = ' - Unknown error';
                    break;
            }
            throw new \UnexpectedValueException($error);
        }
        return $data;
    }
    
    // Does not support flag GLOB_BRACE
    protected function rglob($pattern, $flags = 0) 
    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
            if(stripos($dir,'bower_components') === false){
                $files = array_merge($files, $this->rglob($dir.'/'.basename($pattern), $flags));
            }
        }
        return $files;
    }
}

