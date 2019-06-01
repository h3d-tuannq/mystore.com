<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\Card]].
 *
 * @see \common\models\base\Card
 */
class CardQuery extends \common\models\base\query\CardQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

}
