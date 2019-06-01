<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "employee_timesheet".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $timesheet_date
 * @property string $start_time
 * @property string $end_time
 * @property int $overtime Số phút làm thêm
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class EmployeePlan extends base\EmployeePlan
{
    const STATUS_ACTIVE = 1;
    const STATUS_OFF = 2;
    const STATUS_OVERTIME = 3;
    public $off;
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
            [['employee_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['plan_date', 'start_time', 'end_time','off'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Nhân viên',
            'plan_date' => 'Ngày',
            'start_time' => 'Thời gian bắt đầu',
            'end_time' => 'Kết thúc',
            'status' => 'Trạng thái',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'off' => 'Nghỉ làm',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\EmployeePlanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\EmployeePlanQuery(get_called_class());
    }
}
