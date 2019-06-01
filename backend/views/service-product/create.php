<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ServiceProduct */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Service Product',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Service Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-product-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
