<?php

namespace common\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "report_product".
 *
 * @property int $id
 * @property int $product_id
 * @property string $product_name
 * @property string $product_code
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
class ReportProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'year', 'quarter', 'month', 'week', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['report_date'], 'required'],
            [['report_date'], 'safe'],
            [['revenue'], 'number'],
            [['product_name', 'product_code'], 'string', 'max' => 255],
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
            'id' => Yii::t('common', 'ID'),
            'product_id' => Yii::t('common', 'Product ID'),
            'product_name' => Yii::t('common', 'Tên sản phẩm'),
            'product_code' => Yii::t('common', 'Mã sản phẩm'),
            'year' => Yii::t('common', 'Year'),
            'quarter' => Yii::t('common', 'Quarter'),
            'month' => Yii::t('common', 'Month'),
            'week' => Yii::t('common', 'Week'),
            'report_date' => Yii::t('common', 'Ngày'),
            'status' => Yii::t('common', 'Status'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'quantity_use' => Yii::t('common', 'Số lượng tiêu hao'),
            'quantity_sell' => Yii::t('common', 'Số lượng bán'),
            'quantity' => Yii::t('common', 'Tổng SL'),
            'unit' => Yii::t('common', 'Đơn vị'),
            'revenue' => Yii::t('common', 'Doanh thu'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\ReportProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\ReportProductQuery(get_called_class());
    }
}
