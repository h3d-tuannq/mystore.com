<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "Service".
 *
 */
class Service extends base\Service
{
    public $thumbnail;

    public function afterSave($insert, $changedAttributes)
    {
        if(!$this->slug){
            if($this->service_type_id == 1) {
                $code = 'DV-';
            }else{
                $code = 'CB-';
            }
            $this->slug = $code.$this->id;
            $this->save();
        }

        // Thay đổi trạng thái
        if(isset($changedAttributes['status'])){
            if(Common::STATUS_DELETED == $this->status) {
                ServiceProduct::updateAll(['status'=> Common::STATUS_DELETED],['service_id'=>$this->id]);
            }
        }

    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
//            BlameableBehavior::class,
//            [
//                'class' => SluggableBehavior::class,
//                'attribute' => 'name',
//                'immutable' => true,
//            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'slug' => Yii::t('common', 'Mã dịch vụ'),
            'name' => Yii::t('common', 'Tên dịch vụ'),
            'description' => Yii::t('common', 'Mô tả'),
            'service_type_id' => Yii::t('common', 'Loại dịch vụ'),
            'status' => Yii::t('common', 'Trạng thái'),
            'thumbnail_base_url' => Yii::t('common', 'Thumbnail Base Url'),
            'thumbnail_path' => Yii::t('common', 'Thumbnail Path'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'discount_of_employee' => Yii::t('common', 'Chiêt khấu % cho nhân viên'),
            'discount_money' => Yii::t('common', 'Hoặc chiêt khấu bằng tiền cho nhân viên'),
            'number_product' => Yii::t('common', 'Số lượng sản phâm'),
            'number_serve' => Yii::t('common', 'Số lần phục vụ'),
            'number_day' => Yii::t('common', 'Số ngày'),
            'duration' => Yii::t('common', 'Thời gian diễn ra'),
            'remain_time' => Yii::t('common', 'Thời gian nhắc nhở'),
            'warranty' => Yii::t('common', 'Thời gian bảo hành dịch vụ'),
            'total_price' => Yii::t('common', 'Tổng giá thành'),
            'retail_price' => Yii::t('common', 'Giá bán lẻ'),
            'on_time' => Yii::t('common', 'Trong khoảng thời gian của ngày'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ServiceTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ServiceTypeQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceType()
    {
        return $this->hasOne(ServiceType::class, ['id' => 'service_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(ServiceProduct::class, ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(ServiceMix::class, ['service_mix_id' => 'id']);
    }

    public function calculate()
    {
        $serviceProducts = ServiceProduct::findAll(['service_id'=> $this->id]);
        $total = 0;
        foreach($serviceProducts as $serviceProduct){
            $total += $serviceProduct->money;
        }

        $this->total_price = $total;
        // TODO config tỉ lệ giá dịch vụ
        $service_rate = 2;
        //$this->retail_price = ($total + (int)($total * $this->discount_of_employee / 100)) * $service_rate;
        $this->save();
    }

    public function calculateCombo()
    {
        $serviceCombos = ServiceMix::findAll(['service_mix_id'=> $this->id]);
        $total = 0;
        foreach($serviceCombos as $serviceCombo){
            $total += $serviceCombo->money;
        }

        $this->total_price = $total;
        // TODO config tỉ lệ giá dịch vụ
        $service_rate = 2;
        //$this->retail_price = ($total + (int)($total * $this->discount_of_employee / 100)) * $service_rate;
        $this->save();
    }

    public static function all()
    {
        return Service::find()->all();
    }
}
