<?php

namespace common\models\base\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\Activity]].
 *
 * @see \common\models\base\Activity
 */
class ActivityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\base\Activity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\Activity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
