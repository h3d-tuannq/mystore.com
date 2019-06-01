<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ServiceMix */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Service Mix',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Service Mixes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-mix-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
