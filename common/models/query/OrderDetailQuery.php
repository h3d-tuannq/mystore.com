<?php
namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\OrderDetail]].
 *
 * @see \common\models\base\OrderDetail
 */
class OrderDetailQuery extends \common\models\base\query\OrderDetailQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }
}
