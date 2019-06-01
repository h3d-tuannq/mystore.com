<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\CustomerHistoryCard]].
 *
 * @see \common\models\base\CustomerHistoryCard
 */
class CustomerHistoryCardQuery extends \common\models\base\query\CustomerHistoryCardQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

}
