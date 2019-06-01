<?php

namespace backend\models;

use common\models\base\OrderDetail;
use common\models\Common;
use common\models\CustomerHistory;
use common\models\Order;
use common\models\Service;
use common\models\Serviceservice;
use yii\base\Model;

/**
 * ImportForm form
 */
class AddOrderServiceForm extends Model
{
    public $serviceIds;
    public $orderId;
    public $serviceId;
    public $amount;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['serviceIds'], 'safe'],
            [['orderId'], 'safe'],
            [['serviceId'], 'integer'],
            [['amount'], 'integer'],
        ];
    }

    public function add()
    {
        if ($this->orderId) {
            $order = Order::findOne($this->orderId);
            if ($order) {
                foreach ($this->serviceIds as $serviceId) {

                    $service = Service::findOne($serviceId);

                    $orderDetail = OrderDetail::findOne(['order_id' => $order->id,
                        'object_id' => $service->id,
                        'object_type' => 'service'
                    ]);
                    if ($orderDetail) {
                        $orderDetail->quantity += 1;
                    } else {
                        $orderDetail = new OrderDetail();
                        $orderDetail->quantity = 1;
                    }

                    $orderDetail->order_id = $order->id;
                    $orderDetail->object_id = $service->id;
                    $orderDetail->unit_money = $service->retail_price;
                    $orderDetail->object_type = 'service';
                    $orderDetail->total_money = $orderDetail->quantity * $orderDetail->unit_money;
                    $orderDetail->status = Common::STATUS_ACTIVE;
                    $orderDetail->save();

                    // Lưu vào customer_history
                    if ($service) {
                        // Combo
                        if ('combo' == $service->serviceType->slug) {
                            $customerHistory = new CustomerHistory();
                            $customerHistory->customer_id = $order->customer_id;
                            $customerHistory->started_date = date('Y-m-d');
                            $customerHistory->object_id = $service->id;
                            $customerHistory->object_type = 'service_combo';
                            $customerHistory->amount = $service->number_serve;
                            $customerHistory->sub = 0;
                            $customerHistory->remain = $service->number_serve;
                            $customerHistory->save();
                        } else {
                            // Kiểu dịch vụ Khác
                            //Lưu CustomerHistory vào bảng customer_history, nếu có thì lấy history_id
                            $customerHistory = CustomerHistory::find()
                                ->where([
                                    'customer_id' => $order->customer_id,
                                    'object_type' => 'service',
                                    'object_id' => $service->id])
                                ->andWhere(['>', 'remain', 0])
                                ->one();
                            if($customerHistory){
                                $customerHistory->amount += 1;
                                $customerHistory->remain += 1;
                            }else{
                                $customerHistory = new CustomerHistory();
                                $customerHistory->amount = 1;
                                $customerHistory->remain = 1;
                                $customerHistory->sub = 0;
                                $customerHistory->object_type = 'service';
                                $customerHistory->object_id = $service->id;
                                $customerHistory->customer_id = $order->customer_id;
                            }
                            if($customerHistory->data){
                                $histories = json_decode($customerHistory->data);
                            }else{
                                $histories = [];
                            }
                            $histories[] = array('updated_at'=>time(),
                                'before_order_id'=>$customerHistory->order_id,
                                'current_order_id'=>$order->id);
                            $customerHistory->data = json_encode($histories);
                            $customerHistory->order_id = $order->id;
                            $customerHistory->started_date = date('Y-m-d');
                            $customerHistory->save();
                            \Yii::error('Tạo lịch sử cho dịch vụ lẻ', 'Order');

                        }
                    }

                }
                $order->calculate();
            }
        }

    }

    public function remove()
    {
        if ($this->orderId) {
            $order = Order::findOne($this->orderId);
            if ($order && $this->serviceId) {

                $service = service::findOne($this->serviceId);

                $orderDetail = OrderDetail::findOne(['order_id' => $order->id,
                    'object_id' => $service->id,
                    'object_type' => 'service'
                ]);
                if ($orderDetail) {
                    $orderDetail->quantity += 1;
                    $orderDetail->status = Common::STATUS_DELETED;
                    $orderDetail->save();
                    $order->calculate();

                    //Xóa
                    // Kiểu dịch vụ Khác
                    //Lưu CustomerHistory vào bảng customer_history, nếu có thì lấy history_id
                    $customerHistory = CustomerHistory::find()
                        ->where([
                            'customer_id' => $order->customer_id,
                            'object_type' => 'service',
                            'object_id' => $service->id])
                        ->andWhere(['>', 'remain', 0])
                        ->one();
                    if($customerHistory) {
                        $customerHistory->amount -= $orderDetail->quantity;
                        if($customerHistory->amount < 0){
                            $customerHistory->amount = 0;
                        }
                        $customerHistory->remain -= $orderDetail->quantity;
                        if($customerHistory->remain < 0){
                            $customerHistory->remain = 0;
                        }
                        if ($customerHistory->data) {
                            $histories = json_decode($customerHistory->data);
                        } else {
                            $histories = [];
                        }
                        $histories[] = array('updated_at' => time(),
                            'before_order_id' => $customerHistory->order_id,
                            'current_order_id' => $order->id,
                            'amount' => $this->amount,
                            'before_quantity' => $orderDetail->quantity,
                            'change' => $orderDetail->quantity,
                        );
                        $customerHistory->data = json_encode($histories);
                        $customerHistory->order_id = $order->id;
                        $customerHistory->started_date = date('Y-m-d');
                        $customerHistory->save();
                    }
                    \Yii::error('Cập nhật lịch sử cho dịch vụ lẻ', 'Order');
                    return true;
                }
            }
        }

        return false;
    }

    public function update()
    {
        if ($this->orderId) {
            $order = Order::findOne($this->orderId);
            if ($order) {

                $service = Service::findOne($this->serviceId);

                $orderDetail = OrderDetail::findOne(['order_id' => $order->id,
                    'object_id' => $service->id,
                    'object_type' => 'service'
                ]);
                if (!$orderDetail) {
                    $orderDetail = new OrderDetail();
                }
                if ($this->amount) {
                    $change = $this->amount - $orderDetail->quantity;
                    $orderDetail->quantity = $this->amount;
                    $orderDetail->order_id = $order->id;
                    $orderDetail->object_id = $service->id;
                    $orderDetail->unit_money = $service->retail_price;
                    $orderDetail->object_type = 'service';
                    $orderDetail->total_money = $orderDetail->quantity * $orderDetail->unit_money;
                    $orderDetail->status = Common::STATUS_ACTIVE;
                    $orderDetail->save();

                    // Lưu vào customer_history
                    if ($service and $change != 0) {
                        // Combo
                        if ('combo' == $service->serviceType->slug) {
//                            $customerHistory = new CustomerHistory();
//                            $customerHistory->customer_id = $order->customer_id;
//                            $customerHistory->object_id = $service->id;
//                            $customerHistory->object_type = 'service_combo';
//                            $customerHistory->amount = $service->number_serve;
//                            $customerHistory->sub = 0;
//                            $customerHistory->remain = $service->number_serve;
//                            $customerHistory->save();
                        } else {
                            // Kiểu dịch vụ Khác
                            //Lưu CustomerHistory vào bảng customer_history, nếu có thì lấy history_id
                            $customerHistory = CustomerHistory::find()
                                ->where([
                                    'customer_id' => $order->customer_id,
                                    'object_type' => 'service',
                                    'object_id' => $service->id])
                                ->andWhere(['>', 'remain', 0])
                                ->one();
                            if($customerHistory){
                                $customerHistory->amount += $change;
                                $customerHistory->remain += $change;
                            }else{
                                $customerHistory = new CustomerHistory();
                                $customerHistory->amount = $change;
                                $customerHistory->remain = $change;
                                $customerHistory->sub = 0;
                                $customerHistory->object_type = 'service';
                                $customerHistory->object_id = $service->id;
                                $customerHistory->customer_id = $order->customer_id;
                            }
                            if($customerHistory->data){
                                $histories = json_decode($customerHistory->data);
                            }else{
                                $histories = [];
                            }
                            $histories[] = array('updated_at' => time(),
                                'before_order_id' => $customerHistory->order_id,
                                'current_order_id' => $order->id,
                                'amount' => $this->amount,
                                'before_quantity' => $orderDetail->quantity,
                                'change' => $change,
                            );
                            $customerHistory->data = json_encode($histories);
                            $customerHistory->order_id = $order->id;
                            $customerHistory->started_date = date('Y-m-d');
                            $customerHistory->save();
                            \Yii::error('Tạo lịch sử cho dịch vụ lẻ', 'Order');

                        }
                    }

                } else {
                    //Xóa
                    // Kiểu dịch vụ Khác
                    //Lưu CustomerHistory vào bảng customer_history, nếu có thì lấy history_id
                    $customerHistory = CustomerHistory::find()
                        ->where([
                            'customer_id' => $order->customer_id,
                            'object_type' => 'service',
                            'object_id' => $service->id])
                        ->andWhere(['>', 'remain', 0])
                        ->one();
                    if($customerHistory) {
                        $customerHistory->amount -= $orderDetail->quantity;
                        $customerHistory->remain -= $orderDetail->quantity;

                        if ($customerHistory->data) {
                            $histories = json_decode($customerHistory->data);
                        } else {
                            $histories = [];
                        }
                        $histories[] = array('updated_at' => time(),
                            'before_order_id' => $customerHistory->order_id,
                            'current_order_id' => $order->id,
                            'amount' => $this->amount,
                            'before_quantity' => $orderDetail->quantity,
                            'change' => $orderDetail->quantity,
                        );
                        $customerHistory->data = json_encode($histories);
                        $customerHistory->order_id = $order->id;
                        $customerHistory->started_date = date('Y-m-d');
                        $customerHistory->save();
                    }
                    \Yii::error('Cập nhật lịch sử cho dịch vụ lẻ', 'Order');
                    $orderDetail->delete();
                }
                $order->calculate();
            }
        }

    }
}
