<?php
/**
 * Created by PhpStorm.
 * User: tuann
 * Date: 5/16/2019
 * Time: 22:50
 */

namespace frontend\models\search;


use common\models\Product;
use yii\data\ActiveDataProvider;

class ProductSearch extends Product
{

    public function search(){
        $query = Product::find()->where(true);
        $dataProvider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => ['pageSize' => 12]
        ]);
        return $dataProvider;
    }
}