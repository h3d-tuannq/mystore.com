<?php

namespace common\models\base\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\Employee]].
 *
 * @see \common\models\base\Employee
 */
class EmployeeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\base\Employee[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\Employee|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
