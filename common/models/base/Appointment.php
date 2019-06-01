<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "appointment".
 *
 * @property int $id
 * @property int $service_id
 * @property string $service_name
 * @property int $customer_id
 * @property string $customer_name
 * @property int $appointment_time
 * @property int $number_customer
 * @property int $employee_id Nhân viên yêu cầu
 * @property string $phone Số điện thoại đặt hẹn
 * @property string $note Ghi chú
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Appointment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appointment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'customer_id', 'appointment_time', 'number_customer', 'employee_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['service_name', 'customer_name', 'phone'], 'string', 'max' => 255],
            [['note'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'service_id' => Yii::t('common', 'Service ID'),
            'service_name' => Yii::t('common', 'Service Name'),
            'customer_id' => Yii::t('common', 'Customer ID'),
            'customer_name' => Yii::t('common', 'Customer Name'),
            'appointment_time' => Yii::t('common', 'Appointment Time'),
            'number_customer' => Yii::t('common', 'Number Customer'),
            'employee_id' => Yii::t('common', 'Employee ID'),
            'phone' => Yii::t('common', 'Phone'),
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
     * @return \common\models\base\query\AppointmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\AppointmentQuery(get_called_class());
    }
}
