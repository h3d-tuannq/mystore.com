<?php

namespace backend\controllers;

use common\models\Customer;
use common\models\Employee;
use common\models\Order;
use common\models\Service;

class DashboardController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'combo';
        return $this->render('index',[
            'countOrder' => Order::find()->count(),
            'countCustomer' => Customer::find()->count(),
            'countEmployee' => Employee::find()->count(),
            'countService' => Service::find()->count(),
        ]);
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
}
