<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\CustomerType */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Customer Type',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Customer Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-type-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
