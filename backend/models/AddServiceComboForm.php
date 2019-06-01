<?php

namespace backend\models;

use common\models\base\OrderDetail;
use common\models\Common;
use common\models\Order;
use common\models\Product;
use common\models\Service;
use common\models\ServiceMix;
use common\models\ServiceProduct;
use yii\base\Model;

/**
 *
 */
class AddServiceComboForm extends Model {
	public $service_mix_id;
	public $service_id;
	public $service_ids;
	public $amount;

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[ [ 'service_mix_id' ], 'safe' ],
			[ [ 'service_id' ], 'safe' ],
			[ [ 'service_ids' ], 'safe' ],
			[ [ 'amount' ], 'integer' ],
		];
	}

	public function add() {
		if ( $this->amount && $this->validate( 'amount' ) ) {
			if ( $this->orderId ) {
				$order = Order::findOne( $this->orderId );
				if ( $order ) {
					foreach ( $this->productIds as $productId ) {

						$product = Product::findOne( $productId );

						$orderDetail = OrderDetail::findOne( [ 'order_id'    => $order->id,
						                                       'object_id'   => $product->id,
						                                       'object_type' => 'product'
						] );
						if ( $orderDetail ) {
							$orderDetail->quantity += 1;
						} else {
							$orderDetail           = new OrderDetail();
							$orderDetail->quantity = 1;
						}

						$orderDetail->order_id    = $order->id;
						$orderDetail->object_id   = $product->id;
						$orderDetail->unit_money  = $product->retail_price;
						$orderDetail->object_type = 'product';
						$orderDetail->total_money = $orderDetail->quantity * $orderDetail->unit_money;
						$orderDetail->status      = Common::STATUS_ACTIVE;
						$orderDetail->save();
					}
					$order->calculate();
				}
			}
		} else {
			return $this->getErrors( 'amount' );
		}
	}

	public function remove() {
		if ( $this->orderId ) {
			$order = Order::findOne( $this->orderId );
			if ( $order && $this->productId ) {

				$product = Product::findOne( $this->productId );

				$orderDetail = OrderDetail::findOne( [ 'order_id'    => $order->id,
				                                       'object_id'   => $product->id,
				                                       'object_type' => 'product'
				] );
				if ( $orderDetail ) {
					$orderDetail->quantity += 1;
					$orderDetail->status   = Common::STATUS_DELETED;
					$orderDetail->save();
					$order->calculate();

					return true;
				}
			}
		}

		return false;
	}


	public function addServiceCombo() {
		if ( $this->service_mix_id ) {

			$serviceCombo = Service::findOne( $this->service_mix_id );
			if ( $serviceCombo ) {

				foreach ( $this->service_ids as $service_id ) {

                    $service = Service::findOne( $service_id );

					$serviceMix = ServiceMix::findOne(
						[
							'service_mix_id' =>  $this->service_mix_id,
							'service_id' => $service_id
						] );
					if ( $serviceMix ) {
                        $serviceMix->amount += 1;
					} else {
                        $serviceMix         = new ServiceMix();
                        $serviceMix->amount = 1;
					}

                    $serviceMix->service_mix_id = $serviceCombo->id;
                    $serviceMix->service_id = $service->id;
                    $serviceMix->money      = $service->total_price * $serviceMix->amount;
                    $serviceMix->status     = Common::STATUS_ACTIVE;
                    $serviceMix->save();
                    //var_dump($serviceMix->getErrors());die;
				}
                $serviceCombo->calculateCombo();
				return true;
			}
		}
		return false;
	}

	public function updateServiceCombo() {
		if ( $this->service_mix_id ) {
            $serviceCombo = Service::findOne( $this->service_mix_id );
            if($serviceCombo && $this->service_id) {


                if ($this->amount) {
                    $service = Service::findOne( $this->service_id );
                    $serviceMix = ServiceMix::findOne(
                        [
                            'service_mix_id' => $this->service_mix_id,
                            'service_id' => $this->service_id
                        ]);


                    if ($serviceMix) {
                        $serviceMix->amount = $this->amount;
                        $serviceMix->money = $service->total_price * $this->amount;
                        $serviceMix->status = Common::STATUS_ACTIVE;
                        $serviceMix->save();

                        $serviceCombo->calculateCombo();
                        return $serviceMix->money;

                    }
                }

                if ($this->amount == 0 || $this->amount == '0') {
                    $serviceMix = ServiceMix::findOne(
                        [
                            'service_mix_id' => $this->service_mix_id,
                            'service_id' => $this->service_id
                        ]);

                    $serviceMix->delete();
                    $serviceCombo->calculateCombo();
                    return true;
                }
            }
		}

		return false;
	}

	public function addServiceToService() {
		if ( $this->objectId ) {
			$service = Service::findOne( $this->objectId );
			if ( $service ) {

				foreach ( $this->productIds as $serviceId ) {
					$serviceSub = Service::findOne( $serviceId );

					$serviceCombo = ServiceMix::findOne(
						[
							'service_mix_id' => $service->id,
							'service_id'     => $serviceId
						] );

					if ( $serviceCombo ) {
						$serviceCombo->amount += 1;
					} else {
						$serviceCombo         = new ServiceMix();
						$serviceCombo->amount = 1;
					}

					$serviceCombo->service_mix_id = $service->id;
					$serviceCombo->service_id     = $serviceId;
					$serviceCombo->money          = $serviceSub->retail_price;
					$serviceCombo->status         = Common::STATUS_ACTIVE;
					$serviceCombo->save();
				}

				$service->calculateCombo();
			}
		}
	}

}
