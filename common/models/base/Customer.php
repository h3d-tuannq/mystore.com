<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $slug
 * @property string $name Tên khách hàng
 * @property string $birth_of_date
 * @property string $phone
 * @property string $identify
 * @property string $address
 * @property string $email
 * @property int $source Nguồn khách
 * @property int $gender Giới tính, 1 là nam, 2 là nữ
 * @property string $group Nhóm khách
 * @property int $is_notification_birthday Bật tắt thống báo ngày sinh
 * @property int $is_notification_service Bật tắt thống báo ngày sinh
 * @property int $status
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property double $remain_money Số tiền còn nợ
 * @property int $day
 * @property int $month
 * @property int $year
 * @property int $account_money
 * @property int $customer_type_id Kiểu khách hàng
 * @property string $customer_type_code Mã Kiểu khách hàng
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'name'], 'required'],
            [['source', 'gender', 'is_notification_birthday', 'is_notification_service', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'day', 'month', 'year', 'account_money', 'customer_type_id'], 'integer'],
            [['remain_money'], 'number'],
            [['slug', 'birth_of_date', 'phone', 'identify', 'email', 'group', 'customer_type_code'], 'string', 'max' => 255],
            [['name', 'address'], 'string', 'max' => 512],
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
            'birth_of_date' => Yii::t('common', 'Birth Of Date'),
            'phone' => Yii::t('common', 'Phone'),
            'identify' => Yii::t('common', 'Identify'),
            'address' => Yii::t('common', 'Address'),
            'email' => Yii::t('common', 'Email'),
            'source' => Yii::t('common', 'Source'),
            'gender' => Yii::t('common', 'Gender'),
            'group' => Yii::t('common', 'Group'),
            'is_notification_birthday' => Yii::t('common', 'Is Notification Birthday'),
            'is_notification_service' => Yii::t('common', 'Is Notification Service'),
            'status' => Yii::t('common', 'Status'),
            'thumbnail_base_url' => Yii::t('common', 'Thumbnail Base Url'),
            'thumbnail_path' => Yii::t('common', 'Thumbnail Path'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'remain_money' => Yii::t('common', 'Remain Money'),
            'day' => Yii::t('common', 'Day'),
            'month' => Yii::t('common', 'Month'),
            'year' => Yii::t('common', 'Year'),
            'account_money' => Yii::t('common', 'Account Money'),
            'customer_type_id' => Yii::t('common', 'Customer Type ID'),
            'customer_type_code' => Yii::t('common', 'Customer Type Code'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\CustomerQuery(get_called_class());
    }
}
