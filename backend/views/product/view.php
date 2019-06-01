<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <div class="row">
        <div class="col-md-3">
            <?php echo $this->render('_view_info', ['model' => $model]); ?>
        </div>

        <div class="col-md-9">
            <?php echo $this->render('_view_service',
                [
                    'model' => $model,
                    'dataProvider' => $serviceDataProvider,
                ]); ?>
        </div>

    </div>

</div>
