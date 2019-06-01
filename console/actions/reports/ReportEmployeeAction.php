<?php

namespace console\actions\reports;

use common\models\base\Activity;
use common\models\base\ReportEmployee;
use common\models\base\ReportRun;
use common\models\Employee;
use common\models\Order;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;

class ReportEmployeeAction extends Action
{

    public $date;
    /**
     * @param $locale
     * @return mixed|static
     */
    public function run($date = null, $force = false)
    {
        if(!$date){
            $date = $this->date;
        }
        // Lấy thời gian
        if ($date) {
            $time = strtotime($date);
        } else {
            $time = strtotime("yesterday", time());
            $date = date('Y-m-d', $time);
        }

        //Kiểm tra xem đã chạy chưa
        $run = ReportRun::findOne(['run_date' => $date]);

        $beginOfDay = strtotime("midnight", $time);
        $endOfDay = strtotime("tomorrow", $beginOfDay) - 1;
        $employees = [];

        // 1.Doanh thu trong hóa đơn
        $orders = Order::find()->where(['between', 'order_date', $beginOfDay, $endOfDay])->all();
        foreach ($orders as $order) {
            $this->createEmployee($employees,
                $order->rate_employee_id,
                $order->rate_employee);

            $this->createEmployee($employees,
                $order->rate_receptionist_id,
                $order->rate_receptionist);
        }

        // 2.Doanh thu trong làm dịch vụ
        $activities = Activity::findAll(['between', 'start_time', $beginOfDay, $endOfDay]);
        foreach ($activities as $activity) {
            $this->createEmployee($employees,
                $activity->employee_id,
                $activity->discount,'activity');

            $this->createEmployee($employees,
                $activity->reception_id,
                $activity->rate_reception,'activity');
        }

        $all_employees = ArrayHelper::map(Employee::find()->all(),'slug','name','id');

        // Tạo report
        foreach ($employees as $employee_id => $data) {
            $report = ReportEmployee::findOne(['employee_id' => $employee_id, 'report_date' => $date]);
            if (!$report) {
                $report = new ReportEmployee();
            }

            $report->year = date('Y', $time);
            $report->month = date('m', $time);
            $report->quarter = ceil($report->month / 3);
            $report->week = date("W", $time);
            $report->employee_id = $employee_id;
            if(isset($all_employees[$employee_id])){
                $cus = $all_employees[$employee_id];
                foreach ($cus as $k=>$v){
                    $report->employee_code = $k;
                    $report->employee_name = $v;
                }
            }
            // Hiển thị được danh sách các sản phẩm


            $report->revenue = 0;
            $report->report_date = $date;
            $report->save();

        }

        Console::output("Done Report Revenue Employee! : $date");
    }


    private function createEmployee(&$employees, $employee_id, $rate, $type = 'order'): void
    {
        if (isset($employees[$employee_id])) {
            if($type == 'order'){
                $employees[$employee_id]['money_order'] += $rate;
                $employees[$employee_id]['quantity_order'] += 1;
            }else{
                $employees[$employee_id]['money_activity'] += $rate;
                $employees[$employee_id]['quantity_activity'] += 1;
            }
        } else {
            // Chưa có
            $employees[$employee_id] = array(
                'money_order' => $type == 'order' ? $rate : 0,
                'money_activity' => $type == 'activity' ? $rate : 0,
                'quantity_order' => $type == 'order' ? 1 : 0,
                'quantity_activity' => $type == 'activity' ? 1 : 0,
            );
        }
    }
}
