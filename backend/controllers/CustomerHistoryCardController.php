<?php

namespace backend\controllers;

use common\models\base\CardService;
use common\models\CustomerHistory;
use common\models\Product;
use common\models\search\ProductSearch;
use common\models\search\ServiceSearch;
use common\models\Service;
use Yii;
use common\models\CustomerHistoryCard;
use common\models\search\CustomerHistoryCardSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerHistoryCardController implements the CRUD actions for CustomerHistoryCard model.
 */
class CustomerHistoryCardController extends Controller
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
     * Lists all CustomerHistoryCard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerHistoryCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CustomerHistoryCard model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CustomerHistoryCard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'combo';
        $customer_id = Yii::$app->request->get('customer_id');
        $model = new CustomerHistoryCard();
        $model->customer_id = $customer_id;

        if ($customer_id) {
            $customer = \common\models\Customer::findOne($customer_id);
            if ($customer) {
                $model->customer_name = $customer->name;
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Cần lấy số lần đã dùng;
            $cardType = $model->card->cardType->slug;
            $total = 0;
            if ('the-dich-vu' == $cardType && $model->services) {
                $combo = [];
                $comboText = [];
                foreach ($model->services as $key => $value) {
                    $service = Service::findOne($key);
                    if ($service && $value) {
                        $combo[] = array('service' => $service->id, 'time' => $value);
                        $comboText[] = array('service' => $service->slug . ' - ' . $service->name, 'time' => $value);
                        $total += $value;
                    }
                }
                $model->service_combo = json_encode($combo);
                $model->service_combo_text = json_encode($comboText);
                $model->amount = $model->card->amount; // Số buổi ban đầu
                $model->sub_money = $total;
                $model->money = $model->amount - $total; // số tiền còn lại
                $model->save();
            }else{
                $combo = [];
                $comboText = [];
                // Tìm trong card service những dịch vụ không phải mua để trừ số lượng
                $service_free = ArrayHelper::map(CardService::find()->where(['card_id'=>$model->card->id])->all(),'service_id','amount');
                foreach ($model->services as $key => $value) {
                    $service = Service::findOne($key);
                    if ($service && $value) {
                        if(isset($service_free[$key])){
                            $value1 = $value - $service_free[$key];
                            if($value1 < 0){
                                $value1 = 0;
                            }
                            $sub_money = $service->retail_price * $value1;
                        }else{
                            $sub_money = $service->retail_price * $value;
                        }
                        $combo[] = array('service' => $service->id, 'time' => $value,
                            'price'=>$service->retail_price,
                            'total'=>$sub_money,
                        );
                        $comboText[] = array('service' => $service->slug . ' - ' . $service->name,
                            'time' => $value,'price'=>$service->retail_price,
                            'total'=>$sub_money,
                        );

                        $total += $sub_money;
                    }
                }
                $model->service_combo = json_encode($combo);
                $model->service_combo_text = json_encode($comboText);
                $model->amount = $model->card->raw_price; // Số tiền ban đầu
                $model->sub_money = $total;
                $model->money = $model->amount - $total; // số tiền còn lại
                $model->save();
            }


            if ('the-tien' == $cardType && $model->products) {
                $combo = [];
                $comboText = [];
                $total = 0;
                foreach ($model->products as $key => $value) {
                    $product = Product::findOne($key);
                    if ($product && $value) {
                        $sub_money = $product->retail_price * $value;
                        $combo[] = array('product' => $product->id, 'time' => $value,'total'=>$sub_money,'price'=>$product->retail_price);
                        $comboText[] = array('product' => $product->slug . ' - ' . $product->name,
                            'code' => $product->slug,
                            'name' => $product->name,
                            'time' => $value,
                            'price'=>$product->retail_price,'total'=>$sub_money);
                        $total += $sub_money;
                    }
                }
                $model->card_product = json_encode($combo);
                $model->card_product_text = json_encode($comboText);
                $model->amount = $model->card->raw_price;
                $model->sub_money = $total;
                $model->money = $model->amount - $total;
                $model->save();
            }

            // Lưu lịch sử vào bảng customer_history
            $customerHistory = new CustomerHistory();
            $customerHistory->customer_id = $model->customer_id;
            $customerHistory->object_id = $model->card_id;
            $customerHistory->object_type = 'card';
            $customerHistory->quantity = $model->money; // Còn lại
            $customerHistory->save();

            return $this->redirect(['customer/view', 'id' => $model->customer_id]);
        }
        return $this->render('create', [
            'model' => $model,
            'products' => ArrayHelper::map(Product::find()->all(), 'id', 'name'),
        ]);
    }

    /**
     * Updates an existing CustomerHistoryCard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $customer_id = null)
    {
        $model = $this->findModel($id);
        $cardType = $model->card->cardType->slug;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // Cần lấy số lần đã dùng;
            $cardType = $model->card->cardType->slug;
            $total = 0;
            if ('the-dich-vu' == $cardType && $model->services) {
                $combo = [];
                $comboText = [];
                foreach ($model->services as $key => $value) {
                    $service = Service::findOne($key);
                    if ($service && $value) {
                        $combo[] = array('service' => $service->id, 'time' => $value);
                        $comboText[] = array('service' => $service->slug . ' - ' . $service->name, 'time' => $value);
                        $total += $value;
                    }
                }
                $model->service_combo = json_encode($combo);
                $model->service_combo_text = json_encode($comboText);
                $model->amount = $model->card->amount; // Số buổi ban đầu
                $model->sub_money = $total;
                $model->money = $model->amount - $total; // số tiền còn lại
                $model->save();
            }else{
                $combo = [];
                $comboText = [];
                // Tìm trong card service những dịch vụ không phải mua để trừ số lượng
                $service_free = ArrayHelper::map(CardService::find()->where(['card_id'=>$model->card->id])->all(),'service_id','amount');
                foreach ($model->services as $key => $value) {
                    $service = Service::findOne($key);
                    if ($service && $value) {
                        if(isset($service_free[$key])){
                            $value1 = $value - $service_free[$key];
                            if($value1 < 0){
                                $value1 = 0;
                            }
                            $sub_money = $service->retail_price * $value1;
                        }else{
                            $sub_money = $service->retail_price * $value;
                        }
                        $combo[] = array('service' => $service->id, 'time' => $value,
                            'price'=>$service->retail_price,
                            'total'=>$sub_money,
                        );
                        $comboText[] = array('service' => $service->slug . ' - ' . $service->name,
                            'time' => $value,'price'=>$service->retail_price,
                            'total'=>$sub_money,
                            );

                        $total += $sub_money;
                    }
                }
                $model->service_combo = json_encode($combo);
                $model->service_combo_text = json_encode($comboText);
                $model->amount = $model->card->raw_price; // Số tiền ban đầu
                $model->sub_money = $total;
                $model->money = $model->amount - $total; // số tiền còn lại
                $model->save();
            }

            if ('the-tien' == $cardType && $model->products) {
                $combo = [];
                $comboText = [];
                foreach ($model->products as $key => $value) {
                    $product = Product::findOne($key);
                    if ($product && $value) {
                        $sub_money = $product->retail_price * $value;
                        $combo[] = array('product' => $product->id, 'time' => $value,'total'=>$sub_money,'price'=>$product->retail_price);
                        $comboText[] = array('product' => $product->slug . ' - ' . $product->name,
                            'code' => $product->slug,
                            'name' => $product->name,
                            'time' => $value,
                            'price'=>$product->retail_price,'total'=>$sub_money);
                        $total += $sub_money;
                    }
                }
                $model->card_product = json_encode($combo);
                $model->card_product_text = json_encode($comboText);
                $model->amount = $model->card->raw_price;
                $model->sub_money = $total;
                $model->money = $model->amount - $total;
                $model->save();
            }

            if ($customer_id) {
                return $this->redirect(['customer/view', 'id' => $customer_id]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $view = 'the-dich-vu' == $cardType ? 'update_combo' : 'update';
        return $this->render($view, [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CustomerHistoryCard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $customer_id = null)
    {
        $this->findModel($id)->delete();
        if ($customer_id) {
            return $this->redirect(['customer/view', 'id' => $customer_id]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the CustomerHistoryCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CustomerHistoryCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomerHistoryCard::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


//    public function actionAddProduct()
//    {
//        if (Yii::$app->request->isAjax) {
//            $searchModel = new ProductSearch();
//            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//            $dataProvider->pagination->pageSize = 500;
//
//            return $this->renderAjax('_form_add_product', [
//                'searchModel' => $searchModel,
//                'dataProvider' => $dataProvider,
//            ]);
//        } else {
//            $this->redirect(['view', 'id' => $id]);
//        }
//    }
//
//
//
//    public function actionAddService()
//    {
//        if (Yii::$app->request->isAjax) {
//            $searchModel = new ServiceSearch();
//            $dataProvider = $searchModel->searchForCombo(Yii::$app->request->queryParams);
//            $dataProvider->pagination->pageSize = 500;
//
//            return $this->renderAjax('_form_add_service', [
//                'searchModel' => $searchModel,
//                'dataProvider' => $dataProvider,
//            ]);
//        } else {
//            $this->redirect(['view', 'id' => $id]);
//        }
//    }

}
