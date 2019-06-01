<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\ServiceMix]].
 *
 * @see \common\models\base\ServiceMix
 */
class ServiceMixQuery extends \common\models\base\query\ServiceMixQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

}
