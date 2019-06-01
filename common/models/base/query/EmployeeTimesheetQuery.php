<?php

namespace common\models\base\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\EmployeeTimesheet]].
 *
 * @see \common\models\base\EmployeeTimesheet
 */
class EmployeeTimesheetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\base\EmployeeTimesheet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\EmployeeTimesheet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
