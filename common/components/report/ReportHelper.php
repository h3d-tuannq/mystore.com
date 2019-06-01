<?php

namespace common\components\report;

use common\commands\AddToTimelineCommand;
use common\models\base\Activity;
use common\models\base\CustomerHistoryDetail;
use common\models\base\ReportCustomer;
use common\models\base\ReportEmployee;
use common\models\base\ReportPayment;
use common\models\base\ReportProduct;
use common\models\base\ReportRun;
use common\models\base\ReportService;
use common\models\Customer;
use common\models\CustomerHistory;
use common\models\Employee;
use common\models\Order;
use common\models\OrderDetail;
use common\models\Payment;
use common\models\Product;
use common\models\ReportRevenue;
use common\models\Service;
use console\actions\reports\ReportEmployeeAction;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
/**
 * Báo cáo chung
 */
class ReportHelper
{
    /**
     * 1.1 Tổng hợp dữ liệu cho báo cáo tổng hợp
     */
    public static function calRevenueDay($date, $force = false)
    {
        if ($date) {
            $time = strtotime($date);
            $week = date("W", $time);
            $month = date('m', $time);
            $year = date('Y', $time);
        } else {
            $date = date('Y-m-d');
            $week = date('W');
            $month = date('m');
            $year = date('Y');
        }
        $quarter = ceil($month / 3);

        $report = ReportRevenue::findOne(['report_date' => $date]);
        if ($report) {
            if ($force) {
                // Tổng hợp các hóa đơn trong ngày
                $result = ReportHelper::calculateRevenue($date);
                $report->revenue = $result[0] - $result[2] ;
                $report->revenue_order = $result[1];
                $report->loan = $result[2];
                $report->save();
                //Console::output($report->revenue);
            } else {
                //Console::output('You have reported calRevenueDay!');
            }
        } else {
            // Tổng hợp các hóa đơn trong ngày
            $report = new ReportRevenue();
            $report->report_date = $date;
            $report->month = $month;
            $report->year = $year;
            $report->quarter = $quarter;
            $report->week = $week;
            $result = ReportHelper::calculateRevenue($date);
            $report->revenue = $result[0] - $result[2];
            $report->revenue_order = $result[1];
            $report->loan = $result[2];
            if(!$report->save()){
                //Console::output("@@@@@@@@@@@@@@@@@@@@@@@@@@ $date");
            }
        }
        //Console::output("Done Report Revenue $date");
    }


    /**
     * 2.1 Tổng hợp dữ liệu cho báo cáo sản phẩm
     */
    public static  function calRevenueProductDay($date = null, $force = false)
    {
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
        ////Console::output($beginOfDay);
        ////Console::output(date('Y-m-d H:i:s', $beginOfDay));
        $endOfDay = strtotime("tomorrow", $beginOfDay) - 1;
        ////Console::output($endOfDay);
        ////Console::output(date('Y-m-d H:i:s', $endOfDay));
        $products = [];
        $orders = Order::find()->where(['between', 'order_date', $beginOfDay, $endOfDay])->all();
        //var_dump(count($orders));die;
        foreach ($orders as $order) {
            foreach ($order->orderDetails as $orderDetail) {
                //var_dump($orderDetail->object_type);die;
                // San pham trong hoa don
                if ($orderDetail->object_type == 'product') {
                    ReportHelper::createProduct($products, $orderDetail->object_id, $orderDetail->quantity, $orderDetail->total_money, false);
                }
            }
        }

        //var_dump($products);die;
        // Thống kê các sản phẩm dùng trong làm dịch vụ
        $activities = Activity::find()->where(['between', 'start_time', $beginOfDay, $endOfDay])->all();
        foreach ($activities as $activity) {
            $detail_products = json_decode($activity->detail_products);
            $services = json_decode($activity->detail);
            if(is_array($detail_products)){
                foreach ($detail_products as $detail_product) {
                    // Danh sách service với các sản phẩm
                    foreach ($detail_product->products as $pro) {
                        // Danh sách sản phẩm
                        ReportHelper::createProduct($products, $pro->product_id, $pro->amount, $pro->amount * $pro->unit_price, true);
                    }
                }
            }else{
                //Console::output("Loi record $activity->id");
            }
        }
        //var_dump($products);die;
        // Tạo report
        foreach ($products as $key => $product) {
            $report = ReportProduct::findOne(['product_id' => $key, 'report_date' => $date]);
            if (!$report) {
                $report = new ReportProduct();
            }

            $report->year = date('Y', $time);
            $report->month = date('m', $time);
            $report->quarter = ceil($report->month / 3);
            $report->week = date("W", $time);
            $report->product_id = $key;
            $p = Product::findOne($key);
            if($p){
                $report->product_code = $p->slug;
                $report->product_name = $p->name;
                $report->quantity_remain = $p->quantity;
                $report->unit = $p->product_unit;
            }

            $report->quantity = $product['quantity'];
            $report->quantity_sell = $product['sell'];
            $report->quantity_use = $product['use'];
            $report->revenue = $product['total_money'];
            $report->report_date = $date;
            $report->save();

            //var_dump($report->getErrors());die;
        }

        $result = count($products);
        //Console::output("Done $result Report Revenue Product!");
    }

