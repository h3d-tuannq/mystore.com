<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\ReportService */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Report Service',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Report Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-service-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
