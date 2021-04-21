<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 21.04.2021
 * Time: 15:19
 */

namespace app\controllers\actions;


use app\models\search\SearchRate;
use yii\rest\IndexAction;
use Yii;

class SearchRateAction extends IndexAction
{
    protected function prepareDataProvider()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }
        $model = new SearchRate();
        $model->setAttributes($requestParams);
        return $model->search();
    }
}