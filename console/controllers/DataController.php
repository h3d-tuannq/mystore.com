<?php

namespace console\controllers;

use common\commands\AddToTimelineCommand;
use common\models\base\ReportProduct;
use common\models\base\ReportRun;
use common\models\base\ReportService;
use common\models\Customer;
use common\models\CustomerHistory;
use common\models\Order;
use common\models\OrderDetail;
use common\models\OrderPayment;
use common\models\ReportRevenue;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 *
 */
class DataController extends Controller
{


    /**
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionRun()
    {
        $beginOfDay = strtotime("midnight", time());
        Console::output($beginOfDay);
        Console::output(date('Y-m-d H:i:s',$beginOfDay));
        $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
        $yesterday   = strtotime("yesterday", $beginOfDay) ;
        //$this->runAction('fill-date');
        Console::output($endOfDay);
        Console::output(date('Y-m-d H:i:s',$endOfDay));
        Console::output(date('Y-m-d H:i:s',$yesterday));

        Yii::error('Done', 'Job Run');
    }


    /**
     * Chạy để thêm ngày tháng vào order detail và order payment
     */
    public function actionFillDate()
    {
        $orderDetails = OrderDetail::find()->all();
        foreach ($orderDetails as $orderDetail) {
            if ($orderDetail->order) {
                $orderDetail->created_at = $orderDetail->order->created_at;
                $orderDetail->updated_at = $orderDetail->order->updated_at;
                $orderDetail->created_by = $orderDetail->order->created_by;
                $orderDetail->updated_by = $orderDetail->order->updated_by;
                $orderDetail->save();
            }
        }

        $orderPayments = OrderPayment::find()->all();
        foreach ($orderPayments as $orderPayment) {
            if ($orderPayment->order) {
                $orderPayment->created_at = $orderPayment->order->created_at;
                $orderPayment->updated_at = $orderPayment->order->updated_at;
                $orderPayment->created_by = $orderPayment->order->created_by;
                $orderPayment->updated_by = $orderPayment->order->updated_by;
                $orderPayment->save();
            }
        }
        Console::output('Fill data ok!');
    }

}
