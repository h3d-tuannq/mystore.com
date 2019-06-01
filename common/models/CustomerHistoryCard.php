<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "customer_history_card".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $card_id
 * @property string $started_date
 * @property int $amount Số lần sử dụng
 * @property int $money Số tiền còn lại
 * @property int $sub_money Số tiền trừ mỗi lần sử dụng
 * @property string $note Ghi chú
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class CustomerHistoryCard extends base\CustomerHistoryCard
{
    public $customer_name;
    public $services;
    public $products;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'card_id', 'amount', 'money', 'sub_money', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['note'], 'string', 'max' => 1000],
            [['started_date'], 'filter', 'filter' => 'date', 'skipOnEmpty' => true],
            [['services','products'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'customer_id' => Yii::t('common', 'Khách hàng'),
            'card_id' => Yii::t('common', 'Thẻ'),
            'amount' => Yii::t('common', 'Tài khoản thẻ'),
            'money' => Yii::t('common', 'Số tiền'),
            'sub_money' => Yii::t('common', 'Số tiền sử dụng'),
            'note' => Yii::t('common', 'Diễn giải'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'started_date' => Yii::t('common', 'Ngày '),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\CustomerHistoryCardQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CustomerHistoryCardQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCard()
    {
        return $this->hasOne(Card::class, ['id' => 'card_id']);
    }

}
