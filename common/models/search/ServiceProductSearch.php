<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ServiceProduct;

/**
 * ServiceProductSearch represents the model behind the search form about `common\models\ServiceProduct`.
 */
class ServiceProductSearch extends ServiceProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'service_id', 'product_id', 'amount', 'money', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['unit'], 'safe'],
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
        $query = ServiceProduct::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andFilterWhere([
            'product_id' => $this->product_id,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'service_id' => $this->service_id,
            'product_id' => $this->product_id,
            'amount' => $this->amount,
            'money' => $this->money,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'unit', $this->unit]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchByService($service_id)
    {
        $query = ServiceProduct::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['sort' => SORT_ASC]],
        ]);
        $query->andFilterWhere([
            'service_id' => $service_id,
        ]);
        $query->andFilterWhere(['like', 'unit', $this->unit]);
        return $dataProvider;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchByServiceCombo($service_ids)
    {
        $query = ServiceProduct::find();//->where(['service_id'=>$service_ids]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->where([
            'service_id' => $service_ids,
        ]);
        $query->andFilterWhere(['like', 'unit', $this->unit]);
        return $dataProvider;
    }
}
