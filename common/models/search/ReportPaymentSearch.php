<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\ReportPayment;

/**
 * ReportPaymentSearch represents the model behind the search form about `common\models\base\ReportPayment`.
 */
class ReportPaymentSearch extends ReportPayment
{
    public $from;
    public $to;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'payment_id', 'year', 'quarter', 'month', 'week', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['payment_name', 'report_date'], 'safe'],
            [['revenue'], 'number'],
            [['from','to'], 'safe']
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
        $query = ReportPayment::find()->where(['<>','payment_id',6]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'payment_id' => $this->payment_id,
            'year' => $this->year,
            'quarter' => $this->quarter,
            'month' => $this->month,
            'week' => $this->week,
            'report_date' => $this->report_date,
            'revenue' => $this->revenue,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        if($this->from && $this->to){
            $query->andFilterWhere(['between', 'report_date', date_format(date_create_from_format('d/m/Y', $this->from), 'Y-m-d')
                ,date_format(date_create_from_format('d/m/Y', $this->to),'Y-m-d')]);
        }

        return $dataProvider;
    }
}
