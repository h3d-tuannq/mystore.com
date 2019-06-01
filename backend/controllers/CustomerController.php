<?php

namespace backend\controllers;

use backend\models\BuyForm;
use backend\models\ImportForm;
use common\models\base\CustomerService;
use common\models\base\CustomerServiceQuery;
use common\models\search\CustomerHistoryCardSearch;
use common\models\search\CustomerHistorySearch;
use common\models\search\CustomerHistoryServiceSearch;
use common\models\search\CustomerServiceSearch;
use common\models\search\OrderSearch;
use Yii;
use common\models\Customer;
use common\models\search\CustomerSearch;
use yii\db\Query;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'combo';

        $serviceSearchModel = new CustomerHistoryServiceSearch();
        $serviceDataProvider = $serviceSearchModel->searchByCustomer($id, Yii::$app->request->queryParams);

        $cardSearchModel = new CustomerHistoryCardSearch();
        $cardDataProvider = $cardSearchModel->searchByCustomer($id, Yii::$app->request->queryParams);

        $searchModel = new CustomerHistorySearch();
        $dataProvider = $searchModel->searchByCustomer($id, Yii::$app->request->queryParams);

        $cSearchModel = new CustomerHistorySearch();
        $cDataProvider = $cSearchModel->searchCardByCustomer($id, Yii::$app->request->queryParams);

        $oSearchModel = new OrderSearch();
        $oDataProvider = $oSearchModel->searchByCustomer($id, Yii::$app->request->queryParams);

        $csSearchModel = new CustomerServiceSearch();
        $csDataProvider = $csSearchModel->search($id, Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'serviceDataProvider' => $serviceDataProvider,
            'cardDataProvider' => $cardDataProvider,
            'dataProvider' => $dataProvider,
            'cDataProvider' => $cDataProvider,
            'oDataProvider' => $oDataProvider,
            'csDataProvider' => $csDataProvider,
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'combo';
        $model = new Customer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Customer model.
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
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Your controller action to fetch the list
     */
    public function actionList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(['id', 'concat(slug," - ",name) as text'])
                ->from('customer')
                 ->where(['like', 'name', $q])
                ->orWhere(['like', 'slug', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => City::find($id)->name];
        }
        return $out;
    }

    public function actionImport()
    {

        $model = new ImportForm();
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_import', [
                'model' => $model
            ]);
        }
        if ($model->load(Yii::$app->request->post()) && $model->importCustomer()) {
            return $this->renderAjax('_success', [
                'model' => $model
            ]);
        } else if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_import', [
                'model' => $model
            ]);
        }

    }

    public function actionBuy($customer_id)
    {

        $model = new BuyForm();
        $model->customer_id = $customer_id;
        if ($model->load(Yii::$app->request->post()) && $model->buy()) {
            return $this->redirect(['view', 'id' => $customer_id]);
        }
        return $this->render('buy', [
            'model' => $model
        ]);
    }

    /**
     * Công nợ khách hàng
     * @return mixed
     */
    public function actionReport()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
