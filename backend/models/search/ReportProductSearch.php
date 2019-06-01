<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\ReportProduct;

/**
 * ReportProductSearch represents the model behind the search form about `common\models\base\ReportProduct`.
 */
class ReportProductSearch extends ReportProduct
{
    public $from;
    public $to;
    public $slug;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'year', 'quarter', 'month', 'week', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['product_name', 'product_code', 'report_date'], 'safe'],
            [['revenue'], 'number'],
            [['slug'], 'safe'],
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
        $query = ReportProduct::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'product_code' => $this->product_code,
        ]);

        if($this->from && $this->to){
            $query->andFilterWhere(['between', 'report_date', date_format(date_create_from_format('d/m/Y', $this->from), 'Y-m-d')
                ,date_format(date_create_from_format('d/m/Y', $this->to),'Y-m-d')]);
        }
        return $dataProvider;
    }


}
