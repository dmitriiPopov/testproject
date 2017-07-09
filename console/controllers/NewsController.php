<?php
namespace console\controllers;

use yii\helpers\Console;
use common\models\News;

/**
 * Class NewsController
 * @package yii\console\controllers
 *
 * List of commands for actions with News and related entities:
 * ::publish() - to publish article in particular time (run by CRON)
 */
class NewsController extends \yii\console\Controller
{
    /**
     * To publish article in particular time
     * It means Change `News` state from 'publicate' to 'published'
     * Used by CRON
     */
   public function actionPublish()
   {
       //Console::output('Start...');

       //GET news with `to publicate` status with publish date less then current datetime, and enabled/displayed
       $articlesToPublish = News::find()->andWhere(['status' => 'publicate'])->all();
       //for each object do...
       foreach ($articlesToPublish as $article) {
           //SET status to 'publish'
           $article->status = 'published';
           //SET datetime (published_at)
           if($article->status === 'published')
           {
               $article->published_at = date('Y-m-d H:i:s', time());
           }
           //SAVE selected model
           $article->save();
           //loop end
       }
       //Console::output('Finish.');
   }
}