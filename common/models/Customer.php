<?php

namespace common\models;

use common\models\base\CustomerType;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $name Tên khách hàng
 * @property int $birth_of_date
 * @property int $source Nguồn khách
 * @property int $is_notification_birthday Bật tắt thống báo ngày sinh
 * @property int $is_notification_service Bật tắt thống báo ngày sinh
 * @property int $status
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Customer extends base\Customer
{
    public $thumbnail;
    public $full;

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

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['slug'], 'unique'],
            [['source', 'is_notification_birthday', 'is_notification_service',
                'status', 'created_at', 'updated_at', 'created_by', 'updated_by','customer_type_id'], 'integer'],
            [['name'], 'string', 'max' => 512],
            [['remain_money', 'account_money'], 'number'],
            [['phone'], 'number'],
            [['full'], 'safe'],
            [['thumbnail_base_url', 'thumbnail_path', 'birth_of_date'], 'string', 'max' => 1024],
            //[['birth_of_date'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'slug' => Yii::t('common', 'Mã khách'),
            'name' => Yii::t('common', 'Tên khách hàng'),
            'birth_of_date' => Yii::t('common', 'Ngày sinh'),
            'phone' => Yii::t('common', 'Điện thoại'),
            'identify' => Yii::t('common', 'CMT/CCCD'),
            'gender' => Yii::t('common', 'Giới tính'),
            'address' => Yii::t('common', 'Địa chỉ'),
            'remain_money' => Yii::t('common', 'Công nợ'),
            'source' => Yii::t('common', 'Nguồn khách'),
            'is_notification_birthday' => Yii::t('common', 'Thông báo'),
            'is_notification_service' => Yii::t('common', 'Thông báo dịch vụ'),
            'status' => Yii::t('common', 'Status'),
            'thumbnail_base_url' => Yii::t('common', 'Thumbnail Base Url'),
            'thumbnail_path' => Yii::t('common', 'Thumbnail Path'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'account_money' => Yii::t('common', 'Số dư'),
            'customer_type_id' => Yii::t('common', 'Kiểu KH'),
            'fullName' => Yii::t('common', 'Khách hàng')
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CustomerQuery(get_called_class());
    }

    public static function all()
    {
        $query = new Query();
        $query->select(['id', 'concat(slug," - ",name) as text'])
            ->from('customer');
            //->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        return $data;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerType()
    {
        return $this->hasOne(CustomerType::class, ['id' => 'customer_type_id']);
    }

    /* Getter for full  */
    public function getFull() {
        return $this->slug . ' - ' . $this->name;
    }

}
