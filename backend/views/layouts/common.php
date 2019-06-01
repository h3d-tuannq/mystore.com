<?php
/**
 * @var $this yii\web\View
 * @var $content string
 */

use backend\assets\BackendAsset;
use backend\modules\system\models\SystemLog;
use backend\widgets\Menu;
use common\models\TimelineEvent;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\log\Logger;
use yii\widgets\Breadcrumbs;

$bundle = BackendAsset::register($this);

?>

<?php $this->beginContent('@backend/views/layouts/base.php'); ?>

<div class="wrapper">
    <!-- header logo: style can be found in header.less -->
    <header class="main-header">
        <a href="<?php echo Yii::$app->urlManagerBackend->createAbsoluteUrl('/') ?>" class="logo">
            <!-- Add the class icon to your logo image or logo icon to add the margining -->
            <?php echo Yii::$app->name ?>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only"><?php echo Yii::t('backend', 'Toggle navigation') ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Notifications: style can be found in dropdown.less-->
                    <li id="log-dropdown" class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell"></i>
                            <span class="label label-success">
                                <?php echo TimelineEvent::find()->today()->count() ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"><?php echo Yii::t('backend', 'Bạn có {num} thông báo',
                                    ['num' => TimelineEvent::find()->today()->count()]) ?></li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <?php foreach (TimelineEvent::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all() as $logEntry): ?>
                                        <li>
                                            <a href="<?php echo Yii::$app->urlManager->createUrl(['/timeline-event/index', 'id' => $logEntry->id]) ?>">
                                                <?php
                                                    $icon = '';
                                                    switch ($logEntry->category){
                                                        case 'customer':
                                                            echo '<i class="fa fa-birthday-cake"></i>';
                                                            echo isset($logEntry->data['content'])? $logEntry->data['content'] : '';
                                                            echo $logEntry->event;
                                                            break;
                                                        case 'product':
                                                            echo '<i class="fa fa-circle"></i>';
                                                            echo isset($logEntry->data['content'])? $logEntry->data['content'] : '';
                                                            break;
                                                        case 'customer_service':
                                                            echo '<i class="fa fa-bell"></i>';
                                                            echo isset($logEntry->data['content'])? $logEntry->data['content'] : '';
                                                            echo $logEntry->event;
                                                            break;
                                                        default :
                                                            echo '<i class="fa fa-time"></i>';
                                                            echo $logEntry->event;
                                                    }
                                                ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <li class="footer">
                                <?php echo Html::a(Yii::t('backend', 'View all'), ['/timeline-event/index']) ?>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/logo.jpg')) ?>"
                                 class="user-image">
                            <span><?php echo Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header light-blue">
                                <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/logo.jpg')) ?>"
                                     class="img-circle" alt="User Image"/>
                                <p>
                                    <?php echo Yii::$app->user->identity->username ?>
                                    <small>
                                        <?php echo Yii::t('backend', 'Member since {0, date, short}', Yii::$app->user->identity->created_at) ?>
                                    </small>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <?php echo Html::a(Yii::t('backend', 'Profile'), ['/sign-in/profile'], ['class' => 'btn btn-default btn-flat']) ?>
                                </div>
                                <div class="pull-left">
                                    <?php echo Html::a(Yii::t('backend', 'Account'), ['/sign-in/account'], ['class' => 'btn btn-default btn-flat']) ?>
                                </div>
                                <div class="pull-right">
                                    <?php echo Html::a(Yii::t('backend', 'Logout'), ['/sign-in/logout'], ['class' => 'btn btn-default btn-flat', 'data-method' => 'post']) ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <?php //echo Html::a('<i class="fa fa-cogs"></i>', ['/system/settings']) ?>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <?php echo Menu::widget([
                'options' => ['class' => 'sidebar-menu'],
                'linkTemplate' => '<a href="{url}">{icon}<span>{label}</span>{right-icon}{badge}</a>',
                'submenuTemplate' => "\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
                'activateParents' => true,
                'items' => [
                    [
                        'label' => Yii::t('backend', 'Mục chính'),
                        'options' => ['class' => 'header'],
                    ],
                    [
                        'label' => Yii::t('backend', 'Dashboard'),
                        'icon' => '<i class="fa fa-th"></i>',
                        'url' => ['/dashboard/index'],
                        'active' => Yii::$app->controller->id === 'dashboard',
                        'visible' => Yii::$app->user->can('administrator'),
                    ],

                    [
                        'label' => Yii::t('backend', 'Service'),
                        'url' => '#',
                        'icon' => '<i class="fa fa-folder"></i>',
                        'options' => ['class' => 'treeview'],
                        'active' => in_array(Yii::$app->controller->id,['service','card']),
                        'items' => [
                            [
                                'label' => Yii::t('backend', 'Dịch vụ lẻ'),
                                'url' => ['/service/index'],
                                'icon' => '<i class="fa fa-users"></i>',
                                'active' => Yii::$app->controller->action->id === 'index',
                            ],
                            [
                                'label' => Yii::t('backend', 'Combo'),
                                'url' => ['/service/combo'],
                                'icon' => '<i class="fa fa-users"></i>',
                                'active' => Yii::$app->controller->action->id === 'index',
                            ],
                            [
                                'label' => Yii::t('backend', 'Card'),
                                'icon' => '<i class="fa fa-credit-card"></i>',
                                'url' => ['/card/index'],
                                'active' => Yii::$app->controller->id === 'card',
                                'visible' => Yii::$app->user->can('administrator'),
                            ],
                        ],
                    ],
                    [
                        'label' => Yii::t('backend', 'Product'),
                        'icon' => '<i class="fa fa-users"></i>',
                        'url' => ['/product/index'],
                        'active' => Yii::$app->controller->id === 'product',
                        'visible' => Yii::$app->user->can('manager'),
                    ],
                    [
                        'label' => Yii::t('backend', 'Customer'),
                        'url' => '#',
                        'icon' => '<i class="fa fa-users"></i>',
                        'options' => ['class' => 'treeview'],
                        'active' => in_array(Yii::$app->controller->id,['employee']),
                        'items' => [
                                [
                                    'label' => Yii::t('backend', 'Customer'),
                                    'icon' => '<i class="fa fa-users"></i>',
                                    'url' => ['/customer/index'],
                                    'active' => Yii::$app->controller->id === 'customer' && Yii::$app->controller->action->id === 'index',
                                    'visible' => Yii::$app->user->can('manager'),
                                ],
                                [
                                    'label' => Yii::t('backend', 'Công nợ khách hàng'),
                                    'url' => ['/customer/report'],
                                    'icon' => '<i class="fa fa-folder-open-o"></i>',
                                    'active' => Yii::$app->controller->id === 'customer' && Yii::$app->controller->action->id === 'report',
                                    'visible' => Yii::$app->user->can('manager'),
                                ],

                                [
                                    'label' => Yii::t('backend', 'Chiết khấu theo khách hàng'),
                                    'url' => ['/activity/timekeeping'],
                                    'icon' => '<i class="fa fa-folder-open-o"></i>',
                                    'active' => Yii::$app->controller->id === 'activity',
                                    'visible' => Yii::$app->user->can('administrator'),
                                ],
                            ]
                    ],
                    [
                        'label' => Yii::t('backend', 'Employee'),
                        'url' => '#',
                        'icon' => '<i class="fa fa-users"></i>',
                        'options' => ['class' => 'treeview'],
                        'active' => in_array(Yii::$app->controller->id,['employee']),
                        'items' => [
                            [
                                'label' => Yii::t('backend', 'Danh sách nhân viên'),
                                'url' => ['/employee/index'],
                                'icon' => '<i class="fa fa-users"></i>',
                                'active' => Yii::$app->controller->action->id === 'index',
                            ],
                            [
                                'label' => Yii::t('backend', 'Timekeeping'),
                                'url' => ['/employee/timekeeping'],
                                'icon' => '<i class="fa fa-folder-open-o"></i>',
                                'active' => Yii::$app->controller->id === 'employee' && Yii::$app->controller->action->id === 'timekeeping',
                            ],
                            [
                                'label' => Yii::t('backend', 'Kế hoạch tháng'),
                                'url' => ['/employee/plan'],
                                'icon' => '<i class="fa fa-calendar-check-o"></i>',
                                'active' => Yii::$app->controller->action->id === 'plan',
                            ],
                            [
                                'label' => Yii::t('backend', 'Thời gian làm ngoài giờ'),
                                'url' => ['/employee/overtime'],
                                'icon' => '<i class="fa fa-folder-open-o"></i>',
                                'active' => Yii::$app->controller->id === 'employee' && Yii::$app->controller->action->id === 'overtime',
                            ],
                            [
                                'label' => Yii::t('backend', 'Chiết khấu của nhân viên'),
                                'url' => ['/employee/rate'],
                                'icon' => '<i class="fa fa-folder-open-o"></i>',
                                'active' => Yii::$app->controller->id === 'employee' && Yii::$app->controller->action->id === 'rate',
                            ],
                            [
                                'label' => Yii::t('backend', 'Bảng lương nhân viên'),
                                'url' => ['/employee/salary'],
                                'icon' => '<i class="fa fa-folder-open-o"></i>',
                                'active' => Yii::$app->controller->id === 'salary',
                            ],
                        ],
                        'visible' => Yii::$app->user->can('administrator'),
                    ],

                    [
                        'label' => Yii::t('backend', 'Activity'),
                        'options' => ['class' => 'header'],
                    ],

                    [
                        'label' => Yii::t('backend', 'Order'),
                        'url' => ['/order/index'],
                        'icon' => '<i class="fa fa-file-o"></i>',
                        'active' => Yii::$app->controller->id === 'order',

                    ],
                    [
                        'label' => Yii::t('backend', 'Appointment'),
                        'url' => ['/appointment/index'],
                        'icon' => '<i class="fa fa-calendar"></i>',
                        'active' => Yii::$app->controller->id === 'appointment',
                    ],
                    [
                        'label' => Yii::t('backend', 'Lịch làm dịch vụ'),
                        'url' => ['/activity/do-service'],
                        'icon' => '<i class="fa fa-calendar"></i>',
                        'active' => Yii::$app->controller->id === 'activity',
                    ],

                    [
                        'label' => Yii::t('backend', 'Report'),
                        'options' => ['class' => 'header'],
                        'visible' => Yii::$app->user->can('administrator'),
                    ],
                    [
                        'label' => Yii::t('backend', 'Doanh thu'),
                        'url' => '#',
                        'icon' => '<i class="fa fa-line-chart"></i>',
                        'options' => ['class' => 'treeview'],
                        'active' => 'report' === Yii::$app->controller->id,
                        'items' => [
                            [
                                'label' => Yii::t('backend', 'Theo sản phẩm'),
                                'url' => ['/report/product'],
                                'icon' => '<i class="fa fa-file-o"></i>',
                                'active' => Yii::$app->controller->id === 'report',
                            ],
                            [
                                'label' => Yii::t('backend', 'Dịch vụ theo ngày'),
                                'url' => ['/report/service'],
                                'icon' => '<i class="fa fa-file-o"></i>',
                                'active' => Yii::$app->controller->id === 'report',
                            ],
                            [
                                'label' => Yii::t('backend', 'Dịch vụ theo tháng'),
                                'url' => ['/report/service-month'],
                                'icon' => '<i class="fa fa-file-o"></i>',
                                'active' => Yii::$app->controller->id === 'report',
                            ],
                            [
                                'label' => Yii::t('backend', 'Theo nhân viên'),
                                'url' => ['/report/employee'],
                                'icon' => '<i class="fa fa-file-o"></i>',
                                'active' => Yii::$app->controller->id === 'report',
                            ],
                            [
                                'label' => Yii::t('backend', 'Theo khách hàng'),
                                'url' => ['/report/customer'],
                                'icon' => '<i class="fa fa-file-o"></i>',
                                'active' => Yii::$app->controller->id === 'report',
                            ],
                            [
                                'label' => Yii::t('backend', 'Theo ngày'),
                                'url' => ['/report/index'],
                                'icon' => '<i class="fa fa-file-o"></i>',
                                'active' => Yii::$app->controller->id === 'report',
                            ],
//                            [
//                                'label' => Yii::t('backend', 'Theo tuần'),
//                                'url' => ['/report/week'],
//                                'icon' => '<i class="fa fa-file-o"></i>',
//                                'active' => Yii::$app->controller->id === 'report',
//                            ],
                            [
                                'label' => Yii::t('backend', 'Theo tháng'),
                                'url' => ['/report/month'],
                                'icon' => '<i class="fa fa-file-o"></i>',
                                'active' => Yii::$app->controller->id === 'report',
                            ],
                            [
                                'label' => Yii::t('backend', 'Theo năm'),
                                'url' => ['/report/year'],
                                'icon' => '<i class="fa fa-file-o"></i>',
                                'active' => Yii::$app->controller->id === 'report',
                            ],
                            [
                                'label' => Yii::t('backend', 'Phương thức thanh toán'),
                                'url' => ['/report-payment'],
                                'icon' => '<i class="fa fa-file-o"></i>',
                                'active' => Yii::$app->controller->id === 'report-payment',
                            ],
                        ],
                        'visible' => Yii::$app->user->can('administrator'),
                    ],



//
//                    [
//                        'label' => Yii::t('backend', 'Schedule'),
//                        'icon' => '<i class="fa fa-bar-chart-o"></i>',
//                        'url' => ['/timeline-event/index'],
//                        'badge' => TimelineEvent::find()->today()->count(),
//                        'badgeBgClass' => 'label-success',
//                    ],


//                    [
//                        'label' => Yii::t('backend', 'Widgets'),
//                        'url' => '#',
//                        'icon' => '<i class="fa fa-code"></i>',
//                        'options' => ['class' => 'treeview'],
//                        'active' => Yii::$app->controller->module->id === 'widget',
//                        'items' => [
//                            [
//                                'label' => Yii::t('backend', 'Text Blocks'),
//                                'url' => ['/widget/text/index'],
//                                'icon' => '<i class="fa fa-circle-o"></i>',
//                                'active' => Yii::$app->controller->id === 'text',
//                            ],
//                            [
//                                'label' => Yii::t('backend', 'Menu'),
//                                'url' => ['/widget/menu/index'],
//                                'icon' => '<i class="fa fa-circle-o"></i>',
//                                'active' => Yii::$app->controller->id === 'menu',
//                            ],
//                            [
//                                'label' => Yii::t('backend', 'Carousel'),
//                                'url' => ['/widget/carousel/index'],
//                                'icon' => '<i class="fa fa-circle-o"></i>',
//                                'active' => in_array(Yii::$app->controller->id, ['carousel', 'carousel-item']),
//                            ],
//                        ],
//                    ],

                    [
                        'label' => Yii::t('backend', 'System'),
                        'options' => ['class' => 'header'],
                        'visible' => Yii::$app->user->can('administrator'),
                    ],
                    [
                        'label' => Yii::t('backend', 'Kiểu'),
                        'url' => '#',
                        'icon' => '<i class="fa fa-flag"></i>',
                        'options' => ['class' => 'treeview'],
                        'active' => in_array(Yii::$app->controller->id, ['product-type', 'product-unit', 'service-type','employee-type']),
                        'items' => [
                            [
                                'label' => Yii::t('backend', 'Kiểu sản phẩm'),
                                'url' => ['/product-type/index'],
                                'icon' => '<i class="fa fa-circle-o"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Đơn vị sản phẩm'),
                                'url' => ['/product-unit/index'],
                                'icon' => '<i class="fa fa-circle-o"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Loại dịch vụ'),
                                'url' => ['/service-type/index'],
                                'icon' => '<i class="fa fa-circle-o"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Loại thẻ'),
                                'url' => ['/card-type/index'],
                                'icon' => '<i class="fa fa-circle-o"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Kiểu nhân viên'),
                                'url' => ['/employee-type/index'],
                                'icon' => '<i class="fa fa-circle-o"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Kiểu khách hàng'),
                                'url' => ['/customer-type/index'],
                                'icon' => '<i class="fa fa-circle-o"></i>',
                            ],
                            [
                                'label' => Yii::t('backend', 'Phương thức thanh toán'),
                                'url' => ['/payment/index'],
                                'icon' => '<i class="fa fa-circle-o"></i>',
                            ],
                        ],
                        'visible' => Yii::$app->user->can('administrator'),
                    ],
