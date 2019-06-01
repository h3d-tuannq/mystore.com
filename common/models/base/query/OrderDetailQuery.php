<?php

namespace common\models\base\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\OrderDetail]].
 *
 * @see \common\models\base\OrderDetail
 */
class OrderDetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\base\OrderDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\OrderDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
