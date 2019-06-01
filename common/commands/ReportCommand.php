<?php

namespace common\commands;

use common\components\report\ReportHelper;
use trntv\bus\interfaces\SelfHandlingCommand;
use yii\base\BaseObject;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ReportCommand extends BaseObject implements SelfHandlingCommand
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
     * @param AddToTimelineCommand $command
     * @return bool
     */
    public function handle($command)
    {
        if ($this->year) {
            if ($this->month) {
                if ($this->day) {
                    //var_dump("$this->year-$this->month-$this->day");die;
                    $date = strtotime("$this->year-$this->month-$this->day");
                    $this->runInDay($date, true);
                } else {
                    // All day in month
                    $day_in_months = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);

                    for ($i = 1; $i <= $day_in_months; $i++) {
                        $date = strtotime("$this->year-$this->month-$i");
                        $this->runInDay($date, true);
                    }
                }
            } else {

            }
        }
    }

    private function runInDay($date, $force = false)
    {
        //            // Báo cáo doanh thu
        ReportHelper::calRevenueDay(date("Y-m-d", $date), $force);

        // Báo cáo doanh thu theo sản phẩm
        ReportHelper::calRevenueProductDay(date("Y-m-d", $date));

        // Báo cáo doanh thu theo khách hàng
        ReportHelper::calRevenueCustomerDay(date("Y-m-d", $date));
//
//
//            // Báo cáo doanh thu theo service
        ReportHelper::calRevenueServiceDay(date("Y-m-d", $date));
//
//            // Báo cáo doanh thu theo nhân viên
        ReportHelper::calRevenueEmployeeDay(date("Y-m-d", $date));

        //   Báo cáo doanh thu theo phương thức thanh toán
        ReportHelper::calRevenuePaymentDay(date("Y-m-d", $date));
    }

}