//                    [
//                        'label' => Yii::t('backend', 'Cấu hình'),
//                        'icon' => '<i class="fa fa-cogs"></i>',
//                        'url' => ['/system/key-storage/index'],
//                        'visible' => Yii::$app->user->can('administrator'),
//                    ],
//
//                    [
//                        'label' => Yii::t('backend', 'Users'),
//                        'icon' => '<i class="fa fa-users"></i>',
//                        'url' => ['/user/index'],
//                        'active' => Yii::$app->controller->id === 'user',
//                        'visible' => Yii::$app->user->can('administrator'),
//                    ],
//                    [
//                        'label' => Yii::t('backend', 'Phân quyền'),
//                        'url' => '#',
//                        'icon' => '<i class="fa fa-flag"></i>',
//                        'options' => ['class' => 'treeview'],
//                        'active' => in_array(Yii::$app->controller->id, ['rbac-auth-assignment', 'rbac-auth-item', 'rbac-auth-item-child', 'rbac-auth-rule']),
//                        'items' => [
//                            [
//                                'label' => Yii::t('backend', 'Auth Assignment'),
//                                'url' => ['/rbac/rbac-auth-assignment/index'],
//                                'icon' => '<i class="fa fa-circle-o"></i>',
//                            ],
//                            [
//                                'label' => Yii::t('backend', 'Auth Items'),
//                                'url' => ['/rbac/rbac-auth-item/index'],
//                                'icon' => '<i class="fa fa-circle-o"></i>',
//                            ],
//                            [
//                                'label' => Yii::t('backend', 'Auth Item Child'),
//                                'url' => ['/rbac/rbac-auth-item-child/index'],
//                                'icon' => '<i class="fa fa-circle-o"></i>',
//                            ],
//                            [
//                                'label' => Yii::t('backend', 'Auth Rules'),
//                                'url' => ['/rbac/rbac-auth-rule/index'],
//                                'icon' => '<i class="fa fa-circle-o"></i>',
//                            ],
//                        ],
//                    ],

