<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Appointment */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Appointment',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Appointments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appointment-create">

    <?php echo $this->render('_form', [
        'model' => $model,'customers' => $customers,
    ]) ?>

</div>
