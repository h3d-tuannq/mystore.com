<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\Product]].
 *
 * @see \common\models\base\Product
 */
class ProductQuery extends \common\models\base\query\ProductQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

}