    /**
     * 3.1 Tổng hợp dữ liệu cho báo cáo khách hàng
     */
    public static  function calRevenueCustomerDay($date = null, $force = false)
    {
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
        ////Console::output($beginOfDay);
        ////Console::output(date('Y-m-d H:i:s', $beginOfDay));
        $endOfDay = strtotime("tomorrow", $beginOfDay) - 1;
        ////Console::output($endOfDay);
        ////Console::output(date('Y-m-d H:i:s', $endOfDay));
        $customers = [];
        $orders = Order::find()->where(['between', 'order_date', $beginOfDay, $endOfDay])->all();

        foreach ($orders as $order) {
            foreach ($order->orderDetails as $orderDetail) {
                // San pham trong hoa don
                if ($orderDetail->object_type == 'product') {
                    ReportHelper::createCustomer($customers, $order->customer_id,$orderDetail->object_id, $orderDetail->quantity, $orderDetail->total_money, 'product');
                }

                if ($orderDetail->object_type == 'service') {
                    ReportHelper::createCustomer($customers, $order->customer_id,$orderDetail->object_id, $orderDetail->quantity, $orderDetail->total_money, 'service');
                }

                if ($orderDetail->object_type == 'card') {
                    ReportHelper::createCustomer($customers, $order->customer_id,$orderDetail->object_id, $orderDetail->quantity, $orderDetail->total_money, 'card');
                }
            }
        }

        //var_dump($products);die;
        // Thống kê các sản phẩm dùng trong làm dịch vụ
//        $activities = Activity::findAll(['between', 'start_time', $beginOfDay, $endOfDay]);
//        foreach ($activities as $activity) {
//            $detail_products = json_decode($activity->detail_products);
//            $services = json_decode($activity->detail);
//            foreach ($detail_products as $detail_product) {
//                // Danh sách service với các sản phẩm
//                foreach ($detail_product->products as $pro) {
//                    // Danh sách sản phẩm
//                    ReportHelper::createProduct($services, $pro->product_id, $pro->amount, $pro->amount * $pro->unit_price, true);
//                }
//            }
//        }
        //var_dump($products);die;
        $all_customers = ArrayHelper::map(Customer::find()->all(),'slug','name','id');
        //var_dump($all_customers);die;
        // Tạo report
        foreach ($customers as $customer_id => $data) {
            $report = ReportCustomer::findOne(['customer_id' => $customer_id, 'report_date' => $date]);
            if (!$report) {
                $report = new ReportCustomer();
            }

            $report->year = date('Y', $time);
            $report->month = date('m', $time);
            $report->quarter = ceil($report->month / 3);
            $report->week = date("W", $time);
            $report->customer_id = $customer_id;
            if(isset($all_customers[$customer_id])){
                $cus = $all_customers[$customer_id];
                foreach ($cus as $k=>$v){
                    $report->customer_code = $k;
                    $report->customer_name = $v;
                }
            }
            // Hiển thị được danh sách các sản phẩm
            $total_product = 0;
            $total_product_money = 0;
            foreach ($data['products'] as $product_id=>$product){
                //$p = Product::findOne($product_id);
                $total_product += $product['quantity'];
                $total_product_money += $product['total_money'];
            }
            //$report->quantity_product = $total_product;
            //$report->total_product_money = $total_product_money;

            // Hiển thị được danh sách các sản phẩm
            $total_service = 0;
            $total_service_money = 0;
            foreach ($data['services'] as $service_id=>$service){
                //$s = Service::findOne($service_id);
                $total_service += $service['quantity'];
                $total_service_money += $service['total_money'];
            }
            //$report->quantity_service = $total_service;
            //$report->$total_service_money = $total_service_money;

            // Hiển thị được danh sách các sản phẩm
            $total_card = 0;
            $total_card_money = 0;
            foreach ($data['cards'] as $card_id=>$card){
                //$c = Card::findOne($card_id);
                $total_card += $card['quantity'];
                $total_card_money += $card['total_money'];
            }
            //$report->quantity_card = $total_card;
            //$report->total_card_money = $total_card_money;

            //$report->quantity = 0;

            $report->revenue = $total_service_money + $total_card_money + $total_product_money;
            $report->report_date = $date;
            $report->save();

        }

        //Console::output("Done Report Revenue Customer!");
    }

