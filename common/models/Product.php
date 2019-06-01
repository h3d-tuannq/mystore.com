<?php

namespace common\models;

use common\commands\AddToTimelineCommand;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property int $product_type_id
 * @property int $product_unit_id
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
 */
class Product extends base\Product
{
    public $thumbnail;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'immutable' => true,
            ],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
//        if(isset($changedAttributes['quantity'])){
//            if($this->quantity < 10) {
//                \Yii::$app->commandBus->handle(new AddToTimelineCommand([
//                    'category' => 'product',
//                    'event' => 'out_of_stock',
//                    'data' => [
//                        'content' => $this->name . ' còn ' . $this->quantity . ' ' . $this->product_unit . ' trong kho',
//                        'product_id' => $this->id,
//                        'product_code' => $this->slug,
//                        'product_name' => $this->name,
//                        'quantity' => $this->quantity
//                    ]
//                ]));
//            }
//        }
        if(isset($changedAttributes['product_unit_id'])){
            $productUnit = \common\models\ProductUnit::findOne($this->product_unit_id);
            if($productUnit) {
                $this->product_unit = $productUnit->name;
                $this->save();
            }
        }
        // Thay đổi trạng thái
        if(isset($changedAttributes['status'])){
            if(Common::STATUS_DELETED == $this->status) {
                ServiceProduct::updateAll(['status'=> Common::STATUS_DELETED],['product_id'=>$this->id]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'slug' => Yii::t('common', 'Mã hàng'),
            'name' => Yii::t('common', 'Name'),
            'description' => Yii::t('common', 'Description'),
            'product_type_id' => Yii::t('common', 'Loại sản phẩm'),
            'product_unit_id' => Yii::t('common', 'Đơn vị tính'),
            'product_unit' => Yii::t('common', 'Đơn vị tính'),
            'input_price' => Yii::t('common', 'Giá nhập'),
            'retail_price' => Yii::t('common', 'Giá bán'),
            'rate_employee' => Yii::t('common', 'Chiêt khấu % cho nhân viên'),
            'discount_money' => Yii::t('common', 'Hoặc chiêt khấu bằng tiền cho nhân viên'),
            'status' => Yii::t('common', 'Status'),
            'thumbnail_base_url' => Yii::t('common', 'Thumbnail Base Url'),
            'thumbnail_path' => Yii::t('common', 'Thumbnail Path'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'product_date' => Yii::t('common', 'Hạn sử dụng'),
            'product_time_use' => Yii::t('common', 'Thời gian sử dụng'),
            'is_notification' => Yii::t('common', 'Bật thông báo'),
            'quantity' => Yii::t('common', 'Số lượng'),
            'specification' => Yii::t('common', 'Quy cách'),
            'limit_quantity' => Yii::t('common', 'Ngưỡng thông báo'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['product_type_id', 'product_unit_id', 'input_price', 'retail_price', 'status',
                'created_at', 'updated_at', 'created_by', 'updated_by',
                'product_time_use', 'is_notification'], 'integer'],
            [['rate_employee','quantity','limit_quantity'], 'number'],
            [['slug', 'thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
            [['name'], 'string', 'max' => 512],
            [['product_date'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['product_type', 'product_unit', 'specification', 'made_in'], 'string', 'max' => 255],
        ];
    }
    /**
     * {@inheritdoc}
     * @return \common\models\base\query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProductQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductType::class, ['id' => 'product_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductUnit()
    {
        return $this->hasOne(ProductUnit::class, ['id' => 'product_unit_id']);
    }

}
