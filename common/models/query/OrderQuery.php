<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\Order]].
 *
 * @see \common\models\base\Order
 */
class OrderQuery extends \common\models\base\query\OrderQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

}
