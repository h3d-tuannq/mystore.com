<?php

namespace common\models\base;

/**
 * This is the ActiveQuery class for [[CustomerService]].
 *
 * @see CustomerService
 */
class CustomerServiceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CustomerService[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CustomerService|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
