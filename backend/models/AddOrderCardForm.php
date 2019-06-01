<?php

namespace backend\models;

use common\models\base\OrderDetail;
use common\models\Card;
use common\models\Common;
use common\models\Order;
use common\models\ServiceCard;
use yii\base\Model;

/**
 * ImportForm form
 */
class AddOrderCardForm extends Model
{
    public $cardIds;
    public $orderId;
    public $cardId;
    public $amount;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cardIds'], 'safe'],
            [['orderId'], 'safe'],
            [['cardId'], 'integer'],
            [['amount'], 'integer'],
        ];
    }

    public function add()
    {
        if ($this->orderId) {
            $order = Order::findOne($this->orderId);
            if ($order) {
                foreach ($this->cardIds as $cardId) {

                    $card = Card::findOne($cardId);

                    $orderDetail = OrderDetail::findOne(['order_id' => $order->id,
                        'object_id' => $card->id,
                        'object_type' => 'card'
                    ]);
                    if ($orderDetail) {
                        $orderDetail->quantity += 1;
                    } else {
                        $orderDetail = new OrderDetail();
                        $orderDetail->quantity = 1;
                    }

                    $orderDetail->order_id = $order->id;
                    $orderDetail->object_id = $card->id;
                    $orderDetail->unit_money = $card->retail_price;
                    $orderDetail->object_type = 'card';
                    $orderDetail->total_money = $orderDetail->quantity * $orderDetail->unit_money;
                    $orderDetail->status = Common::STATUS_ACTIVE;
                    $orderDetail->save();
                }
                $order->calculate();
                return true;
            }
        }

    }

    public function remove()
    {
        if ($this->orderId) {
            $order = Order::findOne($this->orderId);
            if ($order && $this->cardId) {

                $card = Card::findOne($this->cardId);

                $orderDetail = OrderDetail::findOne(['order_id' => $order->id,
                    'object_id' => $card->id,
                    'object_type' => 'card'
                ]);
                if ($orderDetail) {
                    $orderDetail->quantity += 1;
                    $orderDetail->status = Common::STATUS_DELETED;
                    $orderDetail->save();
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

                $card = Card::findOne($this->cardId);

                $orderDetail = OrderDetail::findOne(['order_id' => $order->id,
                    'object_id' => $card->id,
                    'object_type' => 'card'
                ]);
                if (!$orderDetail) {
                    $orderDetail = new OrderDetail();
                }
                if ($this->amount) {
                    $orderDetail->quantity = $this->amount;
                    $orderDetail->order_id = $order->id;
                    $orderDetail->object_id = $card->id;
                    $orderDetail->unit_money = $card->retail_price;
                    $orderDetail->object_type = 'card';
                    $orderDetail->total_money = $orderDetail->quantity * $orderDetail->unit_money;
                    $orderDetail->status = Common::STATUS_ACTIVE;
                    $orderDetail->save();

                } else {
                    $orderDetail->delete();
                }
                $order->calculate();
            }
        }

    }
}
