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
           ->andWhere(['status'  => News::STATUS_PUBLICATE, 'enabled' => News::ENABLED_ON])
           ->andWhere(['display' => News::DISPLAY_OFF])
           ->andWhere(['<=','public_at', date("Y-m-d H:i:s")])
           ->all();

       //for each object do...
       //loop begin...
       foreach ($articlesToPublish as $article) {/**@var $article News*/

           //SET status to 'publish'
           $article->status       = News::STATUS_PUBLISHED;
           //SET datetime (published_at)
           $article->published_at = date('Y-m-d H:i:s');
           //RESET datetime (public_at)
           $article->public_at    = null;

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