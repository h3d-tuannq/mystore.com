<?php

namespace common\models\base\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\ReportEmployee]].
 *
 * @see \common\models\base\ReportEmployee
 */
class ReportEmployeeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\base\ReportEmployee[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\ReportEmployee|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
