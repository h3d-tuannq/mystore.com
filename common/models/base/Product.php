<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property int $product_type_id
 * @property string $product_type
 * @property int $product_unit_id
 * @property string $product_unit
 * @property string $specification Quy cách
 * @property string $made_in Xuất xứ
 * @property int $input_price Giá đầu vào
 * @property int $retail_price Giá bán ra
 * @property string $rate_employee Phần trăm chiết khấu của nhân viên
 * @property int $status
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $product_date Hạn của sản phẩm
 * @property int $product_time_use Thời gian dự tính sử dụng sản phẩm
 * @property int $is_notification Bật tắt thống báo sản phẩm hết hoặc gần hết
 * @property int $quantity
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'name'], 'required'],
            [['description'], 'string'],
            [['product_type_id', 'product_unit_id', 'input_price', 'retail_price', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'product_date', 'product_time_use', 'is_notification'], 'integer'],
            [['rate_employee','quantity'], 'number'],
            [['slug', 'name'], 'string', 'max' => 512],
            [['product_type', 'product_unit', 'specification', 'made_in'], 'string', 'max' => 255],
            [['thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'slug' => Yii::t('common', 'Slug'),
            'name' => Yii::t('common', 'Name'),
            'description' => Yii::t('common', 'Description'),
            'product_type_id' => Yii::t('common', 'Product Type ID'),
            'product_type' => Yii::t('common', 'Product Type'),
            'product_unit_id' => Yii::t('common', 'Product Unit ID'),
            'product_unit' => Yii::t('common', 'Product Unit'),
            'specification' => Yii::t('common', 'Specification'),
            'made_in' => Yii::t('common', 'Made In'),
            'input_price' => Yii::t('common', 'Input Price'),
            'retail_price' => Yii::t('common', 'Retail Price'),
            'rate_employee' => Yii::t('common', 'Rate Employee'),
            'status' => Yii::t('common', 'Status'),
            'thumbnail_base_url' => Yii::t('common', 'Thumbnail Base Url'),
            'thumbnail_path' => Yii::t('common', 'Thumbnail Path'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'product_date' => Yii::t('common', 'Product Date'),
            'product_time_use' => Yii::t('common', 'Product Time Use'),
            'is_notification' => Yii::t('common', 'Is Notification'),
            'quantity' => Yii::t('common', 'Quantity'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\ProductQuery(get_called_class());
    }

	public function afterSave( $insert, $changeAttributes ) {
		foreach ( $changeAttributes as $key => $changeAttribute ) {
			if ( in_array( $key, [
					'product_type_id',
				] ) && $changeAttribute != $this[ $key ] ) {
				$params[ $key ] = $this[ $key ];
				$productType = \common\models\ProductType::findOne($this[ $key ]);
				if($productType){
					$this->product_type = $productType->name;
					$this->save();
				}
			}
		}
	}
}
