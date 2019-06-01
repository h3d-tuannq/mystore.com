<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "card_service".
 *
 * @property int $id
 * @property int $card_id
 * @property int $service_id
 * @property int $amount Số lượng
 * @property int $money Tiền theo số lượng
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class CardService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'card_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_id', 'service_id', 'amount', 'money', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'card_id' => Yii::t('common', 'Card ID'),
            'service_id' => Yii::t('common', 'Service ID'),
            'amount' => Yii::t('common', 'Amount'),
            'money' => Yii::t('common', 'Money'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\CardServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\CardServiceQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(\common\models\Service::class, ['id' => 'service_id']);
    }
}
