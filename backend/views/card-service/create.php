<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\CardService */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Card Service',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Card Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-service-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
