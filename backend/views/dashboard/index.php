<?php
/* @var $this yii\web\View */

$this->title = Yii::t('backend', 'Dashboard');
$this->params['breadcrumbs'][] = $this->title;

?>
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?= $countService ?></h3>

                    <p>Dịch vụ</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <?php echo \yii\helpers\Html::a('Chi tiết <i class="fa fa-arrow-circle-right"></i>', ['service/index'], ['class' => "small-box-footer"]) ?>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?= $countOrder ?></h3>

                    <p>Hóa đơn</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <?php echo \yii\helpers\Html::a('Chi tiết <i class="fa fa-arrow-circle-right"></i>',
                    ['order/index'], ['class' => "small-box-footer"]) ?>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?= $countCustomer ?></h3>

                    <p>Khách hàng</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <?php echo \yii\helpers\Html::a('Danh sách khách hàng <i class="fa fa-arrow-circle-right"></i>', ['customer/index'], ['class' => "small-box-footer"]) ?>
            </div>
        </div>
        <!-- ./col -->
        <?php if(Yii::$app->user->can('administrator')){ ?>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?= $countEmployee ?></h3>

                    <p>Nhân viên</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <?php echo \yii\helpers\Html::a('Danh sách nhân viên <i class="fa fa-arrow-circle-right"></i>', ['employee/index'], ['class' => "small-box-footer"]) ?>
            </div>
        </div>
        <?php } ?>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable ui-sortable">
            <?php if(Yii::$app->user->can('administrator')){ ?>
            <!-- TO DO List -->
            <div class="box box-primary">
                <div class="box-header ui-sortable-handle" style="cursor: move;">
                    <i class="ion ion-clipboard"></i>

                    <h3 class="box-title">Lịch hẹn khách hàng</h3>

                    <div class="box-tools pull-right">
                        <ul class="pagination pagination-sm inline">
                            <li><a href="#">«</a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">»</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                    <ul class="todo-list ui-sortable">
                        <li>
                            <!-- drag handle -->
                            <span class="handle ui-sortable-handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                            <!-- checkbox -->
                            <input type="checkbox" value="">
                            <!-- todo text -->
                            <span class="text">Design a nice theme</span>
                            <!-- Emphasis label -->
                            <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
                            <!-- General tools such as edit or delete-->
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                        <li>
                      <span class="handle ui-sortable-handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                            <input type="checkbox" value="">
                            <span class="text">Make the theme responsive</span>
                            <small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small>
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                        <li>
                      <span class="handle ui-sortable-handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                            <input type="checkbox" value="">
                            <span class="text">Let theme shine like a star</span>
                            <small class="label label-warning"><i class="fa fa-clock-o"></i> 1 day</small>
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                        <li>
                      <span class="handle ui-sortable-handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                            <input type="checkbox" value="">
                            <span class="text">Let theme shine like a star</span>
                            <small class="label label-success"><i class="fa fa-clock-o"></i> 3 days</small>
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                        <li>
                      <span class="handle ui-sortable-handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                            <input type="checkbox" value="">
                            <span class="text">Check your messages and notifications</span>
                            <small class="label label-primary"><i class="fa fa-clock-o"></i> 1 week</small>
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                        <li>
                      <span class="handle ui-sortable-handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                            <input type="checkbox" value="">
                            <span class="text">Let theme shine like a star</span>
                            <small class="label label-default"><i class="fa fa-clock-o"></i> 1 month</small>
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                    <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item
                    </button>
                </div>
            </div>
            <!-- /.box -->
            <?php } ?>

        </section>

        <!-- right col -->
        <!-- Right col -->
        <section class="col-lg-7 connectedSortable ui-sortable">
            <?php if(Yii::$app->user->can('administrator')){ ?>
            <!-- Custom tabs (Charts with tabs)-->
            <div class="nav-tabs-custom" style="cursor: move;">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
                    <li><a href="#sales-chart" data-toggle="tab">Donut</a></li>
                    <li class="pull-left header"><i class="fa fa-inbox"></i> Sales</li>
                </ul>
                <div class="tab-content no-padding">
                    <!-- Morris chart - Sales -->
                    <div class="chart tab-pane active" id="revenue-chart"
                         style="position: relative; height: 300px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                        <svg height="300" version="1.1" width="722" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink"
                             style="overflow: hidden; position: relative; top: -0.8px;">
                            <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.2.0
                            </desc>
                            <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                            <text x="49.203125" y="261.40625" text-anchor="end" font-family="sans-serif"
                                  font-size="12px" stroke="none" fill="#888888"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                  font-weight="normal">
                                <tspan dy="4.40625" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan>
                            </text>
                            <path fill="none" stroke="#aaaaaa" d="M61.703125,261.40625H697.025" stroke-width="0.5"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                            <text x="49.203125" y="202.3046875" text-anchor="end" font-family="sans-serif"
                                  font-size="12px" stroke="none" fill="#888888"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                  font-weight="normal">
                                <tspan dy="4.4140625" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">7,500
                                </tspan>
                            </text>
                            <path fill="none" stroke="#aaaaaa" d="M61.703125,202.3046875H697.025" stroke-width="0.5"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                            <text x="49.203125" y="143.203125" text-anchor="end" font-family="sans-serif"
                                  font-size="12px" stroke="none" fill="#888888"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                  font-weight="normal">
                                <tspan dy="4.40625" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">15,000
                                </tspan>
                            </text>
                            <path fill="none" stroke="#aaaaaa" d="M61.703125,143.203125H697.025" stroke-width="0.5"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                            <text x="49.203125" y="84.1015625" text-anchor="end" font-family="sans-serif"
                                  font-size="12px" stroke="none" fill="#888888"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                  font-weight="normal">
                                <tspan dy="4.4140625" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">22,500
                                </tspan>
                            </text>
                            <path fill="none" stroke="#aaaaaa" d="M61.703125,84.1015625H697.025" stroke-width="0.5"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                            <text x="49.203125" y="25.00000000000003" text-anchor="end" font-family="sans-serif"
                                  font-size="12px" stroke="none" fill="#888888"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                  font-weight="normal">
                                <tspan dy="4.406250000000028" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                    30,000
                                </tspan>
                            </text>
                            <path fill="none" stroke="#aaaaaa" d="M61.703125,25.00000000000003H697.025"
                                  stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                            <text x="580.4592610874847" y="273.90625" text-anchor="middle" font-family="sans-serif"
                                  font-size="12px" stroke="none" fill="#888888"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                  font-weight="normal" transform="matrix(1,0,0,1,0,6.7969)">
                                <tspan dy="4.40625" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2013</tspan>
                            </text>
                            <text x="297.92243696840825" y="273.90625" text-anchor="middle" font-family="sans-serif"
                                  font-size="12px" stroke="none" fill="#888888"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                  font-weight="normal" transform="matrix(1,0,0,1,0,6.7969)">
                                <tspan dy="4.40625" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2012</tspan>
                            </text>
                            <path fill="#74a5c2" stroke="none"
                                  d="M61.703125,219.38897916666667C79.45817132442284,219.90119270833333,114.96826397326853,222.963638671875,132.72331029769137,221.43783333333334C150.4783566221142,219.91202799479169,185.9884492709599,209.45255319330602,203.74349559538274,207.18253645833335C221.30555228584444,204.937193818306,256.4296656667679,205.191798828125,273.9917223572296,203.37639583333333C291.55377904769136,201.56099283854167,326.67789242861477,195.20540565943762,344.2399491190765,192.6593125C361.99499544349936,190.0852402948543,397.50508809234503,182.78836653645834,415.26013441676787,182.89573437500002C433.0151807411907,183.0031022135417,468.52527339003643,204.48901235200367,486.28031971445927,193.51825520833336C503.84237640492097,182.66674542492035,538.9664897858444,102.07640478245858,556.5285464763061,95.60666666666668C573.8976135328068,89.20802457412525,608.635747645808,135.32761448317308,626.0048147023086,142.04473437500002C643.7598610267314,148.91112359775641,679.2699536755772,147.9667109375,697.025,149.94070312500003L697.025,261.40625L61.703125,261.40625Z"
                                  fill-opacity="1"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></path>
                            <path fill="none" stroke="#3c8dbc"
                                  d="M61.703125,219.38897916666667C79.45817132442284,219.90119270833333,114.96826397326853,222.963638671875,132.72331029769137,221.43783333333334C150.4783566221142,219.91202799479169,185.9884492709599,209.45255319330602,203.74349559538274,207.18253645833335C221.30555228584444,204.937193818306,256.4296656667679,205.191798828125,273.9917223572296,203.37639583333333C291.55377904769136,201.56099283854167,326.67789242861477,195.20540565943762,344.2399491190765,192.6593125C361.99499544349936,190.0852402948543,397.50508809234503,182.78836653645834,415.26013441676787,182.89573437500002C433.0151807411907,183.0031022135417,468.52527339003643,204.48901235200367,486.28031971445927,193.51825520833336C503.84237640492097,182.66674542492035,538.9664897858444,102.07640478245858,556.5285464763061,95.60666666666668C573.8976135328068,89.20802457412525,608.635747645808,135.32761448317308,626.0048147023086,142.04473437500002C643.7598610267314,148.91112359775641,679.2699536755772,147.9667109375,697.025,149.94070312500003"
                                  stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                            <circle cx="61.703125" cy="219.38897916666667" r="4" fill="#3c8dbc" stroke="#ffffff"
                                    stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="132.72331029769137" cy="221.43783333333334" r="4" fill="#3c8dbc"
                                    stroke="#ffffff" stroke-width="1"
                                    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="203.74349559538274" cy="207.18253645833335" r="4" fill="#3c8dbc"
                                    stroke="#ffffff" stroke-width="1"
                                    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="273.9917223572296" cy="203.37639583333333" r="4" fill="#3c8dbc" stroke="#ffffff"
                                    stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="344.2399491190765" cy="192.6593125" r="4" fill="#3c8dbc" stroke="#ffffff"
                                    stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="415.26013441676787" cy="182.89573437500002" r="4" fill="#3c8dbc"
                                    stroke="#ffffff" stroke-width="1"
                                    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="486.28031971445927" cy="193.51825520833336" r="4" fill="#3c8dbc"
                                    stroke="#ffffff" stroke-width="1"
                                    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="556.5285464763061" cy="95.60666666666668" r="4" fill="#3c8dbc" stroke="#ffffff"
                                    stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="626.0048147023086" cy="142.04473437500002" r="4" fill="#3c8dbc" stroke="#ffffff"
                                    stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="697.025" cy="149.94070312500003" r="4" fill="#3c8dbc" stroke="#ffffff"
                                    stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <path fill="#eaf3f6" stroke="none"
                                  d="M61.703125,240.39761458333334C79.45817132442284,240.17696875000001,114.96826397326853,241.72739973958332,132.72331029769137,239.51503125C150.4783566221142,237.30266276041667,185.9884492709599,223.67818086862476,203.74349559538274,222.69866666666667C221.30555228584444,221.7297993582081,256.4296656667679,233.59108463541665,273.9917223572296,231.72150520833333C291.55377904769136,229.85192578125,326.67789242861477,209.60629261298953,344.2399491190765,207.74203125C361.99499544349936,205.8572834984062,397.50508809234503,214.76526692708333,415.26013441676787,216.72546875C433.0151807411907,218.68567057291668,468.52527339003643,232.7364588171676,486.28031971445927,223.42364583333335C503.84237640492097,214.21205907758426,538.9664897858444,148.43894657142036,556.5285464763061,142.62786979166668C573.8976135328068,136.88065099850368,608.635747645808,170.720790851076,626.0048147023086,177.19046354166667C643.7598610267314,183.80390673649268,679.2699536755772,190.51786588541665,697.025,194.96033333333332L697.025,261.40625L61.703125,261.40625Z"
                                  fill-opacity="1"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></path>
                            <path fill="none" stroke="#a0d0e0"
                                  d="M61.703125,240.39761458333334C79.45817132442284,240.17696875000001,114.96826397326853,241.72739973958332,132.72331029769137,239.51503125C150.4783566221142,237.30266276041667,185.9884492709599,223.67818086862476,203.74349559538274,222.69866666666667C221.30555228584444,221.7297993582081,256.4296656667679,233.59108463541665,273.9917223572296,231.72150520833333C291.55377904769136,229.85192578125,326.67789242861477,209.60629261298953,344.2399491190765,207.74203125C361.99499544349936,205.8572834984062,397.50508809234503,214.76526692708333,415.26013441676787,216.72546875C433.0151807411907,218.68567057291668,468.52527339003643,232.7364588171676,486.28031971445927,223.42364583333335C503.84237640492097,214.21205907758426,538.9664897858444,148.43894657142036,556.5285464763061,142.62786979166668C573.8976135328068,136.88065099850368,608.635747645808,170.720790851076,626.0048147023086,177.19046354166667C643.7598610267314,183.80390673649268,679.2699536755772,190.51786588541665,697.025,194.96033333333332"
                                  stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                            <circle cx="61.703125" cy="240.39761458333334" r="4" fill="#a0d0e0" stroke="#ffffff"
                                    stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="132.72331029769137" cy="239.51503125" r="4" fill="#a0d0e0" stroke="#ffffff"
                                    stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="203.74349559538274" cy="222.69866666666667" r="4" fill="#a0d0e0"
                                    stroke="#ffffff" stroke-width="1"
                                    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="273.9917223572296" cy="231.72150520833333" r="4" fill="#a0d0e0" stroke="#ffffff"
                                    stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="344.2399491190765" cy="207.74203125" r="4" fill="#a0d0e0" stroke="#ffffff"
                                    stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="415.26013441676787" cy="216.72546875" r="4" fill="#a0d0e0" stroke="#ffffff"
                                    stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="486.28031971445927" cy="223.42364583333335" r="4" fill="#a0d0e0"
                                    stroke="#ffffff" stroke-width="1"
                                    style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="556.5285464763061" cy="142.62786979166668" r="4" fill="#a0d0e0" stroke="#ffffff"
                                    stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="626.0048147023086" cy="177.19046354166667" r="4" fill="#a0d0e0" stroke="#ffffff"
                                    stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                            <circle cx="697.025" cy="194.96033333333332" r="4" fill="#a0d0e0" stroke="#ffffff"
                                    stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                        </svg>
                        <div class="morris-hover morris-default-style"
                             style="left: 230.967px; top: 146px; display: none;">
                            <div class="morris-hover-row-label">2011 Q4</div>
                            <div class="morris-hover-point" style="color: #a0d0e0">
                                Item 1:
                                3,767
                            </div>
                            <div class="morris-hover-point" style="color: #3c8dbc">
                                Item 2:
                                3,597
                            </div>
                        </div>
                    </div>
                    <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                        <svg height="342" version="1.1" width="512" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative;">
                            <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.2.0
                            </desc>
                            <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                            <path fill="none" stroke="#3c8dbc"
                                  d="M376.0125,243.33333333333331A93.33333333333333,93.33333333333333,0,0,0,464.24025519497707,180.44625304313007"
                                  stroke-width="2" opacity="0"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path>
                            <path fill="#3c8dbc" stroke="#ffffff"
                                  d="M376.0125,246.33333333333331A96.33333333333333,96.33333333333333,0,0,0,467.07614732624415,181.4248826052307L503.6276459070204,194.03833029452744A135,135,0,0,1,376.0125,285Z"
                                  stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                            <path fill="none" stroke="#f56954"
                                  d="M464.24025519497707,180.44625304313007A93.33333333333333,93.33333333333333,0,0,0,292.2973462783141,108.73398312817662"
                                  stroke-width="2" opacity="1"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path>
                            <path fill="#f56954" stroke="#ffffff"
                                  d="M467.07614732624415,181.4248826052307A96.33333333333333,96.33333333333333,0,0,0,289.60650205154565,107.40757544301087L250.43976941747115,88.10097469226493A140,140,0,0,1,508.35413279246563,195.6693795646951Z"
                                  stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                            <path fill="none" stroke="#00a65a"
                                  d="M292.2973462783141,108.73398312817662A93.33333333333333,93.33333333333333,0,0,0,375.9831784690488,243.333328727518"
                                  stroke-width="2" opacity="0"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path>
                            <path fill="#00a65a" stroke="#ffffff"
                                  d="M289.60650205154565,107.40757544301087A96.33333333333333,96.33333333333333,0,0,0,375.9822359912682,246.3333285794739L375.9700884998742,284.9999933380171A135,135,0,0,1,254.9245097954186,90.31165416754118Z"
                                  stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                            <text x="376.0125" y="140" text-anchor="middle" font-family="&quot;Arial&quot;"
                                  font-size="15px" stroke="none" fill="#000000"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 15px; font-weight: 800;"
                                  font-weight="800" transform="matrix(1,0,0,1,0,0)">
                                <tspan dy="140" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">In-Store Sales
                                </tspan>
                            </text>
                            <text x="376.0125" y="160" text-anchor="middle" font-family="&quot;Arial&quot;"
                                  font-size="14px" stroke="none" fill="#000000"
                                  style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 14px;"
                                  transform="matrix(1,0,0,1,0,0)">
                                <tspan dy="160" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">30</tspan>
                            </text>
                        </svg>
                    </div>
                </div>
            </div>
            <!-- /.nav-tabs-custom -->
            <?php } ?>

        </section>
        <!-- /.right col -->

    </div>
    <!-- /.row (main row) -->
</section>