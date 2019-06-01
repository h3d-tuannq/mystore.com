<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\ReportRevenue;

/**
 * ReportServiceSearch represents the model behind the search form about `common\models\base\ReportService`.
 */
class ReportRevenueSearch extends ReportRevenue
{
    public $from;
    public $to;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'year', 'quarter', 'month', 'week', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['report_date'], 'safe'],
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
        $query = ReportRevenue::find()->orderBy('report_date desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize'=>31],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
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
        //$from = date('Y-m-d',strtotime($this->from));
        //var_dump($this->to);
        //to = date('Y-m-d',strtotime($this->to));
        $query->andFilterWhere(['between', 'report_date', $this->from, $this->to]);
        //var_dump($query->createCommand()->getRawSql());die;
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchMonth($params)
    {
        $query = ReportRevenue::find()->select(['*', 'sum(revenue) as total'])->groupBy(['year','month']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize'=>31],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
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
        $query->andFilterWhere(['between', 'report_date', $this->from, $this->to]);
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchWeek($params)
    {
        $query = ReportRevenue::find()->select(['*', 'sum(revenue) as total'])->groupBy(['year','week']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize'=>31],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
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
        $query->andFilterWhere(['between', 'report_date', $this->from, $this->to]);
        return $dataProvider;
    }
}
