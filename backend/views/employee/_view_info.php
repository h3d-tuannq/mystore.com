<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\Product */
?>

<div class="box box-primary">

    <div class="box-body">
        <h3>Thông tin cơ bản</h3>
        <?php echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'birth_of_date',
                'phone',
                'identify',
                'salary',
                'rate_revenue',
                'rate_overtime',
                'status',
                'thumbnail_base_url:url',
                'thumbnail_path',
                'created_at',
                'updated_at',
                'created_by',
                'updated_by',
            ],
        ]) ?>
    </div>
</div>

