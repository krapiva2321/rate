<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 19.04.2021
 * Time: 22:31
 */

namespace app\job;


use yii\base\BaseObject;

class SaveCurrencyJob extends BaseObject implements \yii\queue\JobInterface
{
    public $id;

    public function execute($queue)
    {
    }
}