<?php

namespace common\models\base\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\CustomerType]].
 *
 * @see \common\models\base\CustomerType
 */
class CustomerTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\base\CustomerType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\CustomerType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
