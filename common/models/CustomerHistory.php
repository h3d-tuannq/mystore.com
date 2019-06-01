<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "customer_history".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $object_id
 * @property string $object_type Sản phẩm, dịch vụ, thẻ nạp
 * @property int $quantity Số lần sử dụng
 * @property string $note Ghi chú
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class CustomerHistory extends base\CustomerHistory
{
    const OBJECT_TYPE_SERVICE_COMBO = 'service_combo';
    const OBJECT_TYPE_CARD = 'card';
    const OBJECT_TYPE_SERVICE = 'service';

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
            [['customer_id', 'object_id', 'quantity', 'status', 'updated_at','created_at', 'created_by', 'updated_by'], 'integer'],
            [['object_type'], 'string', 'max' => 255],
            [['note'], 'string', 'max' => 1000],
            [['started_date'], 'filter', 'filter' => 'date', 'skipOnEmpty' => true],
	        [['services'], 'safe'],
	        [['products'], 'safe'],
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
            'object_id' => Yii::t('common', 'Object ID'),
            'object_type' => Yii::t('common', 'Object Type'),
            'quantity' => Yii::t('common', 'Quantity'),
            'note' => Yii::t('common', 'Note'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'started_date' => Yii::t('common', 'Ngày'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\CustomerHistoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CustomerHistoryQuery(get_called_class());
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
	public function getCard()
	{
		return $this->hasOne(Card::class, ['id' => 'object_id']);
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'object_id']);
    }
}
