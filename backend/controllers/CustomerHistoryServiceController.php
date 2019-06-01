<?php

namespace backend\controllers;

use common\models\base\CustomerHistoryDetail;
use common\models\CustomerHistory;
use common\models\Service;
use Yii;
use common\models\CustomerHistoryService;
use common\models\search\CustomerHistoryServiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerHistoryServiceController implements the CRUD actions for CustomerHistoryService model.
 */
class CustomerHistoryServiceController extends Controller
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
     * Lists all CustomerHistoryService models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerHistoryServiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CustomerHistoryService model.
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
     * Creates a new CustomerHistoryService model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'combo';
        $customer_id = Yii::$app->request->get('customer_id');
        $model = new CustomerHistoryService();
        $model->customer_id = $customer_id;

        if ($customer_id) {
            $customer = \common\models\Customer::findOne($customer_id);
            if ($customer) {
                $model->customer_name = $customer->name;
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // Tìm dịch vụ đang làm
            $ch = CustomerHistory::find()->where(['customer_id'=>$customer_id,'object_id'=>$model->service_id])
                ->andWhere(['>','remain',0])->one();
            // Cần lấy số lần đã dùng;
            $serviceType = $model->service->serviceType->slug;
            $total = 0;
            if ('combo' == $serviceType) {
                $combo = [];
                $comboText = [];
                foreach ($model->services as $key => $value) {
                    $service = Service::findOne($key);
                    if ($service) {
                        $combo[] = array('service' => $service->id, 'time' => $value);
                        $comboText[] = array('service' => $service->slug . ' - ' . $service->name, 'time' => $value);
                        $total+=$value;
                    }
                }
                $model->service_combo = json_encode($combo);
                $model->service_combo_text = json_encode($comboText);
                $model->amount_use = $total;
                $model->amount = $model->service->number_serve;
                $model->amount_remain = $model->amount - $model->amount_use;
                $model->save();

                // Lưu lịch sử vào bảng customer_history
                if($ch) {
                    $ch->sub += $total;
                }else{
                    $ch = new CustomerHistory();
                    $ch->customer_id = $model->customer_id;
                    $ch->object_id = $model->service_id;
                    $ch->object_type = 'service';
                    $ch->sub = $total;
                }
                $ch->amount = $model->service->number_serve; // Còn lại
                $remain = $ch->amount - $ch->sub;
                if($remain >= 0){
                    $ch->remain =  $remain;// Còn lại
                    $ch->save();

                    //Lưu vào bảng customer history và detail
                    $t = strtotime($model->started_date);
                    foreach ($model->services as $key => $value) {
                        $service = Service::findOne($key);
                        if ($service && $value) {
                            $d = new CustomerHistoryDetail();
                            $d->history_id = $ch->id;
                            $d->customer_id = $model->customer_id;
                            $d->object_id = $service->id;
                            $d->object_type = CustomerHistoryDetail::SERVICE_IN_COMBO;
                            $d->used_at = $t;
                            $d->amount = $value; // Số lượng sử dụng
                            $d->note = $service->name;
                            if(!$d->save()){
                                Yii::error(json_encode($d->getErrors()),'history');
                            }

                        }
                    }
                }else{
                    Yii::$app->session->setFlash('alert', [
                        'options' => ['class' => 'alert-danger'],
                        'body' => "Gói không còn đủ số lượng buổi"
                    ]);

                    // TODO xóa
                }


            }
            return $this->redirect(['customer/view', 'id' => $model->customer_id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CustomerHistoryService model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $customer_id = null)
    {
        //$model = $this->findModel($id);

        $ch = CustomerHistory::find()->where(['customer_id'=>$customer_id,'object_id'=>$model->service_id])->one();

        $serviceType = $model->service->serviceType->slug;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // Cần lấy số lần đã dùng;
            $serviceType = $model->service->serviceType->slug;
            $total = 0;
            if ('combo' == $serviceType) {
                $combo = [];
                $comboText = [];
                foreach ($model->services as $key => $value) {
                    $service = Service::findOne($key);
                    if ($service) {
                        $combo[] = array('service' => $service->id, 'time' => $value);
                        $comboText[] = array('service' => $service->slug . ' - ' . $service->name, 'time' => $value);
                        $total+=$value;
                    }
                }
                $model->service_combo = json_encode($combo);
                $model->service_combo_text = json_encode($comboText);
                $model->amount_use = $total;
                $model->amount_remain = $model->amount - $model->amount_use;
                $model->save();
            }

            if($customer_id){
                return $this->redirect(['customer/view', 'id' => $customer_id]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $view = 'combo' == $serviceType? 'update_combo': 'update';
        return $this->render($view, [
            'model' => $model,
            'ch' => $ch,
        ]);
    }

    /**
     * Deletes an existing CustomerHistoryService model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $customer_id = null)
    {
        //$this->findModel($id)->delete();
	    // $id của bảng customer history
	    $ch = CustomerHistory::findOne($id);
	    if($ch){
	    	$service_id = $ch->object_id;
	        CustomerHistoryService::deleteAll(['service_id'=>$service_id,'customer_id'=>$customer_id]);
	        CustomerHistoryDetail::deleteAll(['history_id'=>$id]);
	    	$ch->delete();
	    }

        if($customer_id){
            return $this->redirect(['customer/view', 'id' => $customer_id]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the CustomerHistoryService model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CustomerHistoryService the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomerHistoryService::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
