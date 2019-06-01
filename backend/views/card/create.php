<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Card */

$this->title = 'Thêm thẻ mới';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Cards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'card_types' => $card_types,
    ]) ?>

</div>
