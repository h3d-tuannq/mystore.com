<?php
/* @var $this yii\web\View */

$this->title = Yii::t('backend', 'Chấm công');
$this->params['breadcrumbs'][] = $this->title;

$url = \yii\helpers\Url::to(['activity/all-timekeeping']);
$link = \yii\helpers\Url::to(['activity/create-timekeeping']);
$linkUpdate = \yii\helpers\Url::to(['employee-timesheet/update']);
$urlEmployee = \yii\helpers\Url::to(['activity/get-employee']);
$script = <<< SCRIPT

        // page is now ready, initialize the calendar...
        
        $('#calendar').fullCalendar({
            height: 560,
            minTime: "08:00:00",
            maxTime: "21:00:00",
            slotDuration: '1:00:00', 
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            locale: 'vi',
            resourceLabelText: 'Nhân viên',
            header: {
              left: 'prev,next',
              center: 'title',
              right: 'timelineWeek'
            },
    
            //defaultView: 'month',
            defaultView: 'timelineWeek',
            //defaultView: 'pastAndFutureView',
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectHelper: true,
            
            select: function(start, end,allDay,ev,resource ) {
                $('#modal').modal('show')
                .find('#modalContent')
                .load('$link' + '?start='+start+'&end='+end+'&employee='+resource.id);
                document.getElementById('modalHeader').innerHTML = "<h2>Chấm công<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button></h2>";
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
            ],
        viewRender: function (view, element) {
            //var b = $('#calendar').fullCalendar('getDate');
            //alert(b.format('L'));
        },
        eventClick: function(event, element) {
            $('#modal').modal('show')
                .find('#modalContent')
                .load('$linkUpdate' + '?id='+event.timesheet_id);
            document.getElementById('modalHeader').innerHTML = "<h2>Cập nhật chấm công<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button></h2>";  
        },
        
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

    <div class="box box-primary">
        <div class="box-body no-padding">
            <!-- THE CALENDAR -->
            <div id='calendar'></div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /. box -->


</section>