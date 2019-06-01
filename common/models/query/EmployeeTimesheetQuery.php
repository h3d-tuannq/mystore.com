<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\EmployeeTimesheetQuery]].
 *
 * @see \common\models\base\EmployeeTimesheet
 */
class EmployeeTimesheetQuery extends \common\models\base\query\EmployeeTimesheetQuery
{
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
}

