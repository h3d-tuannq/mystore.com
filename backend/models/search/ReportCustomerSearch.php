<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\ReportCustomer;

/**
 * ReportCustomerSearch represents the model behind the search form about `common\models\base\ReportCustomer`.
 */
class ReportCustomerSearch extends ReportCustomer
{
    public $from;
    public $to;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'year', 'quarter', 'month', 'week', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['customer_name', 'customer_code', 'report_date'], 'safe'],
            [['revenue'], 'number'],
            [['from','to'], 'safe'],
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

        $query = ReportCustomer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere([ 'customer_code'=>$this->customer_code]);

        if($this->from && $this->to){
            $query->andFilterWhere(['between', 'report_date', date_format(date_create_from_format('d/m/Y', $this->from), 'Y-m-d')
                ,date_format(date_create_from_format('d/m/Y', $this->to),'Y-m-d')]);
        }
        return $dataProvider;
    }
}
