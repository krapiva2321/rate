<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 21.04.2021
 * Time: 12:05
 */

namespace app\models\behavior;


use yii\base\Behavior;
use yii\db\ActiveRecord;
use Yii;
use DateTime;

class DatetimeBehavior extends Behavior
{
    public $attribute;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_VALIDATE => 'beforeSave',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_FIND => 'afterSave',

        ];
    }

    public function beforeSave($event)
    {
        $attribute = $this->attribute;
        if ($this->owner->$attribute) {
            $this->owner->$attribute = (new DateTime($this->owner->$attribute))->format('Y-m-d H:i:s');
        }
    }

    public function afterSave($event)
    {
        $attribute = $this->attribute;
        if ($this->owner->$attribute) {
            $this->owner->$attribute = (new DateTime($this->owner->$attribute))->format('d.m.Y H:i:s');
        }
    }
}