    /**
     * 4.1 Tổng hợp dữ liệu cho báo cáo dịch vụ
     */
    public static function calRevenueServiceDay($date = null, $force = false)
    {
        // Lấy thời gian
        if ($date) {
            $time = strtotime($date);
        } else {
            $time = strtotime("yesterday", time());
            $date = date('Y-m-d', $time);
        }

        //Kiểm tra xem đã chạy chưa
        //$run = ReportRun::findOne(['run_date' => $date]);

        $beginOfDay = strtotime("midnight", $time);
        $endOfDay = strtotime("tomorrow", $beginOfDay) - 1;
        $services = [];
        $orders = Order::find()->where(['between', 'order_date', $beginOfDay, $endOfDay])->all();

        foreach ($orders as $order) {
            foreach ($order->orderDetails as $orderDetail) {
                // San pham trong hoa don
                if (OrderDetail::TYPE_SERVICE == $orderDetail->object_type) {
                    ReportHelper::createService($services, $orderDetail->object_id, $orderDetail->quantity, $orderDetail->total_money, false,0);
                }
            }
        }

        //var_dump(Order::find()->where(['between', 'order_date', $beginOfDay, $endOfDay])->createCommand()->getRawSql());die;
        //var_dump($orders);
        // Thống kê các sản phẩm dùng trong làm dịch vụ
        $all_services = ArrayHelper::map(Service::find()->all(),'slug','name','id');
        $employee_services = ArrayHelper::map(Employee::find()->all(),'id','name');

        $activities = Activity::find()->where(['between', 'start_time', $beginOfDay, $endOfDay])->all();
        //var_dump(count($activities));die;
        foreach ($activities as $activity) {

            // Tính doanh thu làm dịch vụ, nếu dịch vụ là combo thì chia giá ra theo số lần
            $service_proceed = 0;
            $comboService = Service::findOne($activity->service_id);
            if (Activity::OBJECT_TYPE_COMBO == $activity->object_type) {
                if($comboService && $comboService->number_serve){
                    $service_proceed = $comboService->retail_price / $comboService->number_serve;
                }else{

                }

            }else{
                // Dịch vụ lẻ, chỉ 1 dịch vụ, 2 dịch vụ thì tạo 2 cái
                $service_proceed = $comboService->retail_price * 0.5;
            }
            $details = json_decode($activity->detail);

            if(is_object($details)) {

                foreach ($details as $key => $number) {
                    // Danh sách service
                    //TODO
                    ReportHelper::createService($services, $key, $number->amount, 0, true,$service_proceed);

                    if (isset($services[$key])) {
                        if (!in_array($activity->employee_id, $services[$key]['employee'])) {
                            $services[$key]['employee'][] = $activity->employee_id;
                        }
                    }
                }
            }

        }
        //var_dump($services);
        // Tạo report
        foreach ($services as $service_id => $data) {
            $report = ReportService::findOne(['service_id' => $service_id, 'report_date' => $date]);
            if (!$report) {
                $report = new ReportService();
            }

            $report->year = date('Y', $time);
            $report->month = date('m', $time);
            $report->quarter = ceil($report->month / 3);
            $report->week = date("W", $time);
            $report->service_id = $service_id;
            if(isset($all_services[$service_id])){
                $ser = $all_services[$service_id];
                foreach ($ser as $k=>$v){
                    $report->service_code = $k;
                    $report->service_name = $v;
                }
            }


            $report->quantity = $data['quantity'];
            $report->sell = $data['sell'];
            $report->use = $data['use'];
            //var_dump($data['service_proceed']);
            $report->spend = $data['use'] * $data['service_price_unit'];
            $report->proceed = $data['use'] * $data['service_proceed'];
//            if( $data['service_proceed'] == 0){
//                var_dump($service_id);die;
//            }
            $report->interest = $report->proceed - $report->spend;

            $report->revenue = $data['total_money'];
            $report->report_date = $date;

            $name = [];

            if(is_array($data['employee'])){
                foreach ($data['employee'] as $employee_id){
                    if(isset($employee_services[$employee_id])){
                        $name[] = $employee_services[$employee_id];
                    }else{
                        //var_dump($employee_id);
                    }

                }
            }
            $report->employee = json_encode($data['employee']);
            $report->employee_service = implode(', ',$name);
            if(!$report->save()){
                //Console::output(json_encode($report->getErrors()));
            }

        }

        //Console::output("Done Report Revenue Service!");
    }

