<?php
namespace common\components;

/**
 * Class UploadedFile
 * @package common\components
 */
class UploadedFile extends \yii\web\UploadedFile
{
    /**
     * @param string $file
     * @param bool $deleteTempFile
     * @return bool
     */
    public function saveAs($file, $deleteTempFile = true)
    {
        $path = '';
        //split the path and set array
        $directoriesList = array_filter(explode('/', $file));
        //unset filename from directories list
        array_pop($directoriesList);
        //handle each part of path...
        foreach ($directoriesList as $directory){
            //set path for dir
            $path .= DIRECTORY_SEPARATOR . $directory;
            //check if there is a dir
            if(!file_exists($path)){
                //create a new directory
                mkdir($path, 0775);
            }
        }
        //save file
        return parent::saveAs($file, $deleteTempFile);
    }


}