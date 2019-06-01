<?php

namespace common\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "activity".
 *
 * @property int $id
 * @property int $service_id
 * @property string $service_name
 * @property int $customer_id
 * @property string $customer_name
 * @property int $employee_id Nhân viên yêu cầu
 * @property int $start_time
 * @property int $end_time
 * @property string $bed Số giường
 * @property string $note Ghi chú
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Activity extends \yii\db\ActiveRecord
{
    const OBJECT_TYPE_COMBO = 'combo';
    const OBJECT_TYPE_CARD = 'card';
    const OBJECT_TYPE_SERVICE = 'service';

    public $services;
    public $products;
    public $rate_reception_input;
    public $count_time;
    public $total_money;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity';
    }


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
            [['customer_id', 'service_id', 'start_time'], 'required'],
            [['service_id', 'customer_id', 'employee_id','discount', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['service_name', 'customer_name', 'bed'], 'string', 'max' => 255],
            [['note'], 'string', 'max' => 500],
            [['start_time'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['end_time'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['services','products','reception_id'], 'safe'],
            [['rate_reception'], 'number'],
            [['rate_reception_input','count_time','total_money'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'service_id' => Yii::t('common', 'Dịch vụ'),
            'service_name' => Yii::t('common', 'Dịch vụ'),
            'customer_id' => Yii::t('common', 'Khách hàng'),
            'customer_name' => Yii::t('common', 'Tên khách hàng'),
            'employee_id' => Yii::t('common', 'Nhân viên'),
            'start_time' => Yii::t('common', 'Giờ bắt đầu'),
            'end_time' => Yii::t('common', 'Giờ kết thúc'),
            'bed' => Yii::t('common', 'Số giường'),
            'note' => Yii::t('common', 'Note'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'discount' => Yii::t('common', 'Thưởng tua'),
            'rate_reception' => Yii::t('common', 'Doanh thu'),
            'reception_id' => Yii::t('common', 'Lễ tân'),
            'rate_reception_input' => Yii::t('common', 'Doanh thu'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\ActivityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\ActivityQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(\common\models\Customer::class, ['id' => 'customer_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(\common\models\Employee::class, ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(\common\models\Service::class, ['id' => 'service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceProducts()
    {
        return $this->hasMany(\common\models\ServiceProduct::class, ['service_id' => 'service_id']);
    }
}
