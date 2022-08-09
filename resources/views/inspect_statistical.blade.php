<link rel="stylesheet" href="/jquerycalendar/css/Calendar.css">

<div class="mui-content">
    <div class="duty-list">
        <div id="calendar" class="statistical{{$id}}" ></div>
    </div>
</div>
<script src="/jquerycalendar/js/calendar/calendar.js"></script>
<script>
    Dcat.ready(function () {
        var data=JSON.parse(decodeURIComponent("{{$date}}"))
        $(".statistical{{$id}}").calendar({
            data: data,
            mode: "month",
            maxEvent: 5,
            showModeBtn: false,
             newDate: "{{$now_date}}",
            cellClick: function (events) {
            },
        })


        //  if(spantxt="请假"){
        // 	$(this).find(".calendar-date").css("color","red");
        // }
        // if(spantxt="巡查"){
        // 	$(this).find(".calendar-date").css("color","red");
        // }


    })
</script>

