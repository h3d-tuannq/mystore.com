<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductSearch represents the model behind the search form about `common\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'quantity','product_type_id', 'product_unit_id', 'input_price', 'retail_price', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'product_date', 'product_time_use', 'is_notification'], 'integer'],
            [['slug', 'name', 'description', 'thumbnail_base_url', 'thumbnail_path'], 'safe'],
            [['rate_employee'], 'number'],
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
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'product_type_id' => $this->product_type_id,
            'product_unit_id' => $this->product_unit_id,
            'quantity' => $this->quantity,
            'input_price' => $this->input_price,
            'retail_price' => $this->retail_price,
            'rate_employee' => $this->rate_employee,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'product_date' => $this->product_date,
            'product_time_use' => $this->product_time_use,
            'is_notification' => $this->is_notification,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
