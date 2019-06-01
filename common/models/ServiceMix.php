<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "service_mix".
 *
 * @property int $id
 * @property int $service_mix_id
 * @property int $service_id
 * @property int $amount Số lượng
 * @property int $money Tiền theo số lượng
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class ServiceMix extends base\ServiceMix
{
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
     * @return \common\models\base\query\ServiceMixQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ServiceMixQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }
}
