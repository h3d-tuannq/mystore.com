<?php

namespace common\models;

use common\models\base\CardService;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "card".
 *
 * @property int $id
 * @property int $card_type Kiểu thẻ
 * @property string $name Tên thẻ
 * @property int $amount Mệnh giá thẻ
 * @property string $rate_employee Phần trăm Chiết khấu cho nhân viên
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property double $discount_money
 * @property int $bonus_price
 * @property int $raw_price
 * @property int $retail_price
 */
class Card extends base\Card
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'immutable' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'card_type' => Yii::t('common', 'Loại thẻ'),
            'name' => Yii::t('common', 'Tên thẻ'),
            'amount' => Yii::t('common', 'Mệnh giá thẻ'),
            'rate_employee' => Yii::t('common', 'Chiêt khấu % cho nhân viên'),
            'discount_money' => Yii::t('common', 'Hoặc chiêt khấu bằng tiền cho nhân viên'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'bonus_price' => Yii::t('common', 'Tiền thưởng thêm cho khách'),
            'raw_price' => Yii::t('common', 'Giá gốc'),
            'retail_price' => Yii::t('common', 'Giá bán lẻ'),
            'description' => Yii::t('common', 'Mô tả'),
            'slug' => Yii::t('common', 'Mã thẻ'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CardQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CardQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardType()
    {
        return $this->hasOne(CardType::class, ['id' => 'card_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(CardService::class, ['card_id' => 'id']);
    }
}
