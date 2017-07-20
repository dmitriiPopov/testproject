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
       Console::output('Start...');

       //GET news with `to publicate` status with publish date less then current datetime, and enabled/displayed
       $articlesToPublish = News::find()
           ->andWhere(['status'  => News::STATUS_PUBLICATE])
           ->andWhere(['display' => News::DISPLAY_OFF])
           //@TODO: add new `andWhere()` condition - get news before `public_at`
           ->all();

       //for each object do...
       //loop begin...
       foreach ($articlesToPublish as $article) {/**@var $article News*/

           //SET status to 'publish'
           $article->status       = News::STATUS_PUBLISHED;
           //SET datetime (published_at)
           $article->published_at = date('Y-m-d H:i:s', time());

           //SAVE selected model
           if ($article->save()) {
               Console::output(sprintf('Topic #%d has been published!', $article->id));
           //if article hasn't been saved than to throw notification
           } else {
               Console::output(sprintf('Topic #%d has NOT been published!', $article->id));
           }

       }
       //loop end

       Console::output('Finish.');
   }
}