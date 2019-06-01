<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "customer_history_card".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $card_id
 * @property int $amount Số lần sử dụng
 * @property string $started_date
 * @property int $money Số tiền còn lại
 * @property int $sub_money Số tiền trừ mỗi lần sử dụng
 * @property string $note Ghi chú
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class CustomerHistoryCard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_history_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'card_id', 'amount', 'money', 'sub_money', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['note'], 'string', 'max' => 1000],
            [['started_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'customer_id' => Yii::t('common', 'Customer ID'),
            'card_id' => Yii::t('common', 'Card ID'),
            'amount' => Yii::t('common', 'Amount'),
            'money' => Yii::t('common', 'Money'),
            'sub_money' => Yii::t('common', 'Sub Money'),
            'note' => Yii::t('common', 'Note'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\CustomerHistoryCardQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\CustomerHistoryCardQuery(get_called_class());
    }
}
