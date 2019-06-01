<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CardType */

$this->title = 'Thêm mới loại thẻ';
$this->params['breadcrumbs'][] = ['label' => 'Loại thẻ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-type-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
