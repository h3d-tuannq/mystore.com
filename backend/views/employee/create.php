<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Employee */

$this->title = 'Thêm nhân viên';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
