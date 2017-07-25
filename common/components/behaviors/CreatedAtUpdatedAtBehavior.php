<?php
namespace common\components\behaviors;


/**
 * Class CreatedAtUpdatedAtBehavior
 * @package common\components\behaviors
 *
 * Behavior for insert/update datetime in format Y-m-d H:i:s for different ActiveRecords
 */


//TODO add to behaviors function in active records Category and News

use yii\db\ActiveRecord;

class CreatedAtUpdatedAtBehavior extends \yii\base\Behavior
{
    /**
     * @var string
     */
    public $datetimeFormat = 'Y-m-d H:i:s';

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    /**
     * @return void
     */
    public function beforeInsert()
    {
        $this->owner->created_at = date($this->datetimeFormat);
    }

    /**
     * @return void
     */
    public function beforeUpdate()
    {
        $this->owner->updated_at = date($this->datetimeFormat);
    }
}