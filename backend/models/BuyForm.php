<?php

namespace backend\models;

use cheatsheet\Time;
use common\models\base\CustomerHistoryDetail;
use common\models\base\CustomerService;
use common\models\Customer;
use common\models\CustomerHistory;
use common\models\Service;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\web\ForbiddenHttpException;

/**
 * Login form
 */
class BuyForm extends Model
{
    public $customer_id;
    public $service_id;
    public $amount;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_id', 'amount'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service_id' => Yii::t('backend', 'Dịch vụ'),
            'amount' => Yii::t('backend', 'Số lượng'),
        ];
    }


    public function buy()
    {
        if (!$this->validate()) {
            return false;
        }

        $customerService = new CustomerService();
        $customerService->customer_id = $this->customer_id;
        $customerService->service_id = $this->service_id;
        $customerService->status = $this->amount;
        $customerService->save();

        // Trừ tiền
        $customer = Customer::findOne($this->customer_id);
        $service = Service::findOne($this->service_id);
        if ($customer && $service) {
            $totalMoney = $service->retail_price * $this->amount;
            if ($customer->account_money < $totalMoney) {
                \Yii::$app->session->setFlash('alert', [
                    'options' => ['class' => 'alert-danger'],
                    'body' => "Tài khoản khách hàng không đủ tiền"
                ]);
                return false;
            } else {
                $raw = $customer->account_money;
                $customer->account_money -= $totalMoney;
                $customer->save();

                // Lưu lịch sử sử dụng thẻ
                $model = new CustomerHistory();
                $model->customer_id = $this->customer_id;
                $model->amount = $raw;
                $model->sub += $totalMoney;
                $model->remain = $totalMoney;
                $model->save();
                if($model->getErrors()){
                    var_dump($model->getErrors());die;
                }

                $detail = new CustomerHistoryDetail();
                $detail->history_id = $model->id;
                $detail->customer_id = $this->customer_id;
                //$detail->object_id   = ;
                $detail->object_type = CustomerHistoryDetail::SERVER_IN_CARD;
                $detail->amount = $totalMoney;
                $detail->used_at = time();
                //$detail->note = ;
                $detail->save();
                if($detail->getErrors()){
                    var_dump($detail->getErrors());die;
                }
            }
        }
        return true;

    }
}
