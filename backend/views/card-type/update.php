<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CardType */

$this->title = 'Cập nhật Loại thẻ: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Loại thẻ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="card-type-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
