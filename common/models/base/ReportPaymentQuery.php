<?php

namespace common\models\base;

/**
 * This is the ActiveQuery class for [[ReportPayment]].
 *
 * @see ReportPayment
 */
class ReportPaymentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ReportPayment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ReportPayment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
