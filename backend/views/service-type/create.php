<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ServiceType */

$this->title = 'Thêm Loại dịch vụ';
$this->params['breadcrumbs'][] = ['label' => 'Loại dịch vụ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-type-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
