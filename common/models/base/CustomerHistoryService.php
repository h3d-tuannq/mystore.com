<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "customer_history_service".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $service_id
 * @property string $started_date
 * @property int $amount Số lần sử dụng của dịch vụ khi mua
 * @property int $amount_use Số lần đã sử dụng dịch vụ
 * @property int $amount_remain Số lần còn lại
 * @property string $note Ghi chú
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class CustomerHistoryService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_history_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'service_id', 'amount', 'amount_use', 'amount_remain', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['started_date'], 'safe'],
            [['note'], 'string', 'max' => 1000],
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
            'service_id' => Yii::t('common', 'Service ID'),
            'started_date' => Yii::t('common', 'Started Date'),
            'amount' => Yii::t('common', 'Amount'),
            'amount_use' => Yii::t('common', 'Amount Use'),
            'amount_remain' => Yii::t('common', 'Amount Remain'),
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
     * @return \common\models\base\query\CustomerHistoryServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\CustomerHistoryServiceQuery(get_called_class());
    }
}
