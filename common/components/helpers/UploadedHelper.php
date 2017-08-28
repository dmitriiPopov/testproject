<?php
namespace common\components\helpers;

use yii\web\UploadedFile;

/*
 * Class UploadedHelper
 * @package common\components\helpers
 */
class UploadedHelper extends UploadedFile
{
    /**
     * @param string $file
     * @param bool $deleteTempFile
     * @return bool
     */
    public function saveAs($file, $deleteTempFile = true)
    {
        $path = "";
        //split the path and set array
        $dirs = explode('/', $file);
        //remove last element(filename) from array
        array_pop($dirs);

        foreach ($dirs as $dir){
            //set path for dir
            $path .= $dir."/";
            //check if there is a dir
            if(!is_dir($path)){
                //create a new dir
                mkdir($path, 0755);
            }
        }
        //save file
        return parent::saveAs($file, $deleteTempFile);
    }
}