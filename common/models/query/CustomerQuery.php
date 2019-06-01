<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\Customer]].
 *
 * @see \common\models\base\Customer
 */
class CustomerQuery extends \common\models\base\query\CustomerQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

}
