<?php

namespace common\models\base;

use Yii;

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
class EmployeeTimesheet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_timesheet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'overtime', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['timesheet_date', 'start_time', 'end_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'timesheet_date' => 'Timesheet Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'overtime' => 'Overtime',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\EmployeeTimesheetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\EmployeeTimesheetQuery(get_called_class());
    }
}
