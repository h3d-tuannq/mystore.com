<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductUnit */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Product Unit',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Product Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-unit-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
