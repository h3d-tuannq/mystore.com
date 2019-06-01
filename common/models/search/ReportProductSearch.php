<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\ReportProduct;

/**
 * ReportProductSearch represents the model behind the search form about `common\models\base\ReportProduct`.
 */
class ReportProductSearch extends ReportProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'year', 'quarter', 'month', 'week', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['product_name', 'product_code', 'report_date'], 'safe'],
            [['revenue'], 'number'],
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
        $query = ReportProduct::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
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

        $query->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_code', $this->product_code]);

        return $dataProvider;
    }
}
