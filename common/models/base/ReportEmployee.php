<?php

namespace common\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "report_employee".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $employee_name
 * @property string $employee_code
 * @property int $year
 * @property int $quarter
 * @property int $month
 * @property int $week
 * @property string $report_date
 * @property double $revenue
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class ReportEmployee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_employee';
    }
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
            [['employee_id', 'year', 'quarter', 'month', 'week', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['report_date'], 'required'],
            [['report_date'], 'safe'],
            [['revenue'], 'number'],
            [['employee_name', 'employee_code'], 'string', 'max' => 255],
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
            'employee_name' => 'Tên nhân viên',
            'employee_code' => 'Mã nhân viên',
            'year' => 'Year',
            'quarter' => 'Quarter',
            'month' => 'Month',
            'week' => 'Week',
            'report_date' => 'Ngày',
            'revenue' => 'Doanh thu',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Cập nhật',
            'revenue_order' => 'Doanh thu hóa đơn',
            'revenue_order_quantity' => 'Số lượng hóa đơn',
            'revenue_activity' => 'Doanh thu làm dịch vụ',
            'revenue_activity_quantity' => 'Số lượng làm dịch vụ',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\ReportEmployeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\ReportEmployeeQuery(get_called_class());
    }
}
