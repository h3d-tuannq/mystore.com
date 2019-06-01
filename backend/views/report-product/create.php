<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\ReportProduct */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Report Product',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Report Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-product-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
