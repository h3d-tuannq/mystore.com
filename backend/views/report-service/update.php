<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\base\ReportService */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Report Service',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Report Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="report-service-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
