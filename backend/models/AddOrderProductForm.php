<?php

namespace backend\models;

use common\commands\AddToTimelineCommand;
use common\models\base\OrderDetail;
use common\models\Common;
use common\models\Order;
use common\models\Product;
use common\models\Service;
use common\models\ServiceMix;
use common\models\ServiceProduct;
use yii\base\Model;

/**
 * ImportForm form
 */
class AddOrderProductForm extends Model
{
    public $productIds;
    public $orderId;
    public $productId;
    public $amount;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productIds'], 'safe'],
            [['orderId'], 'safe'],
            [['productId'], 'integer'],
            [['amount'], 'integer'],
        ];
    }

    public function add()
    {
        if ($this->orderId) {
            $order = Order::findOne($this->orderId);
            if ($order) {
                foreach ($this->productIds as $productId) {

                    $product = Product::findOne($productId);

                    $orderDetail = OrderDetail::findOne(['order_id' => $order->id,
                        'object_id' => $product->id,
                        'object_type' => 'product'
                    ]);
                    if ($orderDetail) {
                        $orderDetail->quantity += 1;
                    } else {
                        $orderDetail = new OrderDetail();
                        $orderDetail->quantity = 1;
                    }

                    $orderDetail->order_id = $order->id;
                    $orderDetail->object_id = $product->id;
                    $orderDetail->unit_money = $product->retail_price;
                    $orderDetail->object_type = 'product';
                    $orderDetail->total_money = $orderDetail->quantity * $orderDetail->unit_money;
                    $orderDetail->status = Common::STATUS_ACTIVE;
                    $orderDetail->save();

                    // Trừ số lượng sản phẩm
                    //if ($product && $product->quantity >= 1) {
                    if ($product) {
                        $product->quantity -= 1;
                        $product->save();
                    } else {
                        //TODO bắn notification
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
            if ($order && $this->productId) {

                $product = Product::findOne($this->productId);

                $orderDetail = OrderDetail::findOne(['order_id' => $order->id,
                    'object_id' => $product->id,
                    'object_type' => 'product'
                ]);
                if ($orderDetail) {
//                    $orderDetail->quantity += 1;
//                    $orderDetail->status = Common::STATUS_DELETED;
//                    $orderDetail->save();
                    // Trừ số lượng sản phẩm
                    $product->quantity += $orderDetail->quantity;
                    $product->save();
                    $orderDetail->delete();
                    $order->calculate();

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

                $product = Product::findOne($this->productId);

                $orderDetail = OrderDetail::findOne(['order_id' => $order->id,
                    'object_id' => $product->id,
                    'object_type' => 'product'
                ]);
                if (!$orderDetail) {
                    $orderDetail = new OrderDetail();
                    // Trừ số lượng sản phẩm
                    // FIXED
                    //if ($product && $product->quantity >= $this->amount) {
                    if ($product) {
                        // FIXED
                        $product->quantity -= $this->amount;
                        $product->save();
                    } else {
                        //TODO bắn notification
                    }
                }
                if ($this->amount) {
                    $change = $this->amount - $orderDetail->quantity;
                    $orderDetail->quantity = $this->amount;
                    $orderDetail->order_id = $order->id;
                    $orderDetail->object_id = $product->id;
                    $orderDetail->unit_money = $product->retail_price;
                    $orderDetail->object_type = 'product';
                    $orderDetail->total_money = $orderDetail->quantity * $orderDetail->unit_money;
                    $orderDetail->status = Common::STATUS_ACTIVE;
                    $orderDetail->save();
                    if ($product) {
                        //if ($product && $product->quantity >= $change) {
                        // FIXED
                        $product->quantity -= $change;
                        $product->save();
                    }
                } else {
                    $orderDetail->delete();
                    // Cộng sản phẩm khi xóa khỏi hóa đơn
                    $product->quantity += $orderDetail->quantity;
                    $product->save();
                }

                $order->calculate();
            }
        }

    }
}
