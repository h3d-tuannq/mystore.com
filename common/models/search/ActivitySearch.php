<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\Activity;

/**
 * ActivitySearch represents the model behind the search form about `common\models\base\Activity`.
 */
class ActivitySearch extends Activity
{
    public $from;
    public $to;
    public $service_code;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'service_id', 'customer_id', 'employee_id', 'start_time', 'end_time', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['service_name', 'customer_name', 'bed', 'note'], 'safe'],
            [['discount'], 'number'],
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
        $query = Activity::find();

        //$query->orderBy('updated_at desc');
	    // Ngày làm dịch vụ
        $query->orderBy('start_time desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'service_id' => $this->service_id,
            'customer_id' => $this->customer_id,
            'employee_id' => $this->employee_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'discount' => $this->discount,
        ]);

        $query->andFilterWhere(['like', 'service_name', $this->service_name])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'bed', $this->bed])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchEmployee($params)
    {
        $query = Activity::find()->select(['*','count(service_id) as count_time','sum(discount) as total_money']);

        // Ngày làm dịch vụ
        $query->orderBy('start_time desc');
        $query->groupBy('service_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andFilterWhere([
            'employee_id' => $this->employee_id,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'service_id' => $this->service_id,
            'customer_id' => $this->customer_id,
            'employee_id' => $this->employee_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'discount' => $this->discount,
        ]);

        $query->andFilterWhere(['like', 'service_name', $this->service_name])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'bed', $this->bed])
            ->andFilterWhere(['like', 'note', $this->note]);

        if($this->from && $this->to){
            $query->andFilterWhere(['between', 'start_time', strtotime(date_format(date_create_from_format('d/m/Y', $this->from), 'Y-m-d'))
                ,strtotime(date_format(date_create_from_format('d/m/Y', $this->to),'Y-m-d'))]);
        }
        return $dataProvider;
    }
}
