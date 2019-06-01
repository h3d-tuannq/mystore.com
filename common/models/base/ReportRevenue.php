<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "report_revenue".
 *
 * @property int $id
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
class ReportRevenue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_revenue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'quarter', 'month', 'week', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['report_date'], 'required'],
            [['report_date'], 'safe'],
            [['revenue'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'year' => Yii::t('common', 'Year'),
            'quarter' => Yii::t('common', 'Quarter'),
            'month' => Yii::t('common', 'Month'),
            'week' => Yii::t('common', 'Week'),
            'report_date' => Yii::t('common', 'Ngày'),
            'revenue' => Yii::t('common', 'Doanh thu'),
            'status' => Yii::t('common', 'Status'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'revenue_order' => Yii::t('common', 'Số hóa đơn'),
            'loan' => Yii::t('common', 'Nợ'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\ReportRevenueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\ReportRevenueQuery(get_called_class());
    }

    public static function getTotal($provider, $fieldName)
    {
        $total = 0;

        foreach ($provider as $item) {
            $total += $item[$fieldName];
        }

        return $total;
    }
}
