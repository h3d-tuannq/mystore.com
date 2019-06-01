<?php

namespace common\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "report_customer".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $customer_name
 * @property string $customer_code
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
class ReportCustomer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'year', 'quarter', 'month', 'week', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['report_date'], 'required'],
            [['report_date'], 'safe'],
            [['revenue'], 'number'],
            [['customer_name', 'customer_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'ID',
            'customer_code' => 'Mã khách',
            'customer_name' => 'Tên khách',
            'year' => 'Năm',
            'quarter' => 'Quý',
            'month' => 'Tháng',
            'week' => 'Tuần',
            'report_date' => 'Ngày',
            'revenue' => 'Doanh thu',
            'status' => 'Trạng thái',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Cập nhật',
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
     * @return \common\models\base\query\ReportCustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\ReportCustomerQuery(get_called_class());
    }
}
