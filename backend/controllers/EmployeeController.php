<?php

namespace backend\controllers;

use backend\models\ExportForm;
use backend\models\ImportForm;
use common\models\EmployeePlan;
use common\models\Customer;
use common\models\Employee;
use common\models\EmployeeTimesheet;
use common\models\search\ActivitySearch;
use common\models\search\EmployeeSearch;
use common\models\search\ServiceProductSearch;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
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
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSalary()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('salary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Employee model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'combo';

        $searchModel = new ActivitySearch();
        $searchModel->employee_id = $id;
        $serviceDataProvider = $searchModel->searchEmployee(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'serviceDataProvider' => $serviceDataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'combo';
        $model = new Employee();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Employee model.
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
     * Deletes an existing Employee model.
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
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionImport(){

        $model = new ImportForm();
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_import', [
                'model' => $model
            ]);
        }
        if ($model->load(Yii::$app->request->post()) && $model->import()) {
            return $this->renderAjax('_success', [
                'model' => $model
            ]);
        }else if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_import', [
                'model' => $model
            ]);
        }

    }

    /**
     * planning for employees
     * @return mixed
     */
    public function actionPlan()
    {
        $this->layout = 'combo';
        return $this->render('plan',
            [
                'employees' => Employee::find()->active()->all()
            ]
        );
    }

    public function actionAllPlan()
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
                'backgroundColor' => $timesheet->status == EmployeeTimesheet::STATUS_OFF? 'red':'green',

            );
        }
        return $result;
    }

    // Tạo mới plan
    public function actionCreatePlan()
    {
        $customers = ArrayHelper::map(Customer::all(), 'id', 'text');
        $model = new EmployeePlan();
        if (\Yii::$app->request->isAjax) {
            $start = \Yii::$app->request->get('start');
            if ($start) {
                $start = $start / 1000;
                $startHour = date('H', $start);
                if ($startHour < 8 || $startHour > 9) {
                    $model->start_time = '08:00 AM';
                } else {
                    $model->start_time = date('H:i:s', $start);
                }

            }

            $end = \Yii::$app->request->get('end');
            if ($end) {
                $end = $end / 1000;

                $endHour = date('H', $end);
                if ($endHour > 21 || $endHour < 19) {
                    $model->end_time = '21:00';
                } else {
                    $model->end_time = date('H:i:s', $end);
                }
            }
            $model->plan_date = date('d-m-Y', $start);
            $model->employee_id = \Yii::$app->request->get('employee');
            return $this->renderAjax('_form_plan', [
                'model' => $model, 'customers' => $customers,
            ]);
        }
        if ($model->load(\Yii::$app->request->post())) {
            $model->plan_date = date('Y-m-d', strtotime($model->plan_date));
            if ($model->off) {
                $model->status = EmployeePlan::STATUS_OFF;
            }
            if ($model->save()) {
                return $this->redirect(['plan']);
            } else {
                var_dump($model->getErrors());
                die;
            }
        }
        return $this->render('create', [
            'model' => $model, 'customers' => $customers,
        ]);
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

    /**
     * Lists all Employee models.
     * @return mixed
     */
    public function actionOvertime()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Employee models.
     * @return mixed
     */
    public function actionRate()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionExportService()
    {
        $model = new ExportForm();
        if (\Yii::$app->request->isAjax) {
            $from = \Yii::$app->request->get('from');
            $to = \Yii::$app->request->get('to');
            $id = \Yii::$app->request->get('id');

            if($model->exportEmployeeService($id,$from,$to)){
                return $this->renderAjax('/common/_export', [
                    'model' => $model
                ]);
            }else{
                return $this->renderAjax('/common/_error', [
                    'model' => $model
                ]);
            }
        }
        return false;

    }
}
