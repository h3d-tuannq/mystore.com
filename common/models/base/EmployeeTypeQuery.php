<?php

namespace common\models\base;

/**
 * This is the ActiveQuery class for [[EmployeeType]].
 *
 * @see EmployeeType
 */
class EmployeeTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EmployeeType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EmployeeType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
