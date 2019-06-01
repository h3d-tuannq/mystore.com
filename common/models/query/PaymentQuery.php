<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\Payment]].
 *
 * @see \common\models\base\Payment
 */
class PaymentQuery extends \common\models\base\query\PaymentQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }
}
