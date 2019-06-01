<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "report_run".
 *
 * @property int $id
 * @property string $run_date
 * @property int $run_day
 * @property int $run_month
 * @property int $run_year
 * @property int $birthday
 * @property int $revenue
 * @property int $discount Chiết khấu
 * @property int $salary Lương
 * @property int $remain Công nợ
 * @property int $overtime thời gian làm ngoài giờ
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class ReportRun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_run';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['run_date'], 'safe'],
            [['run_day', 'run_month', 'run_year', 'birthday', 'revenue', 'discount', 'salary', 'remain', 'overtime', 'status', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'run_date' => Yii::t('common', 'Run Date'),
            'run_day' => Yii::t('common', 'Run Day'),
            'run_month' => Yii::t('common', 'Run Month'),
            'run_year' => Yii::t('common', 'Run Year'),
            'birthday' => Yii::t('common', 'Birthday'),
            'revenue' => Yii::t('common', 'Revenue'),
            'discount' => Yii::t('common', 'Discount'),
            'salary' => Yii::t('common', 'Salary'),
            'remain' => Yii::t('common', 'Remain'),
            'overtime' => Yii::t('common', 'Overtime'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\ReportRunQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\ReportRunQuery(get_called_class());
    }
}
