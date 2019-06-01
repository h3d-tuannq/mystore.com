<?php

namespace common\models\search;

use common\models\ServiceMix;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Service;
use yii\helpers\ArrayHelper;

/**
 * ServiceSearch represents the model behind the search form about `common\models\Service`.
 */
class ServiceSearch extends Service
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
            [['id','duration', 'service_type_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'discount_of_employee', 'number_product', 'number_serve', 'number_day', 'remain_time', 'warranty', 'total_price', 'retail_price'], 'integer'],
            [['slug', 'name', 'description', 'thumbnail_base_url', 'thumbnail_path', 'on_time'], 'safe'],
            [['discount_money'], 'number'],
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

        $query = Service::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'service_type_id' => $this->service_type_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'discount_of_employee' => $this->discount_of_employee,
            'number_product' => $this->number_product,
            'number_serve' => $this->number_serve,
            'number_day' => $this->number_day,
            'on_time' => $this->on_time,
            'remain_time' => $this->remain_time,
            'warranty' => $this->warranty,
            'total_price' => $this->total_price,
            'retail_price' => $this->retail_price,
            'discount_money' => $this->discount_money,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'thumbnail_base_url', $this->thumbnail_base_url])
            ->andFilterWhere(['like', 'thumbnail_path', $this->thumbnail_path]);

        return $dataProvider;
    }

    public function searchCombo($params)
    {

        $query = Service::find()->where(['service_type_id' => 2]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'service_type_id' => $this->service_type_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'discount_of_employee' => $this->discount_of_employee,
            'number_product' => $this->number_product,
            'number_serve' => $this->number_serve,
            'number_day' => $this->number_day,
            'on_time' => $this->on_time,
            'remain_time' => $this->remain_time,
            'warranty' => $this->warranty,
            'total_price' => $this->total_price,
            'retail_price' => $this->retail_price,
            'discount_money' => $this->discount_money,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'thumbnail_base_url', $this->thumbnail_base_url])
            ->andFilterWhere(['like', 'thumbnail_path', $this->thumbnail_path]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchForCombo($params)
    {
        $query = Service::find()->where(['not',['service_type_id'=>2]]); //combo

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'service_type_id' => $this->service_type_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'discount_of_employee' => $this->discount_of_employee,
            'number_product' => $this->number_product,
            'number_serve' => $this->number_serve,
            'number_day' => $this->number_day,
            'on_time' => $this->on_time,
            'remain_time' => $this->remain_time,
            'warranty' => $this->warranty,
            'total_price' => $this->total_price,
            'retail_price' => $this->retail_price,
            'discount_money' => $this->discount_money,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'thumbnail_base_url', $this->thumbnail_base_url])
            ->andFilterWhere(['like', 'thumbnail_path', $this->thumbnail_path]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchByService($params,$service_id)
    {
        $serviceMixs = ServiceMix::findAll(['service_mix_id'=>$service_id]);
        $serviceIds = ArrayHelper::getColumn($serviceMixs,'service_id');
        $query = Service::find()->where(['id'=>$serviceIds]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'service_type_id' => $this->service_type_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'discount_of_employee' => $this->discount_of_employee,
            'number_product' => $this->number_product,
            'number_serve' => $this->number_serve,
            'number_day' => $this->number_day,
            'on_time' => $this->on_time,
            'remain_time' => $this->remain_time,
            'warranty' => $this->warranty,
            'total_price' => $this->total_price,
            'retail_price' => $this->retail_price,
            'discount_money' => $this->discount_money,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'thumbnail_base_url', $this->thumbnail_base_url])
            ->andFilterWhere(['like', 'thumbnail_path', $this->thumbnail_path]);

        return $dataProvider;
    }
}
