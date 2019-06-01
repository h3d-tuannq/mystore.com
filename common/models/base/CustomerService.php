<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "customer_service".
 *
 * @property int $id
 * @property int $service_id
 * @property int $customer_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class CustomerService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'customer_id', 'status', 'created_at', 'updated_at'], 'integer'],
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
            'customer_id' => Yii::t('common', 'Customer ID'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return CustomerServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerServiceQuery(get_called_class());
    }
}
