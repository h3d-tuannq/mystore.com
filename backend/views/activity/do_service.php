<?php
/* @var $this yii\web\View */

$this->title = 'Làm dịch vụ';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Danh sách lịch làm dịch vụ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$url = \yii\helpers\Url::to(['activity/all']);
$urlEmployee = \yii\helpers\Url::to(['activity/get-employee']);
$script = <<< SCRIPT
    //alert("Hi");

        // page is now ready, initialize the calendar...
        
        //$('#calendar').fullCalendar();
        
        $('#calendar').fullCalendar({
            height: 560,
            minTime: "08:00:00",
            maxTime: "21:00:00",
            slotDuration: '00:15:00', 
            //snapDuration: '00:15:00',
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            locale: 'vi',
            resourceLabelText: 'Nhân viên',
            header: {
              left: 'prev,next',
              center: 'title',
              right: 'timelineDay, timelineWeek'
            },
    
            //defaultView: 'month',
            defaultView: 'timelineWeek',
            //defaultView: 'pastAndFutureView',
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectHelper: true,
            
            select: function(start, end ) {
                var title = prompt('Số giường:');
                var eventData;
                
                if (title) {
                  eventData = {
                    resourceIds: ['1'],
                    title: title,
                    start: start,
                    end: end
                  };
                  //console.log(eventData);
                   //$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                   $('#calendar').fullCalendar( 'renderEvent', eventData , 'stick');
                   console.log('Render');
                }
                    //$('#calendar').fullCalendar('unselect');
            },
          
            editable: true,
            eventLimit: true,
            resourceRender: function(resourceObj, td) {
                td.eq(0).find('.fc-cell-content')
            },
            resources: '$urlEmployee',
            eventSources: [
                // your event source
                {
                  url: '$url',
                  type: 'POST',
                  data: {
                    custom_param1: 'something',
                    custom_param2: 'somethingelse'
                  },
                  error: function() {
                    alert('Không có dữ liệu!');
                  },
                  color: 'yellow',   // a non-ajax option
                  textColor: 'black' // a non-ajax option
                }
                
                // any other sources...
                
            ],
        viewRender: function (view, element) {
            //var b = $('#calendar').fullCalendar('getDate');
            //alert(b.format('L'));
        },
        
        eventClick: function(event, element) {
            console.log(event);
            $('#modalTitle').html(event.title);
            $('#modalBody').html(event.description);
            $('#eventUrl').attr('href',event.url);
            $('#lnk_update').attr('href','update?id='+event.activity_id);
            $('#calendarModal').modal();
          }
        }); 
           
           
    $("#btn-do-service").on('click',function(){
        $('#modal-do-service').modal('show');
    }); 
SCRIPT;

$this->registerJsFile("@web/js/fullcalendar.min.js", [
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
$this->registerJsFile("@web/js/scheduler.js", [
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
$this->registerCssFile("@web/css/fullcalendar.min.css");
$this->registerCssFile("@web/css/scheduler.css");
$this->registerJsFile("@web/js/moment.min.js");
$this->registerJsFile("@web/js/locale/vi.js", [
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
$this->registerJs($script, \yii\web\View::POS_READY);
$this->registerCss('
.fc-widget-header:first-of-type, .fc-widget-content:first-of-type {
    width: 178px;
}
');
?>

<section class="content" style="min-height: 1200px">
    <div class="row">
        <div class="col-md-3">

            <!-- /. box -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Thêm mới</h3>
                    <div class="pull-right">
                        <?php echo \yii\helpers\Html::a('Danh sách', ['index'], ['class' => 'btn btn-primary btn-sm']) ?>
                    </div>
                </div>
                <div class="box-body">
                    <?php echo $this->render('_form', [
                        'model' => $model,
                        'customers' => $customers,
                        'services' => $services,
                    ]) ?>
                    <!-- /input-group -->
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-body no-padding">
                    <!-- THE CALENDAR -->
                    <div id='calendar'></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>

</section>

<div id="calendarModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 id="modalTitle" class="modal-title"></h4>
            </div>
            <div id="modalBody" class="modal-body"> </div>
            <div class="modal-footer">
                <a id="lnk_update" href="#" class="btn btn-primary">Edit</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>