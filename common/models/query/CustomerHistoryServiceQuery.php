<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\CustomerHistoryService]].
 *
 * @see \common\models\base\CustomerHistoryService
 */
class CustomerHistoryServiceQuery extends \common\models\base\query\CustomerHistoryQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

}
