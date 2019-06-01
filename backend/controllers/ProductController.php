<?php

namespace backend\controllers;

use backend\models\ExportForm;
use backend\models\ImportForm;
use common\models\Common;
use common\models\ProductType;
use common\models\search\ServiceProductSearch;
use Yii;
use common\models\Product;
use common\models\search\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'combo';

        $serviceSearchModel = new ServiceProductSearch();
        $serviceSearchModel->product_id = $id;
        $serviceDataProvider = $serviceSearchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'serviceDataProvider' => $serviceDataProvider,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'combo';
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'product_types' => ProductType::find()->active()->all(),
        ]);
    }

    /**
     * Updates an existing Product model.
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
            'product_types' => ProductType::find()->active()->all(),
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        // Xóa sản phẩm thì xóa ở service product
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);

        $model->status = Common::STATUS_DELETED;
        $model->save();


        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionImport()
    {

        $model = new ImportForm();
        if (Yii::$app->request->isAjax) {
            return $this->render('import', [
                'model' => $model
            ]);
        }
        if ($model->load(Yii::$app->request->post()) && $model->importProduct()) {
            $errors = '<ul>';
            foreach ($model->results['errorSlugs'] as $errorSlug) {
                $errors .= '<li>' . $errorSlug . '</slug>';
            }
            $errors .= '</ul>';

            $new = $model->results['new'];
            $updated = $model->results['updated'];
            if($model->results['errorSlugs']){
                Yii::$app->session->setFlash('alert', [
                    'options' => ['class' => 'alert-error'],
                    'body' => "Thực hiện $model->result kết quả thành công<br/>- $new sản phẩm mới <br/>- $updated sản phẩm được cập nhật <br/>- Những mã bị lỗi " . $errors
                ]);
            }else{
                Yii::$app->session->setFlash('alert', [
                    'options' => ['class' => 'alert-success'],
                    'body' => "Thực hiện $model->result kết quả thành công<br/>- $new sản phẩm mới <br/>- $updated sản phẩm được cập nhật <br/>"
                ]);
            }
            return $this->redirect('import');
        }
        return $this->render('import', [
            'model' => $model
        ]);


    }

    public function actionExport()
    {
        $model = new ExportForm();
        if (Yii::$app->request->isAjax) {
            $model->export();
            return $this->renderAjax('_export', [
                'model' => $model
            ]);
        }
        return false;

    }

    public function actionInfos()
    {
        if (Yii::$app->request->isAjax) {

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $productIds = Yii::$app->request->post('productIds');


            if ($productIds) {
                $product_ids = explode(',', $productIds);
                $detail = '';
                foreach ($product_ids as $product_id) {
                    $product = Product::findOne($product_id);
                    if ($product) {

                        $detail .= "<tr>";
                        $detail .= "<td>" . $product->slug . " </td>";
                        $detail .= "<td>" . $product->name . " </td>";
                        $detail .= "<td><input type='text' class='form-control' name='CustomerHistory[products][" . $product->id . "][used_at]' value=''/></td>";
                        $detail .= "<td><input type='text' class='form-control' name='CustomerHistory[products][" . $product->id . "][amount]' value='1'/></td>";
                        $detail .= "<td>" . Yii::$app->formatter->asCurrency($product->retail_price, 'VND') . "  </td>";
                        //$detail .= "<td>".$product->duration." </td>";
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

    public function actionActivityInfos()
    {
        if (Yii::$app->request->isAjax) {

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $productIds = Yii::$app->request->post('productIds');
            $service_id = Yii::$app->request->post('serviceId');


            if ($productIds) {
                $product_ids = explode(',', $productIds);
                $detail = '';
                foreach ($product_ids as $product_id) {
                    $product = Product::findOne($product_id);
                    if ($product) {

                        $detail .= "<tr>";
                        $detail .= "<td>" . $product->slug . " </td>";
                        $detail .= "<td>" . $product->name . " </td>";
                        $detail .= "<td><input type='text' class='form-control' name='Activity[products][" . $service_id . "][" . $product->id . "][amount]' value='1'/></td>";
                        $detail .= "<td>" . $product->product_unit . " </td>";
                        $detail .= "<td>" . Yii::$app->formatter->asCurrency($product->retail_price, 'VND') . "<input type='hidden' class='form-control' name='Activity[products][" . $service_id . "][" . $product_id . "][money]'  value='" . $product->retail_price . "' /></td>";
                        $detail .= "<td>" . Yii::$app->formatter->asCurrency($product->retail_price, 'VND') . "  </td>";
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
}
