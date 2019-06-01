<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "order_detail".
 *
 * @property int $id
 * @property int $order_id
 * @property int $object_id
 * @property string $object_type
 * @property int $quantity
 * @property int $unit_money
 * @property int $total_money
 * @property int $employee_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'object_id', 'quantity', 'unit_money', 'total_money', 'employee_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['object_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'order_id' => Yii::t('common', 'Order ID'),
            'object_id' => Yii::t('common', 'Object ID'),
            'object_type' => Yii::t('common', 'Object Type'),
            'quantity' => Yii::t('common', 'Quantity'),
            'unit_money' => Yii::t('common', 'Unit Money'),
            'total_money' => Yii::t('common', 'Total Money'),
            'employee_id' => Yii::t('common', 'Employee ID'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\OrderDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\OrderDetailQuery(get_called_class());
    }


}
