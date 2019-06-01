<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\ServiceType]].
 *
 * @see \common\models\base\ServiceType
 */
class ServiceTypeQuery extends \common\models\base\query\ServiceTypeQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

}

