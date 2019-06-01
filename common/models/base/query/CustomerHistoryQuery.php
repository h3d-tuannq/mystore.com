<?php

namespace common\models\base\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\CustomerHistory]].
 *
 * @see \common\models\base\CustomerHistory
 */
class CustomerHistoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\base\CustomerHistory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\CustomerHistory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
