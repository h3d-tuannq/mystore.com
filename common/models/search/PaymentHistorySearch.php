<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\PaymentHistory;

/**
 * PaymentHistorySearch represents the model behind the search form about `common\models\base\PaymentHistory`.
 */
class PaymentHistorySearch extends PaymentHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'before_money', 'change_money', 'current_money', 'type', 'object_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['reason', 'object_type'], 'safe'],
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
        $query = PaymentHistory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'before_money' => $this->before_money,
            'change_money' => $this->change_money,
            'current_money' => $this->current_money,
            'type' => $this->type,
            'object_id' => $this->object_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'object_type', $this->object_type]);

        return $dataProvider;
    }
}
