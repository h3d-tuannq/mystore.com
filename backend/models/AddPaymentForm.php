<?php

namespace backend\models;

use common\models\base\OrderDetail;
use common\models\base\Payment;
use common\models\Common;
use common\models\Customer;
use common\models\Employee;
use common\models\Order;
use common\models\OrderPayment;
use common\models\Product;
use Yii;
use yii\base\Model;
use yii\db\Expression;

/**
 * AddPaymentForm form
 */
class AddPaymentForm extends Model
{
    public $payment;
    public $orderId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment'], 'validatePayment'],
            [['orderId'], 'safe'],
        ];
    }

    public function validatePayment()
    {
        if ($this->payment) {
            foreach ($this->payment as $pay) {
                if (!is_integer($pay)) {
                    return false;
                }
            }
        }
    }

    public function add()
    {
        $order = Order::findOne($this->orderId);
        if ($order) {
            foreach ($this->payment as $key => $pay) {
                $payment = Payment::findOne(['slug' => $key]);
                if ($payment) {
                    $orderPayment = OrderPayment::findOne(['payment_id' => $payment->id, 'order_id' => $order->id]);
                    if (!$orderPayment) {
                        $orderPayment = new OrderPayment();

                    }

                    if ($orderPayment->note) {
                        $histories = json_decode($orderPayment->note);
                    } else {
                        $histories = [];
                    }

                    $orderPayment->payment_id = $payment->id;
                    $before = $orderPayment->total_money;
                    $orderPayment->total_money = $pay;
                    $change = $pay - $before;
                    $orderPayment->order_id = $order->id;
                    $histories[] = array('updated_at'=>time(),'before' => $before, 'current' => $pay, 'change' => $change);
                    $orderPayment->note = json_encode($histories);
                    $orderPayment->save();

                    $customer = Customer::findOne($order->customer_id);
                    if ('no' == $key && $change != 0) {
                        // Ghi nợ
                        if ($change > 0) {
                            $customer->remain_money += $change;
                        } else {
                            // trả nợ
                            $customer->remain_money += $change;
                        }
                        $customer->save();
                    }
                }

            }
            return true;
        }

    }

    public
    function remove()
    {

    }

}
