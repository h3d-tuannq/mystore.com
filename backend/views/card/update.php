<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Card */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Card',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Cards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="card-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'card_types' => $card_types,

    ]) ?>

</div>
