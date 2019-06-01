<?php

use yii\helpers\Html;


?>

<p>Số lượng <?php echo $model->result ?> bản ghi</p>
<div class="form-group">
    <?php echo Html::a('<i class="fa fa-refresh"></i> Cập nhật danh sách', ['index'], ['class' => 'btn btn-sm btn-success']) ?>
</div>


