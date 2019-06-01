<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\ReportService;

/**
 * ReportServiceSearch represents the model behind the search form about `common\models\base\ReportService`.
 */
class ReportServiceSearch extends ReportService
{
    public $from;
    public $to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_code'], 'filter', 'filter' => 'trim'],
            [['id', 'service_id', 'year', 'quarter', 'month', 'week', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['service_name', 'service_code', 'report_date'], 'safe'],
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
        $query = ReportService::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

	    $query->andFilterWhere([
		    'service_code' => $this->service_code,
	    ]);

	    if($this->from && $this->to){
		    $query->andFilterWhere(['between', 'report_date', date_format(date_create_from_format('d/m/Y', $this->from), 'Y-m-d')
			    ,date_format(date_create_from_format('d/m/Y', $this->to),'Y-m-d')]);
	    }
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
        $query = ReportService::find()->select('year,month, service_id, service_name, service_code, sum(`use`) as `use`')
            ->where(['>','use',0])
            ->groupBy(['month','year','service_id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

	    $query->andFilterWhere([
		    'service_code' => $this->service_code,
		    'year' => $this->year,
		    'month' => $this->month,
	    ]);

	    if($this->from && $this->to){
		    $query->andFilterWhere(['between', 'report_date', date_format(date_create_from_format('d/m/Y', $this->from), 'Y-m-d')
			    ,date_format(date_create_from_format('d/m/Y', $this->to),'Y-m-d')]);
	    }
        return $dataProvider;
    }
}