    /**
     * 5.1 Tổng hợp dữ liệu cho báo cáo nhân viên
     */
    public static function calRevenueEmployeeDay($date = null, $force = false)
    {
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
        $orders = Order::find()->where(['between', 'order_date', $beginOfDay, $endOfDay])
            ->all();
        Yii::error(Order::find()->where(['between', 'order_date', $beginOfDay, $endOfDay])->createCommand()->getRawSql());
        foreach ($orders as $order) {
            $paymentUser = 0;
            if($order->orderPayment){
                foreach ($order->orderPayment as $pay){
                    // Nợ không được tính
                    if($pay->payment_id == 6){
                        continue;
                    }
                    $paymentUser += $pay->total_money;
                }
            }


            if($order->type == 1 && $order->rate_employee_id && $order->rate_employee){
                // TODO xem xét lấy hoa hồng của giá trị hóa đơn hay giá trị ban đầu
                //$revenue = (int)($order->total_money * $order->rate_employee)/100;
                $revenue = (int)($paymentUser * $order->rate_employee)/100;
                ReportHelper::createEmployee($employees,
                    $order->rate_employee_id,
                    $revenue,
                    1);// quantity = 1
            }

            // Hóa đơn trả nợ, có 2 trường hợp, 1 là có thống tin về rate, có hóa đơn
            if($order->type == 2 && $paymentUser){
                //
                if($order->order_id){
                    //$rate = $order->rate_receptionist;

                    $od = Order::findOne($order->order_id);
                    if($od){
                        //$paymentUser = $od->total_money;
                        $rate_receptionist = 0;
                        if($order->rate_receptionist_id && $order->rate_receptionist){
                            $rate_receptionist = $order->rate_receptionist;
                        }
                        else{
                            if($od->rate_receptionist_id && $od->rate_receptionist) {
                                $rate_receptionist = $od->rate_receptionist;
                            }
                        }

                        if($rate_receptionist) {
                            $revenue = (int)($paymentUser * $od->rate_receptionist) / 100;
                            ReportHelper::createEmployee($employees,
                                $od->rate_receptionist_id,
                                $revenue,
                                1); // quantity = 1
                        }

                        $rate_employee = 0;
                        if($order->rate_employee_id && $order->rate_employee){
                            $rate_employee = $order->rate_employee;
                        }
                        else{
                            if($od->rate_employee_id && $od->rate_employee) {
                                $rate_employee = $od->rate_employee;
                            }
                        }
                        if($rate_employee){
                            $revenue = (int)($paymentUser * $od->rate_employee)/100;
                            ReportHelper::createEmployee($employees,
                                $od->rate_employee_id,
                                $revenue,
                                1);// quantity = 1
                        }
                    }else{
                        // TODO xử lý HĐ đã bị xóa
                    }
                }else{
                    // Case Không có thông tin hóa đơn,
                    if($order->rate_receptionist_id && $order->rate_receptionist){
                        $revenue = (int)($paymentUser * $order->rate_receptionist)/100;
                        ReportHelper::createEmployee($employees,
                            $order->rate_receptionist_id,
                            $revenue,
                            1); // quantity = 1
                    }

                    if($order->rate_employee_id && $order->rate_employee){
                        $revenue = (int)($paymentUser * $order->rate_employee)/100;
                        ReportHelper::createEmployee($employees,
                            $order->rate_employee_id,
                            $revenue,
                            1);// quantity = 1
                    }

                }
            }

            if($order->type == 1 && $order->rate_receptionist_id && $order->rate_receptionist){
                // TODO xem xét lấy hoa hồng của giá trị hóa đơn hay giá trị ban đầu
                $revenue = (int)($paymentUser * $order->rate_receptionist)/100;
                ReportHelper::createEmployee($employees,
                    $order->rate_receptionist_id,
                    $revenue,
                    1); // quantity = 1
            }


        }

        // 2.Doanh thu trong làm dịch vụ

        $activities = Activity::find()->where(['between', 'start_time', $beginOfDay, $endOfDay])->all();
        foreach ($activities as $activity) {
            $details = json_decode($activity->detail);
            $quantity = 0;
            if(is_object($details)) {
                foreach ($details as $key => $number) {
                    $quantity += $number->amount;
                }
            }
            if($quantity == 0){
                $quantity = 1;
            }

            //if($activity->employee_id && $activity->discount) {
            if($activity->employee_id) {
                ReportHelper::createEmployee($employees,
                    $activity->employee_id,
                    ($activity->discount? : 0),$quantity, 'activity');
            }

            if($activity->reception_id && $activity->rate_reception) {
                ReportHelper::createEmployee($employees,
                    $activity->reception_id,
                    $activity->rate_reception,$quantity,'activity');
            }
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

            $report->revenue = $data['money_order'] + $data['money_activity'];
            $report->revenue_order = $data['money_order'];
            $report->revenue_order_quantity = $data['quantity_order'];
            $report->revenue_activity = $data['money_activity'];
            $report->revenue_activity_quantity = $data['quantity_activity'];
            $report->report_date = $date;
            $report->save();

        }

        //Console::output("Done Report Revenue Employee! : $date");
    }

