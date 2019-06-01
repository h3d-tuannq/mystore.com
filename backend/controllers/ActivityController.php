<?php

namespace backend\controllers;

use common\models\base\Activity;
use common\models\base\CustomerHistoryDetail;
use common\models\base\CustomerService;
use common\models\base\PaymentHistory;
use common\models\Customer;
use common\models\CustomerHistory;
use common\models\Employee;
use common\models\EmployeeTimesheet;
use common\models\Product;
use common\models\Service;
use common\models\search\ActivitySearch;
use common\models\ServiceProduct;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ActivityController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new ActivitySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        return $this->render('index');

    }

    public function actionTimekeeping()
    {
        $this->layout = 'combo';
        return $this->render('timekeeping',
            [
                'employees' => Employee::find()->active()->all()
            ]
        );
    }

    public function actionJsoncalendar($start = NULL, $end = NULL, $_ = NULL)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $times = \app\modules\timetrack\models\Timetable::find()
            ->where(array('category' => \app\modules\timetrack\models\Timetable::CAT_TIMETRACK))->all();

        $events = array();

        foreach ($times AS $time) {
            //Testing
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $time->id;
            $Event->title = $time->categoryAsString;
            $Event->start = date('Y-m-d\TH:i:s\Z', strtotime($time->date_start . ' ' . $time->time_start));
            $Event->end = date('Y-m-d\TH:i:s\Z', strtotime($time->date_end . ' ' . $time->time_end));
            $events[] = $Event;
        }

        return $events;
    }

    public function actionDoService()
    {
        $this->layout = 'combo';
        $model = new Activity();
        $model->start_time = date('d-m-Y H:i:s');
        $model->end_time = date('d-m-Y H:i:s', strtotime('+1 hours'));

        $customers = ArrayHelper::map(Customer::all(), 'id', 'text');
        $services = ArrayHelper::map(Service::all(), 'id', 'name');
        if ($model->load(\Yii::$app->request->post())) {


            // Kiểm tra tiền trước
            if ($model->service_id && $model->service && $model->service->serviceType->slug == 'ban-le') {

                //Kiểm tra xem khách hàng đã mua dịch vụ chưa
                $customerHistory = CustomerHistory::find()
                    ->where([
                        'customer_id' => $model->customer_id,
                        'object_type' => 'service',
                        'object_id' => $model->service_id])
                    ->andWhere(['>', 'remain', 0])
                    ->one();
                if ($customerHistory) {
                    // đã mua
//                    \Yii::$app->session->setFlash('alert', [
//                        'options' => ['class' => 'alert-danger'],
//                        'body' => "Đã mua"]);
//                    return $this->render('do_service', [
//                        'model' => $model,
//                        'customers' => $customers,
//                        'services' => $services,
//                    ]);
                } else {

                    //Kiểm tra tiền trong account_money
                    $customer = Customer::findOne($model->customer_id);
                    $subMoney = $model->service->retail_price;
                    if ($customer && $customer->account_money < $subMoney) {
                        \Yii::$app->session->setFlash('alert', [
                            'options' => ['class' => 'alert-danger'],
                            'body' => "Khách hàng không đủ tiền, tạo hóa đơn nạp tiền cho Khách hàng trước<br/>"
                                . "Tạo hóa đơn <a href='/order/create?customer_id=" . $model->customer_id . "' class='btn'>Tạo hóa đơn</a>"
                        ]);
                        return $this->render('do_service', [
                            'model' => $model,
                            'customers' => $customers,
                            'services' => $services,
                        ]);
                    }
                }
            }
            if (!$model->save()) {
                return $this->render('do_service', [
                    'model' => $model,
                ]);
            }
            if (!$model->discount) {
                $service = Service::findOne($model->service_id);
                if ($service) {
                    $model->discount = $service->discount_money;
                }

            }
            // Nếu dịch vụ lẻ thì cập nhật luôn vào lịch sử
            if ($model->service_id && $model->service && $model->service->serviceType->slug == 'ban-le') {
                $model->object_type = Activity::OBJECT_TYPE_SERVICE;
                //Kiểm tra tiền trong account_money
                $customer = Customer::findOne($model->customer_id);
                $subMoney = $model->service->retail_price;
                if ($customer && $customer->account_money >= $subMoney) {
                    $before = $customer->account_money;
                    $customer->account_money -= $subMoney;
                    $customer->save();

                    $paymentHistory = new PaymentHistory();
                    $paymentHistory->customer_id = $customer->id;
                    $paymentHistory->before_money = $before;
                    $paymentHistory->change_money = $subMoney;
                    $paymentHistory->current_money = $customer->account_money;
                    $paymentHistory->object_type = 'service';
                    $paymentHistory->object_id = $model->service->id;
                    $paymentHistory->type = 2; // Trừ tiền
                    $paymentHistory->reason = 'Mua dịch vụ';
                    $paymentHistory->save();
                } else {
                    $customerHistory = CustomerHistory::find()
                        ->where([
                            'customer_id' => $model->customer_id,
                            'object_type' => 'service',
                            'object_id' => $model->service_id])
                        ->andWhere(['>', 'remain', 0])
                        ->one();
                    if($customerHistory){

                    }else {
                        \Yii::$app->session->setFlash('alert', [
                            'options' => ['class' => 'alert-danger'],
                            'body' => "Khách hàng không đủ tiền"
                        ]);
                        return $this->redirect(['update', 'id' => $model->id]);
                    }
                }
                //Activity::OBJECT_TYPE_COMBO == $model->object_type
                $customerHistory = new CustomerHistory();
                $customerHistory->started_date = date('Y-m-d', $model->start_time);
                $customerHistory->customer_id = $model->customer_id;
                $customerHistory->object_id = $model->service_id;
                $customerHistory->object_type = CustomerHistory::OBJECT_TYPE_SERVICE;
                $customerHistory->amount = 1;
                $customerHistory->sub = 1;
                $customerHistory->remain = 0;
                $customerHistory->save();

                //cập nhật detail cho service
                $detailServices = [];
                $detailServices[$model->service_id] = array('amount' => 1);
                $model->detail = json_encode($detailServices);


                // TODO cập nhật sản phẩm tiêu hao
                $serviceProducts = ServiceProduct::findAll(['service_id' => $model->service_id]);
                $products = [];
                $detailProducts = [];
                foreach ($serviceProducts as $serviceProduct) {
                    $products[] = array(
                        'product_id' => $serviceProduct->product_id,
                        'slug' => $serviceProduct->product->slug,
                        'name' => $serviceProduct->product->name,
                        'unit_price' => $serviceProduct->product->input_price,
                        'amount' => $serviceProduct->amount,
                        'unit' => $serviceProduct->unit,
                        'money' => $serviceProduct->amount * $serviceProduct->product->input_price,
                    );

                    // Trừ số lượng sản phẩm, cho phép trừ xuống âm
                    $prod = Product::findOne($serviceProduct->product_id);
                    if ($prod) {
                        $prod->quantity -= $serviceProduct->amount;
                        $prod->save();
                    }
//                    if ($prod && $prod->quantity >= $serviceProduct->amount) {
//                        $prod->quantity -= $serviceProduct->amount;
//                        $prod->save();
//                    }
                }

                $detailProducts[] = array(
                    'service_id' => $model->service_id,
                    'service_name' => $model->service->name,
                    'products' => $products
                );
                $model->detail_products = json_encode($detailProducts);

                $model->start_time = date('d-m-Y H:i', $model->start_time);
                $model->end_time = date('d-m-Y H:i', $model->end_time);
                $model->save();

                \Yii::$app->session->setFlash('alert', [
                    'options' => ['class' => 'alert-success'],
                    'body' => "Tạo lịch làm việc cho dịch vụ"
                ]);
            } else {
                \Yii::$app->session->setFlash('alert', [
                    'options' => ['class' => 'alert-success'],
                    'body' => "Thực hiện thành công"
                ]);
            }


            if ($model->service && 'combo' == $model->service->serviceType->slug) {
                $model->object_type = Activity::OBJECT_TYPE_COMBO;
                $model->start_time = date('d-m-Y H:i', $model->start_time);
                $model->end_time = date('d-m-Y H:i', $model->end_time);
                $model->save();
                \Yii::$app->session->setFlash('alert', [
                    'options' => ['class' => 'alert-success'],
                    'body' => "Tạo thành công! Chuyển sang thêm dịch vụ vào combo"
                ]);
                // Case 2 Dịch vụ combo, phải chọn dịch vụ lẻ
                return $this->redirect(['update', 'id' => $model->id]);

            }
            // Case 1 Dịch vụ lẻ
            if ($model->service && 'ban-le' == $model->service->serviceType->slug) {
                \Yii::$app->session->setFlash('alert', [
                    'options' => ['class' => 'alert-success'],
                    'body' => "Tạo thành công! Chuyển sang thêm sản phẩm tiêu hao"
                ]);
                // Case 2 Dịch vụ combo, phải chọn dịch vụ lẻ
                return $this->redirect(['update', 'id' => $model->id]);

            }
            // Case 3 Thẻ tiền
            return $this->redirect(['do-service']);
        }
        return $this->render('do_service', [
            'model' => $model,
            'customers' => $customers,
            'services' => $services,
        ]);
    }

    public function actionAll()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // Ngày hiện tại
        //time();
        $activities = Activity::find()
            //->where(['>','start_time',time()])
            ->all();
        $result = [];
        foreach ($activities as $activity) {
            $title = date('H:i', $activity->start_time) . ' - ' . date('H:i', $activity->end_time);
            if ($activity->customer) {
                $title .= $activity->customer->slug;
            } else {
                $title .= ' Khách Lẻ';
            }
            if ($activity->service) {
                $title .= ' - ' . $activity->service->name;
            }

            if ($activity->note) {
                $title .= "\nGhi chú: " . $activity->note;
            }
            if ($activity->employee) {
                $title .= "\nNhân viên: " . $activity->employee->name;
            }
            $result[] = array(
                'title' => $title,
                'resourceId' => $activity->employee_id,
                'start' => date('Y-m-d H:i:s', $activity->start_time),
                'end' => date('Y-m-d H:i:s', $activity->end_time),
                'activity_id' => $activity->id,

            );
        }
        return $result;
    }

    public function actionAllTimekeeping()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // Ngày hiện tại
        //time();
        $timesheets = EmployeeTimesheet::find()
            //->where(['>','start_time',time()])
            ->all();
        $result = [];
        foreach ($timesheets as $timesheet) {
            if ($timesheet->status == EmployeeTimesheet::STATUS_OFF) {
                $title = 'OFF';
            } else {
                $title = substr_replace($timesheet->start_time, '', 5) . ' - ' . substr_replace($timesheet->end_time, '', 5);

            }

            $result[] = array(
                'title' => $title,
                'resourceId' => $timesheet->employee_id,
                'start' => $timesheet->timesheet_date . ' ' . $timesheet->start_time,
                'end' => $timesheet->timesheet_date . ' ' . $timesheet->end_time,
                'timesheet_id' => $timesheet->id,
                'backgroundColor' => $timesheet->status == EmployeeTimesheet::STATUS_OFF ? 'red' : 'green',

            );
        }
        return $result;
    }

    public function actionCreateTimekeeping()
    {
        $customers = ArrayHelper::map(Customer::all(), 'id', 'text');
        $model = new EmployeeTimesheet();
        if (\Yii::$app->request->isAjax) {
            $start = \Yii::$app->request->get('start');
            if ($start) {
                $start = $start / 1000;
                $startHour = date('H', $start);
                if ($startHour < 8) {
                    //$model->start_time = '08:00';
                } else {
                    $model->start_time = date('H:i:s', $start);
                }

            }

            $end = \Yii::$app->request->get('end');
            if ($end) {
                $end = $end / 1000;

                $endHour = date('H', $end);
                if ($endHour > 21) {
                    $model->end_time = '9:00 PM';
                } else {
                    $model->end_time = date('H:i:s', $end);
                }
            }
            $model->timesheet_date = date('d-m-Y', $start);
            $model->employee_id = \Yii::$app->request->get('employee');
            return $this->renderAjax('_form_timesheet', [
                'model' => $model, 'customers' => $customers,
            ]);
        }
        if ($model->load(\Yii::$app->request->post())) {
            $model->timesheet_date = date('Y-m-d', strtotime($model->timesheet_date));
            if ($model->off) {
                $model->status = EmployeeTimesheet::STATUS_OFF;
            }
            if ($model->save()) {
                return $this->redirect(['timekeeping']);
            } else {
                var_dump($model->getErrors());
                die;
            }
        }
        return $this->render('create', [
            'model' => $model, 'customers' => $customers,
        ]);
    }

    public function actionGetEmployee()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //return Employee::find()->select('id,name as title,name as eventColor')->active()->asArray()->all();
        return Employee::find()->select('id,name as title')->active()->orderBy('slug')->asArray()->all();
    }

    public function actionUpdate($id)
    {
        // Cập nhật dịch vụ chi tiết
        $model = $this->findModel($id);
        $searchModel = new \common\models\search\ServiceSearch();
        $dataProvider = $searchModel->searchByService(\Yii::$app->request->queryParams,
            $model->service_id);
        $dataProvider->pagination->pageSize = 500;

        $searchProductModel = new \common\models\search\ProductSearch();
        $dataProductProvider = $searchProductModel->search(\Yii::$app->request->queryParams);
        $dataProductProvider->pagination->pageSize = 500;
        if(!$model->rate_reception_input){
            $model->rate_reception_input = $model->rate_reception;
        }
        $detailServices = [];
        if ($model->load(\Yii::$app->request->post())) {
            // Các dịch vụ dùng, kiểm tra với lịch sử, nếu khác biệt thì cập nhật
            if ($model->services) {

                $count = 0; //Doanh thu cho lễ tân để tính hạn mức doanh thu đạt được
                // Tính giá mỗi buổi
                $revenue = 0;
                foreach ($model->services as $key => $s) {
                    if ($s['amount'] > 0) {
                        $detailServices[$key] = $s;
                        $count += $s['amount'];

                        $subService = Service::findOne($key);
                        if($subService){
                            $revenue += $subService->retail_price * $s['amount'];
                        }
                    }
                }

                if($model->reception_id){
                    if (Activity::OBJECT_TYPE_COMBO == $model->object_type) {
                        $comboService = Service::findOne($model->service_id);
                        if($comboService){
                            $model->rate_reception = $count * ($comboService->retail_price / $comboService->number_serve);
                        }

                    }else{
                        // Dịch vụ lẻ, chỉ 1 dịch vụ, 2 dịch vụ thì tạo 2 cái
                        $model->rate_reception = $revenue * 0.5;
                    }
                }
                if($model->rate_reception_input && $model->rate_reception_input != $model->rate_reception){
                    $model->rate_reception = $model->rate_reception_input;
                }

            }


            if (Activity::OBJECT_TYPE_COMBO == $model->object_type) {
                $detail = $model->detail;
                $userService = json_encode($model->services);
                if ($detail == $userService) {

                } else {


                    //Kiểm tra dịch vụ đã được cập nhật hay không
                    //Kiểm tra gói dịch vụ là combo
                    // Tìm gói combo đã có trong lịch sử và con hạn dùng, số lần dùng thì lưu vào đó

                    $customerHistory = CustomerHistory::find()->where(['customer_id' => $model->customer_id, 'object_type' => 'service_combo', 'object_id' => $model->service_id])
                        ->andWhere(['>', 'remain', 0])
                        ->one();
                    if ($customerHistory) {
                        $customerHistory->sub += 1;
                    } else {
                        //Lưu CustomerHistory vào bảng customer_history, nếu có thì lấy history_id
                        $customerHistory = new CustomerHistory();
                        $customerHistory->customer_id = $model->customer_id;
                        $customerHistory->object_id = $model->service_id;
                        $customerHistory->object_type = 'service_combo';
                        $customerHistory->amount = $model->service->number_serve;
                        $customerHistory->sub = 1;
                    }

                    $customerHistory->remain = $customerHistory->amount - $customerHistory->sub;
                    //$customerHistory->quantity = $model->money; // Còn lại
                    $customerHistory->save();
                    //$model->services
                    // Lưu service của người dùng
                    if ($model->services) {
                        $tipMoney = 0;
                        foreach ($model->services as $key => $service) {

                            $s = Service::findOne($key);
                            if ($s) {
                                $detail = new CustomerHistoryDetail();
                                $detail->history_id = $customerHistory->id;
                                $detail->customer_id = $model->customer_id;
                                $detail->object_id = $model->service_id;
                                $detail->object_type = CustomerHistoryDetail::SERVICE_IN_COMBO;
                                $detail->amount = $service['amount'];
                                $detail->used_at = strtotime($model->start_time);
                                $detail->note = $s->name;
                                $detail->save();

                                $tipMoney += $s->discount_money;
                            }
                        }
                        \Yii::error($tipMoney, 'TipMoney');
                        $model->discount = $tipMoney;
                        \Yii::$app->session->setFlash('alert', [
                            'options' => ['class' => 'alert-success'],
                            'body' => "Cập nhật thành công! Sản phẩm tiêu hao được cập nhật"
                        ]);
                    } else {

                        \Yii::$app->session->setFlash('alert', [
                            'options' => ['class' => 'alert-success'],
                            'body' => "Cập nhật thành công"
                        ]);
                    }
                }
            } // Cập nhật combo


            // Sản phẩm tiêu hao của combo
            // Nếu có detail nghĩa là service thì tự động tạo ra detail_products
            $model->detail = json_encode($detailServices);
            if ($model->detail) {

                if ($model->detail_products) {

                    // Cập nhật từ người dùng
                    if ($model->products) {
                        $detailProducts = json_decode($model->detail_products);

                        $has_more_product = false;
                        $newProducts = [];
                        foreach ($detailProducts as $detailProduct) {
                            if($detailProduct->service_id == 0){
                                $has_more_product = true;
                            }
                            if (isset($model->products[$detailProduct->service_id])) {

                                $userProducts = $model->products[$detailProduct->service_id];
                                foreach ($detailProduct->products as $pro) {
                                    if($detailProduct->service_id == 0){
                                        $newProducts[] = $pro->product_id;
                                    }
                                    // Số lượng cũ
                                    $before = $pro->amount;

                                    if (isset($userProducts[$pro->product_id])) {
                                        $pro->amount = $userProducts[$pro->product_id]['amount'];
                                        $pro->money = $pro->amount * $pro->unit_price;

                                        $change = $userProducts[$pro->product_id]['amount'] - $before;
                                        // Trừ số lượng sản phẩm, số âm
                                        $prod = Product::findOne($pro->product_id);
                                        if ($prod) {
                                            $prod->quantity -= $change;
                                            $prod->save();
                                        }
//                                            if ($prod && $prod->quantity >= $change) {
//                                                $prod->quantity -= $change;
//                                                $prod->save();
//                                            }
//                                        if ($change > 0) {
//
//                                        } elseif ($change < 0) {
//                                            // Cộng số lượng sản phẩm
//                                            $prod = Product::findOne($pro->product_id);
//                                            if ($prod) {
//                                                $prod->quantity -= $change;
//                                                $prod->save();
//                                            }
//                                        }
                                    }
                                }
                            }


                        }

                        // Kiểm tra sản phẩm không thuộc dịch vụ
                        if(isset($model->products[0])){
                            if($has_more_product) {
                                $addProducs = [];
                                foreach ($model->products[0] as $k => $v) {
                                    if (in_array($k, $newProducts)) {
                                        continue;
                                    }
                                    $prod = Product::findOne($k);
                                    $addProducs[] = array(
                                        'product_id' => $k,
                                        'slug' => $prod->slug,
                                        'name' => $prod->name,
                                        'unit_price' => $prod->input_price,
                                        'amount' => $v['amount'],
                                        'unit' => $prod->product_unit,
                                        'money' => $v['amount'] * $prod->input_price,
                                    );
                                    if ($prod && $v['amount']) {
                                        $prod->quantity -= $v['amount'];
                                        $prod->save();
                                    }
//                                    if ($prod && $v['amount'] && $prod->quantity >= $v['amount']) {
//                                        $prod->quantity -= $v['amount'];
//                                        $prod->save();
//                                    }

                                }

                                if($addProducs) {
                                    // Chưa từng add
                                    foreach ($detailProducts as $detailProduct) {
                                        if ($detailProduct->service_id == 0) {
                                            $detailProduct->products = ArrayHelper::merge($detailProduct->products,$addProducs);
                                        }
                                    }
                                }
                            }else{
                                foreach ($model->products[0] as $k => $v) {
                                    $prod = Product::findOne($k);
                                    $addProducs[] = array(
                                        'product_id' => $k,
                                        'slug' => $prod->slug,
                                        'name' => $prod->name,
                                        'unit_price' => $prod->input_price,
                                        'amount' => $v['amount'],
                                        'unit' => $prod->product_unit,
                                        'money' => $v['amount'] * $prod->input_price,
                                    );
                                    if ($prod && $v['amount']) {
                                        $prod->quantity -= $v['amount'];
                                        $prod->save();
                                    }
//                                    if ($prod && $v['amount'] && $prod->quantity >= $v['amount']) {
//                                        $prod->quantity -= $v['amount'];
//                                        $prod->save();
//                                    }
                                }

                                // Chưa từng add
                                $detailProducts[] = array(
                                    'service_id'=>0,
                                    'service_name'=>'Tiêu hao',
                                    'products'=> $addProducs
                                );
                            }

                        }

                        if($detailProducts){
                            $model->detail_products = json_encode($detailProducts);
                        }else{
                            $model->detail_products = '';
                        }


                        \Yii::$app->session->setFlash('alert', [
                            'options' => ['class' => 'alert-success'],
                            'body' => "Cập nhật lại sản phẩm tiêu hao thành công"
                        ]);
                    }
                } else {
                    // Chưa có sản phẩm tiêu hao

                    // Danh sách các service
                    $detail = json_decode($model->detail);

                    $detailProducts = [];
                    foreach ($detail as $key => $s) {

                        // Tìm tất cả sản phẩm dùng trong service
                        $serviceProducts = ServiceProduct::findAll(['service_id' => $key]);
                        $products = [];
                        foreach ($serviceProducts as $serviceProduct) {
                            $products[] = array(
                                'product_id' => $serviceProduct->product_id,
                                'slug' => $serviceProduct->product->slug,
                                'name' => $serviceProduct->product->name,
                                'unit_price' => $serviceProduct->product->input_price,
                                'amount' => $serviceProduct->amount,
                                'unit' => $serviceProduct->unit,
                                'money' => $serviceProduct->amount * $serviceProduct->product->input_price,
                            );

                            // Trừ số lượng sản phẩm
                            $prod = Product::findOne($serviceProduct->product_id);
                            if ($prod) {
                                $prod->quantity -= $serviceProduct->amount;
                                $prod->save();
                            }
//                            if ($prod && $prod->quantity >= $serviceProduct->amount) {
//                                $prod->quantity -= $serviceProduct->amount;
//                                $prod->save();
//                            }
                        }
                        $service = Service::findOne($key);
                        $detailProducts[] = array(
                            'service_id' => $key,
                            'service_name' => $service->name,
                            'products' => $products
                        );


                    }

                    if($detailProducts){
                        $model->detail_products = json_encode($detailProducts);
                    }else{
                        $model->detail_products = '';
                    }
                }
                //$model->detail_products = null;

            }

            $model->save();

        } // End load post

        $model->start_time = date('d-m-Y H:i', $model->start_time);
        $model->end_time = date('d-m-Y H:i', $model->end_time);

        return $this->render('update', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchProductModel' => $searchProductModel,
            'dataProductProvider' => $dataProductProvider,
            'detail_products' => $model->detail_products ? json_decode($model->detail_products) : [],
        ]);
    }

    public function actionView($id)
    {
        // Xem vật dụng tiêu hao
        return $this->render('view', [
            'model' =>  $this->findModel($id)

        ]);
    }

    /**
     * Deletes an existing Card model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        // Lấy lại số lượng sản phẩm tiêu hao

        // Xóa lịch sử khách hàng

        // Cộng lại số lần sử dụng dịch vụ cho khách hàng


        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Card model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Card the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Activity::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
