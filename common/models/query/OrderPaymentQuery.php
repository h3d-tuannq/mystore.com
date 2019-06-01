<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\OrderPayment]].
 *
 * @see \common\models\base\OrderPayment
 */
class OrderPaymentQuery extends \common\models\base\query\OrderPaymentQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }
}
