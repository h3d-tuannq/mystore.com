<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\CardType]].
 *
 * @see \common\models\base\CardType
 */
class CardTypeQuery extends \common\models\base\query\CardTypeQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }
}
