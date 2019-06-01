<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $slug
 * @property string $name Tên nhân viên
 * @property int $birth_of_date
 * @property string $phone
 * @property string $identify
 * @property int $salary Lương cơ bản
 * @property string $rate_revenue Phần trăm chiết khấu doanh thu
 * @property string $rate_overtime Phần trăm chiết khấu ngoài giờ
 * @property int $status
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'name'], 'required'],
            [['birth_of_date', 'salary', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['rate_revenue', 'rate_overtime'], 'number'],
            [['slug', 'phone', 'identify'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 512],
            [['thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
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
            'employee_type_id' => 'Kiểu nhân viên',
            'birth_of_date' => 'Birth Of Date',
            'phone' => 'Phone',
            'identify' => 'Identify',
            'salary' => 'Salary',
            'rate_revenue' => 'Rate Revenue',
            'rate_overtime' => 'Rate Overtime',
            'status' => 'Status',
            'thumbnail_base_url' => 'Thumbnail Base Url',
            'thumbnail_path' => 'Thumbnail Path',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\EmployeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\EmployeeQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeType()
    {
        return $this->hasOne(EmployeeType::class, ['id' => 'employee_type_id']);
    }

    /**
     */
    public static function getReceptions()
    {
        // 4 là lễ tân
        return self::findAll(['employee_type_id'=>4]);
    }

    /**
     */
    public static function getEmployees()
    {
        // 1 là nhân viên
        return self::findAll(['employee_type_id'=>1]);
    }
}
