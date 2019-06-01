<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

/**
 * OrderSearch represents the model behind the search form about `common\models\Order`.
 */
class OrderSearch extends Order
{
    public $from;
    public $to;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'rate_employee_id', 'raw_money', 'total_money', 'real_money', 'payment_type', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['code', 'voucher_code','order_date'], 'safe'],
            [['discount', 'rate_receptionist', 'rate_receptionist_id', 'rate_employee'], 'number'],
            [['from','to'], 'safe'],
            [['order_date'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['order_date'=>SORT_DESC]]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'discount' => $this->discount,
            'rate_receptionist' => $this->rate_receptionist,
            'rate_receptionist_id' => $this->rate_receptionist_id,
            'rate_employee' => $this->rate_employee,
            'rate_employee_id' => $this->rate_employee_id,
            'raw_money' => $this->raw_money,
            'total_money' => $this->total_money,
            'real_money' => $this->real_money,
            'payment_type' => $this->payment_type,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);
        $query->andFilterWhere(['between', 'order_date', $this->order_date, $this->order_date + 3600 * 24]);
        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'voucher_code', $this->voucher_code]);

        return $dataProvider;
    }

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function searchByCustomer($customer_id,$params)
	{
		$query = Order::find()->where(['customer_id'=>$customer_id]);;

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'id' => $this->id,
			'customer_id' => $this->customer_id,
			'discount' => $this->discount,
			'rate_receptionist' => $this->rate_receptionist,
			'rate_receptionist_id' => $this->rate_receptionist_id,
			'rate_employee' => $this->rate_employee,
			'rate_employee_id' => $this->rate_employee_id,
			'raw_money' => $this->raw_money,
			'total_money' => $this->total_money,
			'real_money' => $this->real_money,
			'payment_type' => $this->payment_type,
			'status' => $this->status,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'created_by' => $this->created_by,
			'updated_by' => $this->updated_by,
		]);

		$query->andFilterWhere(['like', 'code', $this->code])
		      ->andFilterWhere(['like', 'voucher_code', $this->voucher_code]);

		return $dataProvider;
	}

}
