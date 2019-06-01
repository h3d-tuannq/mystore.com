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
 * ImportForm form
 */
class AddProductForm extends Model {
	public $productIds;
	public $orderId;
	public $productId;
	public $objectId;
	public $amount;

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[ [ 'productIds' ], 'safe' ],
			[ [ 'orderId' ], 'safe' ],
			[ [ 'productId' ], 'integer' ],
			[ [ 'objectId' ], 'safe' ],
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


	public function addProductToService() {
		if ( $this->objectId ) {
			$service = Service::findOne( $this->objectId );
			if ( $service ) {
				foreach ( $this->productIds as $productId ) {

					$product = Product::findOne( $productId );

					$serviceProduct = ServiceProduct::findOne(
						[
							'service_id' => $service->id,
							'product_id' => $product->id
						] );
					if ( $serviceProduct ) {
						$serviceProduct->amount += 1;
					} else {
						$serviceProduct         = new ServiceProduct();
						$serviceProduct->amount = 1;
					}

					$serviceProduct->service_id = $service->id;
					$serviceProduct->product_id = $product->id;
					$serviceProduct->unit       = $product->product_unit;
					$serviceProduct->money      = $product->input_price;
					$serviceProduct->status     = Common::STATUS_ACTIVE;
					$serviceProduct->save();
				}
				$service->calculate();
			}
		}
	}

	public function updateProductToService() {
		if ( $this->objectId ) {
			$service = Service::findOne( $this->objectId );

			if ( $service && $this->productId && $this->amount ) {
				$product = Product::findOne( $this->productId );

				$serviceProduct = ServiceProduct::findOne(
					[
						'service_id' => $service->id,
						'product_id' => $product->id
					] );


				if ( $serviceProduct ) {
					$serviceProduct->amount = $this->amount;
					$serviceProduct->unit   = $product->product_unit;
					$serviceProduct->money  = $product->input_price * $this->amount;
					$serviceProduct->status = Common::STATUS_ACTIVE;
					$serviceProduct->save();

					$service->calculate();
					return $serviceProduct->money;
				}
			}

			if($this->amount == 0 || $this->amount == '0'){
				$serviceProduct = ServiceProduct::findOne(
					[
						'service_id' => $service->id,
						'product_id' => $this->productId
					] );
				$serviceProduct->delete();
				$service->calculate();
				return $serviceProduct->money;
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
