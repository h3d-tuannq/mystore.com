<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\CustomerHistory]].
 *
 * @see \common\models\base\CustomerHistory
 */
class CustomerHistoryQuery extends \common\models\base\query\CustomerHistoryQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

}
