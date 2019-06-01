<?php

namespace backend\controllers;

use backend\models\AddOrderCardForm;
use backend\models\AddOrderProductForm;
use backend\models\AddOrderServiceForm;
use backend\models\AddPaymentForm;
use backend\models\AddProductForm;
use common\models\base\PaymentHistory;
use common\models\Card;
use common\models\Customer;
use common\models\OrderDetail;
use common\models\OrderPayment;
use common\models\Payment;
use common\models\Product;
use common\models\search\CardSearch;
use common\models\search\ProductSearch;
use common\models\search\ServiceSearch;
use Yii;
use common\models\Order;
use common\models\search\OrderSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'combo';

        if (\Yii::$app->request->isPost) {
            switch (\Yii::$app->request->post('submit')) {
                case 'update':
                    \Yii::$app->session->setFlash('alert', [
                        'options' => ['class' => 'alert-success'],
                        'body' => "Đã cập nhật hóa đơn"
                    ]);
                    return $this->redirect(['update','id'=>$id]);
                    break;
                case 'finish':
                    \Yii::$app->session->setFlash('alert', [
                        'options' => ['class' => 'alert-success'],
                        'body' => "Hoàn tất hóa đơn"
                    ]);
                    break;

            }
            return $this->redirect(['view','id'=>$id]);
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();
        $model->customer_id = Yii::$app->request->get('customer_id');
        $model->order_date = date('d-m-Y H:i:s');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } elseif (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Trả nợ
     * @return mixed
     */
    public function actionPay()
    {
        $model = new Order();
        $model->customer_id = Yii::$app->request->get('customer_id');
        $model->order_date = date('d-m-Y H:i:s');
        if ($model->load(Yii::$app->request->post())) {
            $model->type = 2; // Tra no
            $model->save();

            $payment = new OrderPayment();
            $payment->order_id = $model->id;
            $payment->total_money = $model->real_money;
            $payment->payment_id = 1; // Tiền mặt
            $payment->save();

            // Trừ tiền trong nợ
            if($model->customer_id){
                $customer = Customer::findOne($model->customer_id);
                if($customer){
                    $customer->remain_money -= $model->real_money;
                    if($customer->remain_money < 0){
                        $customer->remain_money = 0;
                    }
                    $customer->save(false);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } elseif (Yii::$app->request->isAjax) {
            return $this->renderAjax('pay', [
                'model' => $model
            ]);
        } else {
            return $this->render('pay', [
                'model' => $model,
            ]);
        }
    }


    // THE CONTROLLER
    public function actionFindOrder() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $customer_id = $parents[0];
                $list = Order::find()->where(['customer_id'=>$customer_id])->all();
                $selected  = null;
                foreach ($list as $i=>$order){
                    $loan = 0;
                    $payments = $order->orderPayment;
                    foreach ($payments as $payment){
                        if($payment->payment_id == 6){
                            $loan = $payment->total_money;
                        }
                    }
                    if($loan) {
                        $displayOrder = date('d/m/Y', $order['order_date']) . ' - Nợ ' . number_format($loan,0,',','.').' Đ';
                        $out[] = ['id' => $order['id'], 'name' => $displayOrder];
                        if ($i == 0) {
                            $selected = $order['id'];
                        }
                    }
                }
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->calculate();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $model->order_date = date('d-m-Y H:i:s',$model->order_date);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    // Tạo danh sách sản phẩm vào hiển thị thành popup
    public function actionAdd($id)
    {
        if ($id) {
            if (Yii::$app->request->isAjax) {
                $searchModel = new ProductSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->pagination->pageSize = 500;
                return $this->renderAjax('_form_add_product', [
                    'id' => $id,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            } else {
                $this->redirect(['view', 'id' => $id]);
            }
        } else {
            $this->redirect(['index']);
        }
    }

    public function actionAddService($id)
    {
        if ($id) {
            if (Yii::$app->request->isAjax) {
                $searchModel = new ServiceSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->pagination->pageSize = 500;
                return $this->renderAjax('_form_add_service', [
                    'id' => $id,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            } else {
                $this->redirect(['view', 'id' => $id]);
            }
        } else {
            $this->redirect(['index']);
        }
    }

    public function actionAddCard($id)
    {
        if ($id) {
            if (Yii::$app->request->isAjax) {
                $searchModel = new CardSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->pagination->pageSize = 500;
                return $this->renderAjax('_form_add_card', [
                    'id' => $id,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            } else {
                $this->redirect(['view', 'id' => $id]);
            }
        } else {
            $this->redirect(['index']);
        }
    }

    public function actionRemove($id,$object_id)
    {
        $model = OrderDetail::findOne(['order_id' => $id, 'object_id' => $object_id]);
        if($model){
            $object_type = $model->object_type;
            if($object_type == 'service'){
                //Xóa service lẻ sẽ cập nhật lịch sử dịch vụ
                $form = new AddOrderServiceForm();
                $form->orderId = $id;
                $form->serviceId = $object_id;
                $form->remove();
                Yii::$app->session->setFlash('alert', [
                    'options' => ['class' => 'alert-success'],
                    'body' => "Thực hiện thành công"
                ]);
            }else{
                $order = Order::findOne($id);
                $quantity = $model->quantity;
                // TODO Nếu object bị xóa
                if ($order) {

                    if($object_type == 'product'){
                        $product = Product::findOne($object_id);
                        $product->quantity += $quantity;
                        $product->save();
                    }
                    $model->delete();
                    $order->calculate();

                    return $this->redirect(['view', 'id' => $id]);
                }
            }


            $this->redirect(['view', 'id' => $id]);
        }else{
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-danger'],
                'body' => "Không tìm thấy đối tượng để xóa"
            ]);
            $this->redirect(['view', 'id' => $id]);
        }

    }

    // Sau khi người dùng chọn được sản phẩm và thêm vào
    public function actionAddProduct()
    {
        $model = new AddOrderProductForm();
        $model->orderId = Yii::$app->request->post('order_id');
        $model->productIds = (array)Yii::$app->request->post('id');
        if ($model->add()) {
            // TODO alert message
//            Yii::$app->session->setFlash('alert', [
//                'options' => ['class' => 'alert-danger'],
//                'body' => ""
//            ]);
        } else {

        }
        $this->redirect(['view', 'id' => $model->orderId]);
    }


    public function actionAddOrderService()
    {
        $model = new AddOrderServiceForm();
        $model->orderId = Yii::$app->request->post('order_id');
        $model->serviceIds = (array)Yii::$app->request->post('id');
        if ($model->add()) {
            // TODO alert message
        } else {

        }
        $this->redirect(['view', 'id' => $model->orderId]);
    }

    public function actionAddOrderCard()
    {
        $model = new AddOrderCardForm();
        $model->orderId = Yii::$app->request->post('order_id');
        $model->cardIds = (array)Yii::$app->request->post('id');
        if ($model->add()) {
            // TODO alert message
            $order = $this->findModel($model->orderId);

            // Thêm vào lịch sử thẻ và cộng tiền
            $customer = Customer::findOne($order->customer_id);
            $add_money = 0;
            //var_dump($order);die;
            $before = $customer->account_money;
            foreach($model->cardIds as $cardId){
                $card = Card::findOne($cardId);
                if('the-tien' == $card->cardType->slug){
                    $add_money += $card->raw_price;
                    if($card->raw_price) {
                        $paymentHistory = new PaymentHistory();
                        $paymentHistory->customer_id = $customer->id;
                        $paymentHistory->before_money = $before;
                        $paymentHistory->change_money = $card->raw_price;
                        $paymentHistory->current_money = $before + $card->raw_price;
                        $paymentHistory->object_type = 'card';
                        $paymentHistory->object_id = $card->id;
                        $paymentHistory->type = 1; // Cộng tiền
                        $paymentHistory->reason = 'Mua thẻ';
                        $paymentHistory->save();
                        $before += $card->raw_price;
                    }
                }

            }
            $customer->account_money += $add_money;
            $customer->save();

            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => "Mua thẻ thành công"
            ]);

        } else {

        }
        $this->redirect(['view', 'id' => $model->orderId]);
    }

    public function actionAddPayment($id)
    {
        $payments = Payment::find()->active()->all();
        $order_payments = ArrayHelper::map(OrderPayment::findAll(['order_id' => $id]), 'payment_id', 'total_money');
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form_add_payment', [
                'id' => $id,
                'payments' => $payments,
                'order_payments' => $order_payments,
            ]);
        }

        $model = new AddPaymentForm();
        if ($model->load(Yii::$app->request->post()) && $model->add()) {

            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => "Ghi nợ thành công"
            ]);

            $this->redirect(['view', 'id' => $id]);
        }

    }

    public function actionUpdateProduct()
    {
        $model = new AddOrderProductForm();
        $model->orderId = Yii::$app->request->post('orderid');
        $model->productId = Yii::$app->request->post('objectid');
        $model->amount = Yii::$app->request->post('amount');
        if ($model->update()) {
            // TODO alert message
        } else {

        }
        $this->redirect(['view', 'id' => $model->orderId]);

    }

    public function actionUpdateService()
    {
        $model = new AddOrderServiceForm();
        $model->orderId = Yii::$app->request->post('orderid');
        $model->serviceId = Yii::$app->request->post('objectid');
        $model->amount = Yii::$app->request->post('amount');
        if ($model->update()) {
            // TODO alert message
        } else {

        }
        $this->redirect(['view', 'id' => $model->orderId]);

    }


    public function actionUpdateCard()
    {
        $model = new AddOrderCardForm();
        $model->orderId = Yii::$app->request->post('orderid');
        $model->cardId = Yii::$app->request->post('objectid');
        $model->amount = Yii::$app->request->post('amount');
        if ($model->update()) {
            // TODO alert message
        } else {

        }
        $this->redirect(['view', 'id' => $model->orderId]);

    }
}
