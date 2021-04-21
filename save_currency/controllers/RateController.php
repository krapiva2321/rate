<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 20.04.2021
 * Time: 5:18
 */

namespace app\controllers;


use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class RateController extends ActiveController
{
    public $modelClass = 'app\models\Rate';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];
        return $behaviors;
    }
}