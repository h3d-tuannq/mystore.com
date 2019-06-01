<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\ProductType]].
 *
 * @see \common\models\base\ProductType
 */
class ProductTypeQuery extends \common\models\base\query\ProductTypeQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }
}
