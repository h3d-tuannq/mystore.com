<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[Appointment]].
 *
 * @see Appointment
 */
class AppointmentQuery extends \common\models\base\query\AppointmentQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

}
