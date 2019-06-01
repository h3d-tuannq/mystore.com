<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "report_payment".
 *
 * @property int $id
 * @property int $payment_id
 * @property string $payment_name
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
class ReportPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_id', 'year', 'quarter', 'month', 'week', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['report_date'], 'required'],
            [['report_date'], 'safe'],
            [['revenue'], 'number'],
            [['payment_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'payment_id' => Yii::t('common', 'Payment ID'),
            'payment_name' => Yii::t('common', 'Phương thức'),
            'year' => Yii::t('common', 'Year'),
            'quarter' => Yii::t('common', 'Quarter'),
            'month' => Yii::t('common', 'Month'),
            'week' => Yii::t('common', 'Week'),
            'report_date' => Yii::t('common', 'Ngày'),
            'revenue' => Yii::t('common', 'Tổng tiền'),
            'status' => Yii::t('common', 'Status'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ReportPaymentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReportPaymentQuery(get_called_class());
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
