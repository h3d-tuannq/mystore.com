<?php

namespace backend\controllers;

use common\models\Customer;
use common\models\search\AppointmentSearch;
use yii\filters\VerbFilter;
use common\models\Appointment;
use yii\helpers\ArrayHelper;

class AppointmentController extends \yii\web\Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
//            'verbs' => [
//                'class' => VerbFilter::class,
//                'actions' => [
//                    'delete' => ['post'],
//                ],
//            ],
        ];
    }

    public function actionIndex()
    {
        $model = new Appointment();
        $this->layout = 'combo';

        $customers = ArrayHelper::map(Customer::all(),'id','text');
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'model' => $model,
            'customers' => $customers,
        ]);
    }

    public function actionList()
    {
        $searchModel = new AppointmentSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAll()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // Ngày hiện tại
        //time();
        $appointments = Appointment::find()
            //->where(['appointment_time'=>time()])
                                            ->active()->all();

        $result = [];
        foreach ($appointments as $appointment){
            $title = '';
            $description = '<h3>';
            if($appointment->customer){
                $title .= $appointment->customer->slug ;
                $description .= 'KH: '. $appointment->customer->name ;
            }
            if($appointment->service){
                $title .= ' - ' . $appointment->service->name;
                $description .= "<br/>Dịch vụ: " . $appointment->service->name;
            }

//            if($appointment->number_customer){
//                $title .= ' - ' . $appointment->number_customer . 'người';
//            }

            if($appointment->phone){
                $title .= "\nĐiện thoại: " . $appointment->phone;
            }
            if($appointment->note){
                $title .= "\nGhi chú: " . $appointment->note;
            }

            if($appointment->appointment_time){
                $description .= "<br/>Lịch hẹn ngày " . date('d-m-Y',$appointment->appointment_time);
                $description .= "<br/>Từ " . date('H:i',$appointment->appointment_time);
                if($appointment->end_time) {
                    $description .= " đến " . date('H:i', $appointment->end_time);
                }
            }

            $description .= "</h3>";
	        $result[] = array(
		        'title' => $title,
                'resourceId' => $appointment->employee_id,
		        'start' =>  date('Y-m-d H:i:s',$appointment->appointment_time),
		        'end' =>  date('Y-m-d H:i:s',$appointment->end_time),
		        'appointment_id' =>  $appointment->id,
		        'description' =>  $description,
	        );
        }
        return $result;
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

    public function actionCreate()
    {
        $customers = ArrayHelper::map(Customer::all(),'id','text');
        $model = new Appointment();

        $start = \Yii::$app->request->get('start');
        $end = \Yii::$app->request->get('end');
        $start = $start/1000;
        $end = $end/1000;
        $model->appointment_time = date('d-m-Y H:i:s',$start);
        $model->end_time = date('d-m-Y H:i:s',$end);
        $model->employee_id = \Yii::$app->request->get('employee');

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,'customers' => $customers,
            ]);
        }


        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,'customers' => $customers,
        ]);
    }

    /**
     * Deletes an existing Appointment model.
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
     * Finds the Appointment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Appointment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Appointment::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Updates an existing Card model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $customers = ArrayHelper::map(Customer::all(),'id','text');
        $model = $this->findModel($id);
        $model->appointment_time = date('d-m-Y H:i:s',$model->appointment_time);
        $model->end_time = date('d-m-Y H:i:s',$model->end_time);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
            'customers' => $customers,
        ]);
    }
}