//                    [
//                        'label' => Yii::t('backend', 'Files'),
//                        'url' => '#',
//                        'icon' => '<i class="fa fa-th-large"></i>',
//                        'options' => ['class' => 'treeview'],
//                        'active' => (Yii::$app->controller->module->id == 'file'),
//                        'items' => [
//                            [
//                                'label' => Yii::t('backend', 'Storage'),
//                                'url' => ['/file/storage/index'],
//                                'icon' => '<i class="fa fa-database"></i>',
//                                'active' => (Yii::$app->controller->id == 'storage'),
//                            ],
//                            [
//                                'label' => Yii::t('backend', 'Manager'),
//                                'url' => ['/file/manager/index'],
//                                'icon' => '<i class="fa fa-television"></i>',
//                                'active' => (Yii::$app->controller->id == 'manager'),
//                            ],
//                        ],
//                    ],
//                    [
//                        'label' => Yii::t('backend', 'Cache'),
//                        'url' => ['/system/cache/index'],
//                        'icon' => '<i class="fa fa-refresh"></i>',
//                    ],
//                    [
//                        'label' => Yii::t('backend', 'System Information'),
//                        'url' => ['/system/information/index'],
//                        'icon' => '<i class="fa fa-dashboard"></i>',
//                    ],
//                    [
//                        'label' => Yii::t('backend', 'Logs'),
//                        'url' => ['/system/log/index'],
//                        'icon' => '<i class="fa fa-warning"></i>',
//                        'badge' => SystemLog::find()->count(),
//                        'badgeBgClass' => 'label-danger',
//                    ],


                ],
            ]) ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo $this->title ?>
                <?php if (isset($this->params['subtitle'])): ?>
                    <small><?php echo $this->params['subtitle'] ?></small>
                <?php endif; ?>
            </h1>

            <?php echo Breadcrumbs::widget([
                'tag' => 'ol',
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php if (Yii::$app->session->hasFlash('alert')): ?>
                <?php echo Alert::widget([
                    'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                    'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
                ]) ?>
            <?php endif; ?>
            <?php echo $content ?>
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'><div style='text-align:center'><img src='/img/loading.gif'></div>";
yii\bootstrap\Modal::end();
?>
<?php $this->endContent(); ?>
