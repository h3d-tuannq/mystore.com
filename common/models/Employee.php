<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "employee".
 *
 * @property int $id
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
 * @property int $employee_type_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Employee extends base\Employee
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

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['slug'], 'unique'],
			[['salary', 'employee_type_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
			[['rate_revenue', 'rate_overtime'], 'number'],
			[['name'], 'string', 'max' => 512],
			[['phone', 'identify'], 'string', 'max' => 255],
			[['thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
			[['birth_of_date'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
		];
	}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Name'),
            'employee_type_id' => 'Kiểu nhân viên',
            'birth_of_date' => Yii::t('common', 'Birth Of Date'),
            'phone' => Yii::t('common', 'Phone'),
            'identify' => Yii::t('common', 'Identify'),
            'salary' => Yii::t('common', 'Salary'),
            'rate_revenue' => Yii::t('common', 'Tỉ lệ hoa hồng'),
            'rate_overtime' => Yii::t('common', 'Tỉ lệ làm thêm'),
            'status' => Yii::t('common', 'Status'),
            'thumbnail_base_url' => Yii::t('common', 'Thumbnail Base Url'),
            'thumbnail_path' => Yii::t('common', 'Thumbnail Path'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'slug' => Yii::t('common', 'Mã'),
            'thumbnail' => Yii::t('common', 'Ảnh đại diện'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\EmployeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\EmployeeQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSlugName()
    {
        return $this->slug . ' - '. $this->name;
    }
}
