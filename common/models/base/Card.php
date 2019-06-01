<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "card".
 *
 * @property int $id
 * @property int $card_type Kiểu thẻ
 * @property string $name Tên thẻ
 * @property string $slug
 * @property int $amount Mệnh giá thẻ
 * @property string $rate_employee Phần trăm Chiết khấu cho nhân viên
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property double $discount_money
 * @property int $bonus_price
 * @property int $raw_price
 * @property int $retail_price
 * @property string $description
 */
class Card extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_type', 'amount', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'bonus_price', 'raw_price', 'retail_price'], 'integer'],
            [['slug'], 'required'],
            [['rate_employee', 'discount_money'], 'number'],
            [['name', 'slug'], 'string', 'max' => 512],
            [['description'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'card_type' => Yii::t('common', 'Card Type'),
            'name' => Yii::t('common', 'Name'),
            'slug' => Yii::t('common', 'Slug'),
            'amount' => Yii::t('common', 'Amount'),
            'rate_employee' => Yii::t('common', 'Rate Employee'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'discount_money' => Yii::t('common', 'Discount Money'),
            'bonus_price' => Yii::t('common', 'Bonus Price'),
            'raw_price' => Yii::t('common', 'Raw Price'),
            'retail_price' => Yii::t('common', 'Retail Price'),
            'description' => Yii::t('common', 'Description'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\CardQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\CardQuery(get_called_class());
    }
}
