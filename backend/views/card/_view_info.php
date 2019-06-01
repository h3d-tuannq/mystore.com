<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

?>
<div class="order-info">
    <table class="table no-margin">
        <tr>
            <td>Mã thẻ</td>
            <th><?= $model->slug ?></th>
        </tr>
        <tr>
            <td>Tên thẻ</td>
            <th><?= $model->name ?></th>
        </tr>
        <tr>
            <td>Mô tả</td>
            <th><?= $model->description ?></th>
        </tr>
        <tr>
            <td>Giá bán lẻ</td>
            <th><?= \Yii::$app->formatter->asCurrency($model->retail_price, 'VND') ?></th>
        </tr>
        <tr>
            <td>Ngày tạo</td>
            <th><?= Yii::$app->formatter->asDatetime($model->created_at) ?></th>
        </tr>
        <tr>
            <td>Tạo bởi</td>
            <th><?= $model->author ? $model->author->userProfile->fullName : '' ?></th>
        </tr>
        <tr>
            <td>Ngày cập nhật</td>
            <th><?= Yii::$app->formatter->asDatetime($model->updated_at) ?></th>
        </tr>
        <tr>
            <td>Cập nhật bởi</td>
            <th><?= $model->updater ? $model->updater->userProfile->fullName : '' ?></th>
        </tr>


        <tr>
            <td><?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?></td>
            <th></th>
        </tr>
    </table>

</div>
