<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "product_type".
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $group
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class ProductType extends base\ProductType
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
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
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'group'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 512],
        ];
    }
    /**
     * {@inheritdoc}
     * @return \common\models\base\query\ProductTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProductTypeQuery(get_called_class());
    }
}
