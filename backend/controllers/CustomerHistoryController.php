<?php

namespace backend\controllers;

use common\models\base\CustomerHistoryDetail;
use common\models\Card;
use common\models\Product;
use common\models\Service;
use Yii;
use common\models\CustomerHistory;
use common\models\search\CustomerHistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerHistoryController implements the CRUD actions for CustomerHistory model.
 */
class CustomerHistoryController extends Controller
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
     * Lists all CustomerHistory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CustomerHistory model.
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
     * Creates a new CustomerHistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'combo';
        $customer_id = Yii::$app->request->get('customer_id');
        $type = Yii::$app->request->get('type');
        $model = new CustomerHistory();
        $model->customer_id = $customer_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	        $model->object_type = $type;
			if($type=='service'){
				$service = Service::findOne($model->object_id);
				if('combo' == $service->serviceType->slug){
					$model->object_type = 'service_combo';
					$model->amount = $service->number_serve;
					$model->sub = 0;
					$model->remain = $service->number_serve;
				}
			}else{
				$card = Card::findOne($model->object_id);

				if('the-dich-vu' == $card->cardType->slug){
					$model->object_type = 'card_service';
				}else{
                    $model->amount = $card->raw_price;
                }
			}

	        $model->save();
            return $this->redirect(['update', 'id' => $model->id,'customer_id'=>$customer_id,'type'=>$type]);
        }
        $view = $type == 'card'? 'create_card' : 'create';
        return $this->render($view, [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CustomerHistory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

	    $type = Yii::$app->request->get('type');
	    $customer_id = Yii::$app->request->get('customer_id');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $total = 0;
	        if($model->services){
	        	foreach ($model->services as $key=>$service) {

	        	    $s = Service::findOne($key);
	        		if($model->object_type == 'card' || $model->object_type == 'card_service'){
                        if($model->object_type == 'card'){
                            // Tìm

                            $total += $service['amount'] * $s->retail_price;
                        }
			        }else{
                        if($model->object_type == 'service_combo'){
                            $total += $service['amount'];
                        }

			        }

			        $detail              = new CustomerHistoryDetail();
			        $detail->history_id  = $model->id;
			        $detail->customer_id = $customer_id;
			        $detail->object_id   = $key;
			        $detail->object_type = CustomerHistoryDetail::SERVER_IN_CARD;
			        $detail->amount      = $service['amount'];
			        $detail->used_at     = strtotime($service['used_at']);
			        $detail->note = $s->name;
			        $detail->save();
		        }
	        }

	        if($model->products){

		        foreach ($model->products as $key=>$product) {

		        	$p = Product::findOne($key);
                    $total += $product['amount'] * $p->retail_price;
			        $detail              = new CustomerHistoryDetail();
			        $detail->history_id  = $model->id;
			        $detail->customer_id = $customer_id;
			        $detail->object_id   = $key;
			        $detail->object_type = CustomerHistoryDetail::PRODUCT;
			        $detail->amount      = $product['amount'];
			        $detail->used_at     = strtotime($product['used_at']);
			        $detail->note = $p->name;
			        $detail->save();
		        }
	        }
            $model->sub += $total;
            $remain = $model->amount - $model->sub;
            if($remain < 0){
                $remain = 0;
            }
            $model->remain = $remain;
                $model->save();
            //var_dump($model);die;

	        if($customer_id){
		        return $this->redirect(['customer/view', 'id' => $customer_id]);
	        }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if($model->object_type == 'card_service'){

            $update = 'update_card_service';
        }else{
            $update = $type == 'card'? 'update_card' : 'update';
        }

        // Free service
        $freeService = [];
        if($type == 'card'){
           // $freeService
        }
        return $this->render($update, [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CustomerHistory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $ch = $this->findModel($id);
	    //CustomerHistoryService::deleteAll(['service_id'=>$ch->object_id,'customer_id'=>$ch->customer_id]);
	    CustomerHistoryDetail::deleteAll(['history_id'=>$id]);
        $ch->delete();

	    $customer_id = Yii::$app->request->get('customer_id');
	    if($customer_id){
		    return $this->redirect(['customer/view', 'id' => $customer_id]);
	    }
        return $this->redirect(['index']);
    }

    /**
     * Finds the CustomerHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CustomerHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomerHistory::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
