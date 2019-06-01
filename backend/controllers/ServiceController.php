<?php

namespace backend\controllers;

use backend\models\AddServiceComboForm;
use backend\models\AddServiceProductForm;
use backend\models\ExportForm;
use common\models\Common;
use common\models\search\ProductSearch;
use common\models\search\ServiceMixSearch;
use common\models\search\ServiceProductSearch;
use common\models\search\ServiceSearch;
use common\models\Service;
use common\models\ServiceMix;
use common\models\ServiceProduct;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Query;
/**
 * ServiceController implements the CRUD actions for Service model.
 */
class ServiceController extends Controller
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

    public function actions()
    {
        return [
            'change-sort' => [
                'class' => 'demi\sort\SortAction',
                'modelClass' => \common\models\ServiceProduct::className(),

                // optionaly
                'afterChange' => function ($model) {
                    if (!Yii::$app->request->isAjax) {
                        return Yii::$app->response->redirect(Url::to(['update', 'id' => $model->service_id]));
                    } else {
                        return Yii::$app->controller->renderPartial('index', ['model' => $model]);
                    }
                },
                // or
                'redirectUrl' => ['index'],
                // or
                'redirectUrl' => function ($model) {
                    return ['update', 'id' => $model->id];
                },

                'canSort' => Yii::$app->user->can('administrator'),
                // or
//                'canSort' => function ($model) {
//                    return Yii::$app->user->id == $model->created_by;
//                },
            ],
        ];
    }

    /**
     * Lists all Service models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new ServiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all Service models.
     * @return mixed
     */
    public function actionCombo()
    {

        $searchModel = new ServiceSearch();
        $dataProvider = $searchModel->searchCombo(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Service model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'combo';
        $model = $this->findModel($id);
        $searchModel = new ServiceProductSearch();
        // Service combo
        if ($model->service_type_id == 2) {
            $serviceCombos = ServiceMix::findAll(['service_mix_id' => $id]);
            $service_ids = [];
            foreach ($serviceCombos as $serviceCombo) {
                $service_ids[] = $serviceCombo->service_id;
            }
            // Tìm các sản phẩm  theo service combo

            $dataProvider = $searchModel->searchByServiceCombo($service_ids);
        } else {
            $dataProvider = $searchModel->searchByService($id);
        }

        // Tất cả service
        $searchModelService = new ServiceMixSearch();
        $dataProviderService = $searchModelService->searchByService($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'dataProviderService' => $dataProviderService,
        ]);
    }

    /**
     * Creates a new Service model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'combo';
        $model = new Service();

        $model->status = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Service model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'combo';
        $model = $this->findModel($id);

        $searchModel = new ServiceProductSearch();
        // Service combo
        if ($model->service_type_id == 2) {
            $serviceCombos = ServiceMix::findAll(['service_mix_id' => $id]);
            $service_ids = [];
            foreach ($serviceCombos as $serviceCombo) {
                $service_ids[] = $serviceCombo->service_id;
            }
            // Tìm các sản phẩm  theo service combo

            $dataProvider = $searchModel->searchByServiceCombo($service_ids);
        } else {
            $dataProvider = $searchModel->searchByService($id);
        }

        // Tất cả service
        $searchModelService = new ServiceMixSearch();
        $dataProviderService = $searchModelService->searchByService($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'dataProviderService' => $dataProviderService,
        ]);
    }

    /**
     * Deletes an existing Service model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);

        $model->status = Common::STATUS_DELETED;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Service model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Service the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Service::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionImportExcel()
    {
        $inputFile = 'upload/service.xls';
        try {
            $inputFileType = \PHPExcel_IPFactory::indentify($inputFile);
        } catch (Exception $e) {
            die('Error');
        }
    }

    public function actionInfo()
    {
        if (Yii::$app->request->isAjax) {

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $service_id = Yii::$app->request->post('service_id');

            //$service_combo = Yii::$app->request->post('service_combo');

            if ($service_id) {
                $service = Service::findOne($service_id);
                if ($service) {
                    if ($service->serviceType->slug == 'combo') {
                        // Tìm các dịch vụ trong combo
                        $services = ServiceMix::findAll(['service_mix_id'=>$service_id]);
                        $detail = '';
                        foreach ($services as $model) {
                            $value = 1;

                            $detail .= "<tr>";
                            $detail .= "<td>".$model->service->slug." </td>";
                            $detail .= "<td>".$model->service->name." </td>";
                            $detail .= "<td><input type='text' class='form-control' name='CustomerHistoryService[services][" . $model->service->id . "]' value='0' /></td>";
                            $detail .= "<td>" . Yii::$app->formatter->asCurrency($model->service->retail_price, 'VND') . "  </td>";
                            $detail .= "<td>".$model->service->duration." </td>";
                            $detail .= "</tr>";
                        }
                    } else {
                        $detail = "<p>Mã dịch vụ: $service->slug </p>";
                        $detail .= "<p>Tên dịch vụ: $service->name </p>";
                        $detail .= "<p>Mô tả: $service->description </p>";
                        $detail .= "<p>Trong $service->duration phút </p>";
                        $detail .= "<p>Giá : " . Yii::$app->formatter->asCurrency($service->retail_price, 'VND') . " </p>";

                    }

                    return array(
                        'service_type' => $service->serviceType->slug,
                        'total_price' => $service->retail_price,
                        'detail' => $detail,
                    );
                }

            }
            return [];
        }
        // TODO xử lý khi gọi trực tiếp
    }

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
        }
    }

    // Remove product
    public function actionRemove($id, $product_id)
    {
        if ($id) {
            $serviceProduct = ServiceProduct::find()->where(['service_id' => $id, 'product_id' => $product_id])->one();

            if ($serviceProduct && $serviceProduct->delete()) {
                $service = Service::findOne($id);
                $service->calculate();
                $this->redirect(['view', 'id' => $id]);
            }
        }
    }

    public function actionAddProduct()
    {
        $model = new AddServiceProductForm();
        $model->service_id = Yii::$app->request->post('service_id');
        $model->productIds = (array)Yii::$app->request->post('id');
        if ($model->addProductToService()) {

        } else {

        }
        $this->redirect(['view', 'id' => $model->service_id]);
    }

    public function actionUpdateProduct()
    {
        if (Yii::$app->request->isAjax) {
            $model = new AddServiceProductForm();
            $model->service_id = Yii::$app->request->post('service_id');
            $model->productId = Yii::$app->request->post('productid');
            $model->amount = Yii::$app->request->post('amount');
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model->updateProductToService();
        }
        $this->redirect(['view', 'id' => $model->service_id]);
    }

    public function actionFindService($id)
    {
        if ($id) {
            if (Yii::$app->request->isAjax) {
                $searchModel = new ServiceSearch();
                $dataProvider = $searchModel->searchForCombo(Yii::$app->request->queryParams);
                $dataProvider->pagination->pageSize = 500;

                return $this->renderAjax('_form_add_service', [
                    'id' => $id,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            } else {
                $this->redirect(['view', 'id' => $id]);
            }

        }
    }

    public function actionAddService()
    {
        $model = new AddServiceComboForm();
        $model->service_mix_id = Yii::$app->request->post('service_mix_id');
        $model->service_ids = (array)Yii::$app->request->post('id');
        if ($model->addServiceCombo()) {
            // TODO alert message
        } else {

        }
        $this->redirect(['view', 'id' => $model->service_mix_id]);
    }

    public function actionUpdateService()
    {
        if (Yii::$app->request->isAjax) {
            $model = new AddServiceComboForm();
            $model->service_id = Yii::$app->request->post('service_id');
            $model->service_mix_id = Yii::$app->request->post('service_mix_id');
            $model->amount = Yii::$app->request->post('amount');
            $model->updateServiceCombo();
            //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }
        $this->redirect(['view', 'id' => $model->service_mix_id]);
    }

    // Remove product
    public function actionRemoveService($id, $service_id)
    {
        if ($id) {
            $serviceMix = ServiceMix::find()->where(['service_mix_id' => $id, 'service_id' => $service_id])->one();

            if ($serviceMix && $serviceMix->delete()) {
                $service = Service::findOne($id);
                $service->calculateCombo();
                $this->redirect(['view', 'id' => $id]);
            }
        }
    }



    public function actionInfos()
    {
        if (Yii::$app->request->isAjax) {

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $serviceIds = Yii::$app->request->post('serviceIds');


            if ($serviceIds) {
                $service_ids = explode(',',$serviceIds);
                $detail = '';
                foreach ($service_ids as $service_id){
                    $service = Service::findOne($service_id);
                    if ($service) {

                        $detail .= "<tr>";
                        $detail .= "<td>".$service->slug." </td>";
                        $detail .= "<td>".$service->name." </td>";
                        $detail .= "<td><input type='text' class='form-control' name='CustomerHistory[services][" . $service->id . "][used_at]' value='' /></td>";
                        $detail .= "<td><input type='text' class='form-control' name='CustomerHistory[services][" . $service->id . "][amount]' value='1' /></td>";
                        $detail .= "<td>" . Yii::$app->formatter->asCurrency($service->retail_price, 'VND') . "  </td>";
                        $detail .= "<td>".$service->duration." </td>";
                        $detail .= "</tr>";
                    }
                }
                return array(
                    'detail' => $detail,
                );
            }
            return [];
        }
        // TODO xử lý khi gọi trực tiếp
    }


    /**
     * Your controller action to fetch the list
     */
    public function actionList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name AS text')
                ->from('service')
                ->where(['like', 'name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Service::find($id)->name];
        }
        return $out;
    }


    public function actionActivityInfos()
    {
        if (Yii::$app->request->isAjax) {

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $serviceIds = Yii::$app->request->post('serviceIds');


            if ($serviceIds) {
                $service_ids = explode(',',$serviceIds);
                $detail = '';
                foreach ($service_ids as $service_id){
                    $service = Service::findOne($service_id);
                    if ($service) {

                        $detail .= "<tr>";
                        $detail .= "<td>".$service->slug." </td>";
                        $detail .= "<td>".$service->name." </td>";
                        $detail .= "<td><input type='text' class='form-control' name='Activity[services][" . $service->id . "][amount]' value='1' /></td>";
                        $detail .= "<td>" . Yii::$app->formatter->asCurrency($service->retail_price, 'VND') . "  </td>";
                        $detail .= "<td>".$service->duration." </td>";
                        $detail .= "</tr>";
                    }
                }
                return array(
                    'detail' => $detail,
                );
            }
            return [];
        }
        // TODO xử lý khi gọi trực tiếp
    }


    public function actionExport()
    {
        $model = new ExportForm();
        if (Yii::$app->request->isAjax) {
            $model->exportService();
            return $this->renderAjax('_export', [
                'model' => $model
            ]);
        }
        return false;

    }
}
