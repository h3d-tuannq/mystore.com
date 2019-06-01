<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view">

    <div class="row">
        <div class="col-md-3">
            <?php echo $this->render('_view_info', ['model' => $model]); ?>
        </div>

        <div class="col-md-9">
            <?php echo $this->render('_view_serv',
                [
                    'model' => $model,
                    'serviceDataProvider' => $serviceDataProvider,
                    'cardDataProvider' => $cardDataProvider,
                    'dataProvider' => $dataProvider,
                    'cDataProvider' => $cDataProvider,
                    'oDataProvider' => $oDataProvider,
                ]); ?>
        </div>

    </div>


</div>
