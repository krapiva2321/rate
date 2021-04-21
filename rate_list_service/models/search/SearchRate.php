<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 21.04.2021
 * Time: 14:29
 */

namespace app\models\search;


use yii\base\Model;
use yii\data\ArrayDataProvider;
use Yii;
use DateTime;
use yii\db\Query;

class SearchRate extends Model
{
    public $office_id;
    public $at_date;

    public function rules()
    {
        return [
            ['at_date', 'required'],
            ['at_date', 'datetime', 'format' => 'php:d.m.Y H:i:s'],
            ['office_id', 'string']
        ];
    }

    public function search() {
        if(!$this->validate()) {
            return [];
        }
        $begins_at = (new DateTime($this->at_date))->format('Y-m-d H:i:s');

        $queryBase = (new Query())
            ->select([
                'office_id',
                'currency',
                'MAX(begins_at) as date'
            ])
            ->from('rate')
            ->where(['AND',
                ['office_id' => $this->office_id],
                ['<=', 'begins_at', $begins_at]
            ])
            ->groupBy(['office_id','currency']);

        $query = (new Query())
            ->select([
                'rate.currency',
                'rate.begins_at',
                'rate.office_id',
                'rate.buy',
                'rate.sell'
            ])
            ->from('rate')
            ->where(['AND',
                ['rate.office_id' => $this->office_id],
                ['<=', 'rate.begins_at', $begins_at]
            ]);

            $inner_on_condition = '
               rate.currency = rate_cond.currency
               and rate.begins_at = rate_cond.date
            ';
            if ($this->office_id) {
                $inner_on_condition .= ' AND rate.office_id = rate_cond.office_id';
            }
            $query->innerJoin(['rate_cond' => $queryBase], $inner_on_condition);
        return $query->createCommand()->queryAll();
    }
}