<?php

namespace common\models\base\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\EmployeePlan]].
 *
 * @see \common\models\base\EmployeePlan
 */
class EmployeePlanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\base\EmployeePlan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\EmployeePlan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
