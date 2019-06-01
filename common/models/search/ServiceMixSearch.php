<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ServiceMix;

/**
 * ServiceMixSearch represents the model behind the search form about `common\models\ServiceMix`.
 */
class ServiceMixSearch extends ServiceMix
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'service_mix_id', 'service_id', 'amount', 'money', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
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
        $query = ServiceMix::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'service_mix_id' => $this->service_mix_id,
            'service_id' => $this->service_id,
            'amount' => $this->amount,
            'money' => $this->money,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

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
        $query = ServiceMix::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->andFilterWhere([
            'service_mix_id' => $service_id,
        ]);
        return $dataProvider;
    }
}
