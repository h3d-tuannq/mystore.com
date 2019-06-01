<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Appointment */

$this->title = 'Tạo';
$this->params['breadcrumbs'][] = ['label' => 'Chấm công', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appointment-create">

    <?php echo $this->render('_form_timesheet', [
        'model' => $model,'customers' => $customers,
    ]) ?>

</div>
