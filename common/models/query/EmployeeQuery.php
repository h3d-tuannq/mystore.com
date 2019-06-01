<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\Employee]].
 *
 * @see \common\models\base\Employee
 */
class EmployeeQuery extends \common\models\base\query\EmployeeQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }
}