    /**
     * 6.1 Tổng hợp dữ liệu cho báo cáo nhân viên
     */
    public static function calRevenuePaymentDay($date = null, $force = false)
    {
        // Lấy thời gian
        if ($date) {
            $time = strtotime($date);
        } else {
            $time = strtotime("yesterday", time());
            $date = date('Y-m-d', $time);
        }

        $beginOfDay = strtotime("midnight", $time);
        $endOfDay = strtotime("tomorrow", $beginOfDay) - 1;
        $payments = [];

        $orderPayments = \Yii::$app->getDb()->createCommand("SELECT p.id,p.order_id, order_date,payment_id,p.total_money 
                                                                FROM `order_payment` p 
                                                                inner join `order` o on o.id = p.order_id
                                                                where order_date BETWEEN $beginOfDay and $endOfDay")
            ->queryAll();
        //var_dump($orderPayments);die;
        foreach ($orderPayments as $orderPayment) {
            if(isset($payments[$orderPayment['payment_id']])){
                $payments[$orderPayment['payment_id']] += $orderPayment['total_money'];
            }else{
                $payments[$orderPayment['payment_id']] = $orderPayment['total_money'];
            }

        }

        $all_payments = ArrayHelper::map(Payment::find()->all(),'id','name');

        // Tạo report
        foreach ($payments as $payment_id => $data) {
            $report = ReportPayment::findOne(['payment_id' => $payment_id, 'report_date' => $date]);
            if (!$report) {
                $report = new ReportPayment();
            }

            $report->year = date('Y', $time);
            $report->month = date('m', $time);
            $report->quarter = ceil($report->month / 3);
            $report->week = date("W", $time);
            $report->payment_id = $payment_id;

            if(isset($all_payments[$payment_id])){
                $report->payment_name = $all_payments[$payment_id];
            }
            $report->revenue = $data;
            $report->report_date = $date;
            $report->save();
        }

        //Console::output("Done Report Revenue Employee! : $date");
    }


    public static  function calculateRevenue($date)
    {
        $startTimeStamp = strtotime($date);
        $endTimeStamp = strtotime("+1 days", $startTimeStamp);
        // Tạo từ hóa đơn
        $total = 0;
        $revenue_order = 0;
        $orders = Order::find()->where(['between', 'order_date', $startTimeStamp, $endTimeStamp])->all();
        $loan = 0;
        foreach ($orders as $order) {
//            $details = OrderDetail::findAll(['order_id'=>$order->id]);
//            foreach ($details as $detail){
//                $total += $detail->total_money;
//            }
            $total += $order->total_money;
            $revenue_order++;

            // Nợ
            //$payment = $order->orderPayment;
            foreach ($order->orderPayment as $payment){
                if($payment->payment_id == 6){ // Nợ
                    $loan += $payment->total_money;
                }
            }
        }
        return [$total,$revenue_order,$loan];
    }
    /**
     * @param $products
     * @param $orderDetail
     */
    public static function createCustomer(&$arg, $customer_id, $object_id, $quantity, $total_money, $type): void
    {
        if (isset($arg[$customer_id])) {
            if (isset($arg[$customer_id][$type][$object_id])) {
                $arg[$customer_id][$type][$object_id]['quantity'] += $quantity;
                $arg[$customer_id][$type][$object_id]['total_money'] += $total_money;
            } else {
                $arg[$customer_id][$type][$object_id] = array(
                    'quantity' => $quantity,
                    'object_id' => $object_id,
                    'total_money' => $total_money,
                );
            }

        } else {
            // Chưa có
            $services = [];
            if ('service' == $type) {
                $services[$object_id] = array(
                    'quantity' => $quantity,
                    'object_id' => $object_id,
                    'total_money' => $total_money,
                );
            }

            $products = [];
            if ('product' == $type) {
                $products[$object_id] = array(
                    'quantity' => $quantity,
                    'object_id' => $object_id,
                    'total_money' => $total_money,
                );
            }

            $cards = [];
            if ('card' == $type) {
                $cards[$object_id] = array(
                    'quantity' => $quantity,
                    'object_id' => $object_id,
                    'total_money' => $total_money,
                );
            }
            $arg[$customer_id] = array(
                'products' => $products,
                'services' => $services,
                'cards' => $cards
            );
        }
    }


    /**
     * @param $products
     * @param $orderDetail
     */
    public static function createProduct(&$products, $product_id, $quantity, $total_money, $isUse): void
    {
        if (isset($products[$product_id])) {
            $products[$product_id]['quantity'] += $quantity;
            $products[$product_id]['total_money'] += $total_money;
            if ($isUse) {
                $products[$product_id]['use'] += $quantity;
            } else {
                $products[$product_id]['sell'] += $quantity;
            }
        } else {
            // Chưa có
            $products[$product_id] = array(
                'quantity' => $quantity,
                'total_money' => $total_money,
                'use' => $isUse ? $quantity : 0,
                'sell' => $isUse ? 0 : $quantity,
            );
        }
    }


    public static function createService(&$services, $service_id, $quantity, $total_money, $isUse,$service_proceed): void
    {
        $service_price_unit = 0;
        $comboService = Service::findOne($service_id);
        if($comboService){
            $service_price_unit = $comboService->total_price;
        }

        if (isset($services[$service_id])) {
            $services[$service_id]['quantity'] += $quantity;
            $services[$service_id]['total_money'] += $total_money;

            if ($isUse) {
                if($services[$service_id]['service_proceed'] != $service_proceed){
                    $services[$service_id]['service_proceed'] = $service_proceed;
                }
                $services[$service_id]['use'] += $quantity;
            } else {
                $services[$service_id]['sell'] += $quantity;
            }
        } else {
            // Chưa có
            $services[$service_id] = array(
                'service_proceed' => $service_proceed,
                'service_price_unit' => $service_price_unit,
                'quantity' => $quantity,
                'total_money' => $total_money,
                'use' => $isUse ? $quantity : 0,
                'sell' => $isUse ? 0 : $quantity,
                'employee' => [],
            );
        }
    }



    public static  function createEmployee(&$employees, $employee_id, $rate,$quantity, $type = 'order'): void
    {
        if (isset($employees[$employee_id])) {
            if($type == 'order'){
                $employees[$employee_id]['money_order'] += $rate;
                $employees[$employee_id]['quantity_order'] += 1;
            }else{
                $employees[$employee_id]['money_activity'] += $rate;
                $employees[$employee_id]['quantity_activity'] += $quantity;
            }
        } else {
            // Chưa có
            $employees[$employee_id] = array(
                'money_order' => $type == 'order' ? $rate : 0,
                'money_activity' => $type == 'activity' ? $rate : 0,
                'quantity_order' => $type == 'order' ? 1 : 0,
                'quantity_activity' => $type == 'activity' ? $quantity : 0,
            );
        }
    }


    /**
     * Thông báo số lượng dưới UNDER_QUANTITY = 10
     */
    public static  function quantity()
    {
        $products = Product::find()->where(['and','`quantity` < `limit_quantity`',['is_notification'=> 1]])->all();
        foreach ($products as $product) {

            Yii::$app->commandBus->handle(new AddToTimelineCommand([
                'category' => 'product',
                'event' => 'out_of_stock',
                'data' => [
                    'content' => $product->name . ' còn ' . $product->quantity . ' ' . $product->product_unit . ' trong kho',
                    'product_id' => $product->id,
                    'product_code' => $product->slug,
                    'product_name' => $product->name,
                    'quantity' => $product->quantity
                ]
            ]));
        }
        //Console::output('All ok!');
    }


    /**
     * Thông báo sinh nhật cho khách hàng
     */
    public static function birthday()
    {
        // TODO Tạo bảo run_report
        $run = false;
        if (!$run) {
            ReportHelper::createDayMonth();
            $day = date('d');
            $month = date('m');
            $year = date('Y');
            $customers = Customer::find()->where(['day' => $day, 'month' => $month])->all();
            foreach ($customers as $customer) {

                $n = $customer->year - $year;
                Yii::$app->commandBus->handle(new AddToTimelineCommand([
                    'category' => 'customer',
                    'event' => 'birthday',
                    'data' => [
                        'content' => "Sinh nhật lần thứ $n khách hàng $customer->name",
                        'birthday' => Yii::$app->formatter->asDate($customer->birth_of_date),
                        'customer_code' => $customer->slug,
                        'customer_id' => $customer->id,
                        'customer_phone' => $customer->phone,
                    ]
                ]));
            }
            //Console::output('All ok!');
        } else {
            //Console::output('Da chay roi!');
        }
    }

    /**
     * Thông báo làm dịch vụ khách hàng tiềm năng
     */
    public static function remindAbility()
    {
        // Khách hàng tiềm năng 8
        $sixDayBefore = time() -  86400*6;
        $customers = Customer::find()->where(['customer_type_id'=>8])
            ->andWhere(['or',['>','notified_at',$sixDayBefore],['notified_at'=>null]])
            ->all();

        foreach ($customers as $customer) {

            Yii::$app->commandBus->handle(new AddToTimelineCommand([
                'category' => 'customer_service',
                'event' => 'remind-ability',
                'data' => [
                    'content' => "KH $customer->name tiềm năng đến ngày nhắc nhở",
                    'remain' => 0,
                    'customer_id' => $customer->id,
                    'customer_phone' => $customer->phone,
                ]
            ]));
            $customer->notified_at = time();
            if(!$customer->save()){
                var_dump($customer->getErrors());
            }
        }
        //Console::output('All ok!');
    }
    /**
     * Tạo ngày sinh nhật
     */
    public static function createDayMonth()
    {
        $customers = Customer::find()->where(['day' => null])
            ->andWhere(['not', ['birth_of_date' => null]])
            ->andWhere(['not', ['birth_of_date' => '']])
            ->all();
        foreach ($customers as $customer) {
            try {
                $day = date('d', $customer->birth_of_date);
                $month = date('m', $customer->birth_of_date);
                $year = date('Y', $customer->birth_of_date);

                $customer->day = $day;
                $customer->month = $month;
                $customer->year = $year;

                $customer->save();
            } catch (\Exception $ex) {
            }
        }
    }
    /**
     * Thông báo làm dịch vụ
     */
    public static function remind()
    {
        $run = false;
        if (!$run) {
            //$this->createDayMonth();
            //$day = date('d');
            //$month = date('m');
            //$year = date('Y');
            // Tìm trong customer_history các object_type = service

            $customerHistories = CustomerHistory::find()
                //->innerJoin('service','service.remain_time = ')
                //->where(['>', 'remain', 0])

                ->where(['not', ['customer_id' => null]])
                ->andWhere(['not', ['object_id' => null]])
                ->andWhere(['object_type' => ['service_combo', 'service']])
                ->all();
            foreach ($customerHistories as $customerHistory) {

                $customerName = $customerHistory->customer->name;

                $serviceName = $customerHistory->service->name;
                if ($customerHistory->service->remain_time && $customerHistory->updated_at) {
                    //Lấy khoảng thời gian cần nhắc nhở
                    $started_date = new \DateTime(date('Y-m-d', $customerHistory->updated_at));
                    $interval = $started_date->diff(new \DateTime());
                    $interval = $interval->format('%a');
                    // Nếu đúng số ngày nhắc nhở thì nhắn tin
                    //Console::output($interval % $customerHistory->service->remain_time);
                    if ($interval%$customerHistory->service->remain_time == 0) {
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
                        //Console::output($customerName);
                    }
                }else{
                    ////Console::output($customerHistory->service->id);
                }
            }
            //Console::output('Customer History - Service ' . count($customerHistories));

            // Tìm trong customer_history_detail tất cả các dịch vụ của khách hàng gần nhất
            // trong thời gian nhắc nhở của service
            //$customerHistorieDetails =
            ////Console::output('Customer History Detail - Service '. count($customerHistorieDetails));
            //Console::output('All ok!');
        } else {
            //Console::output('Da chay roi!');
        }
    }
}
