<?php

namespace common\models\base\query;

/**
 * This is the ActiveQuery class for [[\common\models\base\ReportProduct]].
 *
 * @see \common\models\base\ReportProduct
 */
class ReportProductQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\base\ReportProduct[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\ReportProduct|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
