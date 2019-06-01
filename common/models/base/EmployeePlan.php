<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "employee_plan".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $plan_date
 * @property string $start_time
 * @property string $end_time
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class EmployeePlan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['plan_date', 'start_time', 'end_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'employee_id' => Yii::t('common', 'Employee ID'),
            'plan_date' => Yii::t('common', 'Plan Date'),
            'start_time' => Yii::t('common', 'Start Time'),
            'end_time' => Yii::t('common', 'End Time'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
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
