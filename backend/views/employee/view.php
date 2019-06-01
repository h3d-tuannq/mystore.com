<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-view">

    <div class="row">
        <div class="col-md-3">
            <?php echo $this->render('_view_info', ['model' => $model]); ?>
        </div>

        <div class="col-md-9">
            <?php echo $this->render('_view_service',
                [
                    'model' => $model,
                    'dataProvider' => $serviceDataProvider,
                    'searchModel' => $searchModel,
                ]); ?>
        </div>

    </div>

</div>
