<?php
/* @var $this yii\web\View */

$this->title = Yii::t('backend', 'Appointment');
$this->params['breadcrumbs'][] = $this->title;

$url = \yii\helpers\Url::to(['site/all']);
$link = \yii\helpers\Url::to(['appointment/create']);
$urlEmployee = \yii\helpers\Url::to(['site/employees']);
$script = <<< SCRIPT

        // page is now ready, initialize the calendar...
        
        $('#calendar').fullCalendar({
            height: 540,
            minTime: "08:00:00",
            maxTime: "21:00:00",
            slotDuration: '00:30:00', 
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            locale: 'vi',
            resourceLabelText: 'Nhân viên',
            header: {
              left: 'prev,next',
              center: 'title',
              right: 'timelineDay,timelineMonth,timelineYear'
            },
    
            defaultView: 'timelineDay',
            //defaultView: 'pastAndFutureView',
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectHelper: true,
            
            select: function(start, end,allDay,ev,resource ) {
                $('#modal').modal('show')
                .find('#modalContent')
                .load('$link' + '?start='+start+'&end='+end+'&employee='+resource.id);
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
                    custom_param1: '',
                    custom_param2: ''
                  },
                  error: function() {
                    alert('Không có dữ liệu!');
                  },
                  color: 'yellow',   // a non-ajax option
                  textColor: 'black' // a non-ajax option
                }
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
<section class="content">
    <h2>Lịch hẹn</h2>
    <div class="box box-primary">
        <div class="box-body no-padding">
            <!-- THE CALENDAR -->
            <div id='calendar'></div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /. box -->


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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>