<?php

namespace common\models\base\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\Payment]].
 *
 * @see \common\models\base\Payment
 */
class PaymentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\base\Payment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\Payment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
