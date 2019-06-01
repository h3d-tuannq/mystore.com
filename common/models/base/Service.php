<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "service".
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property int $service_type_id
 * @property int $status
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $discount_of_employee Phần trăm chiết khấu của nhân viên
 * @property int $number_product
 * @property int $number_serve Số lần phục vụ của dịch vụ
 * @property int $number_day Thời hạn của dịch vụ
 * @property string $on_time Thời hạn của dịch vụ
 * @property int $remain_time Thời gian nhắc lại dịch vụ tính bằng giờ
 * @property int $warranty Thời gian bảo hành tính bằng giờ
 * @property int $total_price Giá đầu vào
 * @property int $retail_price Giá bán ra
 * @property double $discount_money
 * @property int $duration Thời gian diễn ra
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['service_type_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'discount_of_employee', 'number_product', 'number_serve', 'number_day', 'remain_time', 'warranty', 'total_price', 'retail_price', 'duration'], 'integer'],
            [['on_time'], 'safe'],
            [['discount_money'], 'number'],
            [['slug', 'thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
            [['name'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name',
            'description' => 'Description',
            'service_type_id' => 'Service Type ID',
            'status' => 'Status',
            'thumbnail_base_url' => 'Thumbnail Base Url',
            'thumbnail_path' => 'Thumbnail Path',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'discount_of_employee' => 'Discount Of Employee',
            'number_product' => 'Number Product',
            'number_serve' => 'Number Serve',
            'number_day' => 'Number Day',
            'on_time' => 'On Time',
            'remain_time' => 'Remain Time',
            'warranty' => 'Warranty',
            'total_price' => 'Total Price',
            'retail_price' => 'Retail Price',
            'discount_money' => 'Discount Money',
            'duration' => 'Duration',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\ServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\ServiceQuery(get_called_class());
    }
}
