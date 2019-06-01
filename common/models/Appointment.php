<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "appointment".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $customer_name
 * @property int $appointment_time
 * @property int $end_time
 * @property int $number_customer
 * @property int $employee_id Nhân viên yêu cầu
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Appointment extends base\Appointment
{

    public $start_time;
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['customer_id', 'service_id', 'employee_id'], 'required'],
            [['service_id', 'customer_id', 'number_customer', 'employee_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['service_name', 'customer_name', 'phone'], 'string', 'max' => 255],
            [['note'], 'string', 'max' => 500],
            [['end_time'], 'safe'],
	        //[['appointment_time'], 'required'],
	        [['appointment_time','end_time'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
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
            'customer_name' => Yii::t('common', 'Khách hàng'),
            'appointment_time' => Yii::t('common', 'Giờ hẹn'),
            'end_time' => Yii::t('common', 'Đến'),
            'number_customer' => Yii::t('common', 'Số khách'),
            'employee_id' => Yii::t('common', 'Chọn nhân viên'),
            'phone' => Yii::t('common', 'Điện thoại'),
            'note' => Yii::t('common', 'Ghi chú'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\AppointmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\AppointmentQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }
}
