<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

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
class CustomerHistoryService extends base\CustomerHistoryService
{
    public $customer_name;
    public $services;

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
            [['customer_id', 'service_id', 'amount', 'amount_use', 'amount_remain', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['note'], 'string', 'max' => 1000],
            [['started_date'], 'filter', 'filter' => 'date', 'skipOnEmpty' => true],
            ['services','safe'],
            ['started_date','required'],
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
            'service_id' => Yii::t('common', 'Dịch vụ'),
            'started_date' => Yii::t('common', 'Ngày '),
            'amount' => Yii::t('common', 'Giá trị'),
            'amount_use' => Yii::t('common', 'Sử dụng'),
            'amount_remain' => Yii::t('common', 'Còn lại'),
            'note' => Yii::t('common', 'Diễn giải'),
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
        return new \common\models\query\CustomerHistoryServiceQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }
}
