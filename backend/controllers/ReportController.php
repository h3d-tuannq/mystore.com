<?php

namespace backend\controllers;

use backend\models\ExportForm;
use backend\models\RunReportForm;
use backend\models\search\ReportEmployeeSearch;
use backend\models\search\ReportProductSearch;
use backend\models\search\ReportRevenueSearch;
use backend\models\search\ReportCustomerSearch;
use backend\models\search\ReportServiceSearch;
use common\commands\ReportCommand;
use common\models\base\ReportRevenue;
use common\models\base\ReportService;

class ReportController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new ReportRevenueSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDay()
    {
        return $this->render('day');
    }


    public function actionMonth()
    {
        $searchModel = new ReportRevenueSearch();
        $dataProvider = $searchModel->searchMonth(\Yii::$app->request->queryParams);

        return $this->render('month', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * 1. Doanh thu theo sản phẩm
     * @return mixed
     */
    public function actionProduct()
    {
        $searchModel = new ReportProductSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('product', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * 2. Doanh thu theo dịch vụ
     * @return mixed
     */
    public function actionService($code = '')
    {
        // Nếu code = '' thì hiện tất cả

        // Nếu có code
        if($code) {
            $searchModel = new ReportServiceSearch();
            $searchModel->slug = $code;
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

            return $this->render('service', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        $searchModel = new ReportServiceSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('service', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * 2. Doanh thu theo dịch vụ
     * @return mixed
     */
    public function actionServiceMonth()
    {
        $searchModel = new ReportServiceSearch();

        $dataProvider = $searchModel->searchMonth(\Yii::$app->request->queryParams);

        return $this->render('service_month', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * 3. Doanh thu theo nhân viên
     * @return mixed
     */
    public function actionEmployee()
    {
        $searchModel = new ReportEmployeeSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('employee', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCustomer($code = '')
    {
        // Nếu code = '' thì hiện tất cả

        // Nếu có code
        if($code) {
            $searchModel = new ReportCustomerSearch();
            $searchModel->slug = $code;
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

            return $this->render('customer', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        $searchModel = new ReportCustomerSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('customer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExportCustomer()
    {
        $model = new ExportForm();
        if (\Yii::$app->request->isAjax) {
            $from = \Yii::$app->request->get('from');
            $to = \Yii::$app->request->get('to');
            $customer_code = \Yii::$app->request->get('code');

            if($model->exportRevenueCustomer($customer_code,$from,$to)){
                return $this->renderAjax('_export', [
                    'model' => $model
                ]);
            }else{
                return $this->renderAjax('_error', [
                    'model' => $model
                ]);
            }
        }
        return false;

    }

	public function actionExportProduct()
	{
		$model = new ExportForm();
		if (\Yii::$app->request->isAjax) {
			$from = \Yii::$app->request->get('from');
			$to = \Yii::$app->request->get('to');
			$code = \Yii::$app->request->get('code');

			if($model->exportRevenueProduct($code,$from,$to)){
				return $this->renderAjax('_export', [
					'model' => $model
				]);
			}else{
				return $this->renderAjax('_error', [
					'model' => $model
				]);
			}
		}
		return false;

	}

    public function actionExportEmployee()
    {
        $model = new ExportForm();
        if (\Yii::$app->request->isAjax) {
            $from = \Yii::$app->request->get('from');
            $to = \Yii::$app->request->get('to');
            $employee_code = \Yii::$app->request->get('code');

            if($model->exportRevenueEmployee($employee_code,$from,$to)){
                return $this->renderAjax('_export', [
                    'model' => $model
                ]);
            }else{
                return $this->renderAjax('_error', [
                    'model' => $model
                ]);
            }
        }
        return false;

    }

    public function actionExportService()
    {
        $model = new ExportForm();
        if (\Yii::$app->request->isAjax) {
            $from = \Yii::$app->request->get('from');
            $to = \Yii::$app->request->get('to');
            $code = \Yii::$app->request->get('code');

            if($model->exportRevenueService($code,$from,$to)){
                return $this->renderAjax('_export', [
                    'model' => $model
                ]);
            }else{
                return $this->renderAjax('_error', [
                    'model' => $model
                ]);
            }
        }
        return false;

    }

    public function actionExportServiceMonth()
    {
        $model = new ExportForm();
        if (\Yii::$app->request->isAjax) {
            $year = \Yii::$app->request->get('year');
            $month = \Yii::$app->request->get('month');
            $code = \Yii::$app->request->get('code');

            if($model->exportRevenueServiceMonth($code,$year,$month)){
                return $this->renderAjax('_export', [
                    'model' => $model
                ]);
            }else{
                return $this->renderAjax('_error', [
                    'model' => $model
                ]);
            }
        }
        return false;

    }

    public function actionWeek()
    {
        $searchModel = new ReportRevenueSearch();
        $dataProvider = $searchModel->searchWeek(\Yii::$app->request->queryParams);

        return $this->render('week', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionYear()
    {
        $searchModel = new ReportRevenueSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('year', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionExport()
    {
        $model = new ExportForm();
        if (\Yii::$app->request->isAjax) {
            $from = \Yii::$app->request->get('from');
            $to = \Yii::$app->request->get('to');
            if($model->exportRevenueDay($from,$to)){
                return $this->renderAjax('_export', [
                    'model' => $model
                ]);
            }else{
                return $this->renderAjax('_error', [
                    'model' => $model
                ]);
            }
        }
        return false;

    }



    public function actionRunReport()
    {
        $model = new RunReportForm();
        if ($model->load(\Yii::$app->request->post()) && $model->run()) {
            \Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => "Đã tạo xong báo cáo"
            ]);
            //TODO hiển thị thông báo
            return $this->redirect(['index']);
        }
        return $this->render('run', [
            'model' => $model,
        ]);

    }


    /**
     * Displays a single Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReportRevenue::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
