<?php

namespace backend\models;

use common\commands\ReportCommand;
use yii\base\Model;

/**
 * ExportForm form
 */
class RunReportForm extends Model
{
    /**
     * @var integer
     */
    public $year;

    /**
     * @var integer
     */
    public $month;

    /**
     * @var integer
     */
    public $day;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'month', 'day'],'integer'],
        ];
    }
    public function run()
    {
        \Yii::$app->commandBus->handle(new ReportCommand([
            'year' => $this->year,
            'month' => $this->month,
            'day' => $this->day,
        ]));
        return true;
    }
}
