<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 21.04.2021
 * Time: 15:10
 */

namespace app\controllers;


use app\controllers\actions\SearchRateAction;
use yii\rest\ActiveController;

class RateController extends ActiveController
{
    public $modelClass = 'app\models\search\SearchRate';

    public function actions()
    {
        return [
            'index' => [
                'class' => SearchRateAction::class,
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
        ];
    }
}