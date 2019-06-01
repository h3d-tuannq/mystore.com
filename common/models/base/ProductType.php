<?php

namespace common\models\base;

use Yii;

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
class ProductType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'name'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'group'], 'string', 'max' => 255],
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
            'group' => Yii::t('common', 'Group'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\ProductTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\base\query\ProductTypeQuery(get_called_class());
    }
}
