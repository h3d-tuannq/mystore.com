<?php

namespace common\models\base;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "report_service".
 *
 * @property int $id
 * @property int $service_id
 * @property string $service_name
 * @property string $service_code
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
class ReportService extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'year', 'quarter', 'month', 'week', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['report_date'], 'required'],
            [['report_date','employee','use','sell'.'employee_service'], 'safe'],
            [['revenue'], 'number'],
            [['service_name', 'service_code'], 'string', 'max' => 255],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_id' => 'Service ID',
            'service_name' => 'Service Name',
            'service_code' => 'Service Code',
            'year' => 'Năm',
            'quarter' => 'Quarter',
            'month' => 'Tháng',
            'week' => 'Week',
            'report_date' => 'Ngày',
            'revenue' => 'Doanh thu theo hóa đơn',
            'spend' => 'Chi', // Tiền chi
            'proceed' => 'Thu', // Tiền thu
            'interest' => 'Lãi',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'use' => 'Sử dụng',
            'sell' => 'Bán',
            'quantity' => 'Tổng',
            'employee_service' => 'Nhân viên',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\ReportServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\ReportServiceQuery(get_called_class());
    }
}
