<?php

namespace app\models;

use app\models\behavior\DatetimeBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string|null $currency
 * @property float|null $buy
 * @property float|null $sell
 * @property string $begins_at
 * @property string|null $office_id
 * @property string $created_at
 * @property string $updated_at
 */
class Rate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['begins_at', 'currency', 'buy', 'sell'], 'required'],
            [['buy', 'sell'], 'number'],
            [['begins_at'], 'datetime', 'format' => 'php:d.m.Y H:i:s'],
            [['currency'], 'string', 'max' => 10],
            [['office_id'], 'string', 'max' => 255],
            [['begins_at'], 'checkUnique'],
        ];
    }

    public function checkUnique($attribute)
    {
        $params = [
            'office_id' => $this->office_id,
            'begins_at' => (new \DateTime($this->begins_at))->format('Y-m-d H:i:s'),
            'currency' => $this->currency
        ];
        if (self::findOne($params)) {
            $this->addError($attribute, 'This rate not unique');
        }
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => DatetimeBehavior::class,
                'attribute' => 'begins_at',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'currency' => 'Currency',
            'buy' => 'Buy',
            'sell' => 'Sell',
            'begins_at' => 'Begins At',
            'office_id' => 'Office ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
