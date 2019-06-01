<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\base\CardService */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Card Service',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Card Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="card-service-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
