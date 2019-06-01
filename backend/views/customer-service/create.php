<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\CustomerService */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Customer Service',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Customer Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-service-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
