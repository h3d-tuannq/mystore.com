<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\Category]].
 *
 * @see \common\models\base\Category
 */
class CategoryQuery extends \common\models\base\query\CategoryQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

}
