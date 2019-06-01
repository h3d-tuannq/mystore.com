<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "product_unit".
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class ProductUnit extends base\ProductUnit
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
            [['slug', 'description'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'slug' => Yii::t('common', 'Slug'),
            'name' => Yii::t('common', 'Name'),
            'description' => Yii::t('common', 'Description'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\ProductUnitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\ProductUnitQuery(get_called_class());
    }
}