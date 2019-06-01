<?php

namespace console\controllers;

use common\commands\AddToTimelineCommand;
use common\components\report\ReportHelper;
use common\models\CustomerHistory;
use console\actions\reports\ReportEmployeeAction;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class ReportController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'employee' => [
                'class' => ReportEmployeeAction::class,
            ],

        ];
    }

    /**
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionRun()
    {
        $this->runAction('revenue-employee');
        $this->runAction('revenue-day');
        //$this->runAction('revenue-product');
//        $time = time() -1000;
//        $started_date = new \DateTime('2019-01-01');
//        $interval = $started_date->diff(new \DateTime());
//        $interval = $interval->format('%a');
        try {
            $this->runAction('birthday');
        } catch (\Exception $exception){
            Yii::error('Birthday has error', 'Job Run');
        }

        $this->runAction('remind'); // Nhắc nhở cho Khách hàng

        // Nhắc nhở cho Khách hàng tiềm năng, 6 ngày 1 lần
        $this->runAction('remind-ability');

        $this->runAction('quantity'); // Nhắc nhở sản phẩm

        Yii::error('Done', 'Job Run');
    }
    public function actionRevenueMonth($year, $month, $force = false)
    {
        //ReportRevenue::deleteAll(['year'=>$year,'month'=>$month]);

        $day_in_months = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        for ($i = 1; $i <= $day_in_months; $i++) {
            $date = strtotime("$year-$month-$i");
            Console::output('----------------------Report Date: '."$year-$month-$i ------------------------");

//            // Báo cáo doanh thu
            ReportHelper::calRevenueDay(date("Y-m-d", $date),$force);

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

            //            // Báo cáo doanh thu theo nhân viên
            ReportHelper::calRevenuePaymentDay(date("Y-m-d", $date));
        }
        Console::output('Report Revenue ok!');
    }

    /**
     * 1.Báo cáo doanh thu TỔNG HỢP
     */
    public function actionRevenueDay($date = null, $force = false)
    {
        ReportHelper::calRevenueDay($date);
        Console::output("Report Revenue Day $date ");
    }

    /**
     * 2.Báo cáo doanh thu SẢN PHẨM
     */
    public function actionRevenueProduct($date = null, $force = false)
    {
        ReportHelper::calRevenueProductDay($date);
        Console::output("Report Revenue Product $date ");
    }

    /**
     * 3.Báo cáo doanh thu KHÁCH HÀNG
     */
    public function actionRevenueCustomer($date = null, $force = false)
    {
        ReportHelper::calRevenueCustomerDay($date);
        Console::output("Report Revenue Customer $date ");
    }

    /**
     * 4.Báo cáo doanh thu DỊCH VỤ
     */
    public function actionRevenueService($date = null, $force = false)
    {
        ReportHelper::calRevenueServiceDay($date);
        Console::output("Report Revenue Employee $date ");
    }

    /**
     * 5.Báo cáo doanh thu NHÂN VIÊN
     */
    public function actionRevenueEmployee($date = null, $force = false)
    {
        ReportHelper::calRevenueEmployeeDay($date);
        Console::output("Report Revenue Employee $date ");
    }
    /**
     * 6.Báo cáo doanh thu của phương thức thanh toán
     */
    public function actionRevenuePaymentDay($date = null, $force = false)
    {
        ReportHelper::calRevenuePaymentDay($date);
        Console::output("Revenue Payment Day $date ");
    }


    /**
     * Thông báo làm dịch vụ
     */
    public function actionRemind()
    {
        ReportHelper::remind();
    }

    /**
     * Thông báo làm dịch vụ khách hàng tiềm năng
     */
    public function actionRemindAbility()
    {
        ReportHelper::remindAbility();
    }
    /**
     * Thông báo sinh nhật cho khách hàng
     */
    public function actionBirthday()
    {
        ReportHelper::birthday();
    }
    /**
     * Thông báo số lượng dưới UNDER_QUANTITY = 10
     */
    public function actionQuantity()
    {
        ReportHelper::quantity();
    }

    /**
     * Thông báo
     */
    public function actionRemindOld()
    {
        $run = false;
        if (!$run) {
            //$this->createDayMonth();
            //$day = date('d');
            //$month = date('m');
            //$year = date('Y');
            $customerHistories = CustomerHistory::find()->where(['>', 'remain', 0])
                ->andWhere(['not', ['customer_id' => null]])
                ->andWhere(['not', ['object_id' => null]])
                ->andWhere(['object_type' => ['service_combo', 'service']])
                ->all();
            foreach ($customerHistories as $customerHistory) {

                $customerName = $customerHistory->customer->name;

                $serviceName = $customerHistory->service->name;
                if ($customerHistory->service->remain_time && $customerHistory->started_date) {
                    //Lấy khoảng thời gian cần nhắc nhở
                    $started_date = new \DateTime($customerHistory->started_date);
                    $interval = $started_date->diff(new \DateTime());
                    $interval = $interval->format('%a');
                    // Nếu đúng số ngày nhắc nhở thì nhắn tin
                    Console::output($customerHistory->started_date . ' : ' . $interval . '-' . $customerHistory->service->remain_time);
                    if ($interval >= $customerHistory->service->remain_time && $interval <= $customerHistory->service->remain_time + 2) {
                        Yii::$app->commandBus->handle(new AddToTimelineCommand([
                            'category' => 'customer_service',
                            'event' => 'remind',
                            'data' => [
                                'content' => "KH $customerName đến ngày làm dịch vụ $serviceName, số buổi còn lại $customerHistory->remain",
                                'remain' => $customerHistory->remain,
                                'customer_id' => $customerHistory->customer_id,
                                'customer_phone' => $customerHistory->customer->phone,
                            ]
                        ]));
                        Console::output($customerName);
                    }
                }
            }
            Console::output('All ok!');
        } else {
            Console::output('Da chay roi!');
        }
    }


}
