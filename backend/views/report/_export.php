<?php

use trntv\filekit\widget\Upload;
use trntv\yii\datetime\DateTimeWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this       yii\web\View
 * @var $model      common\models\Article
 * @var $categories common\models\ArticleCategory[]
 */
?>

<?php echo Html::a('Tải file',
    $model->export,
    [
        'target' => '_blank',
        'class' => 'btn btn-primary btn-lg'
    ]) ?>
