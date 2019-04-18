@extends('layouts.end_user')
@section('breadcrumbs')
        {!! Breadcrumbs::render('bookings') !!}
@endsection
@section('content')
<div class="row mb-5">
  <div class="col-5 pr-0 ">
      <form >
          <div class="input-group col-7 float-left">
            <div class="input-group-prepend">
              <span class="input-group-text" id="year"></span>
            </div>
            <select name="month" onChange="" id="month"
                    class=" mr-1 browser-default custom-select form-control float-right">
            </select>
          </div>
          <div class="input-group col-5">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">Ngày</span>
            </div>
             <select name="date" onChange="" id="date"
                  class=" mr-1 browser-default custom-select form-control float-left">
            </select>
          </div>
      </form> 
    </div>
    <div class="col-6 mt-2">
      <i class="fa fa-circle text-primary ml-3"></i> Phòng họp 01 
      <i class="fa fa-circle text-success ml-3"></i> Phòng họp 02 
      <i class="fa fa-circle text-warning ml-3"></i> Phòng họp 03 

    </div> 
</div>

    <div id="calendar">
    </div>

@endsection

@push('extend-js')
    <link href="{{ asset('fullcalendar/fullcalendar.min.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/locales/vi.js') }}"></script>
    <script >
        window.addEventListener("load", function () {
    // selectMonths= {"01":"Tháng 1" , "02": "Tháng 2", "03":"Tháng 3", "04":"Tháng 4", "05":"Tháng 5", "06":"Tháng 6", "07": "Tháng 7", "08":"Tháng 8", "09":"Tháng 9","10":"Tháng 10", "11":"Tháng 11", "12":"Tháng 12"};
    var currentYear= new Date().getFullYear();
    var currentMonth= new Date().getMonth()+1;
    var currentDate= new Date().getDate();
    $('#year').text(currentYear);
    
     for(var i=1;i<=12;i++) {
      var text= (i<10)? "Tháng 0"+i : "Tháng "+i ;
      
       $('#month')
            .append($('<option>', { value : i })
            .text(text));
    };
    $('#month option[value='+currentMonth+']').attr('selected', 'selected');
    var i;
    for(i=1;i<=31;i++){
     var text = (i<10)? "0"+i: i;
      $('#date').append($('<option>', { value : i })
          .text(text));
    }
    $('#date option[value='+currentDate+']').attr('selected', 'selected');
   
  });

    </script>
    <script>
        $(function () {
            window.start_date = null;
            window.end_date = null;
            var $calendar = $('#calendar');
            var $month = $('#month');
            var $date= $('#date');

            function renderCalendar() {
                var data = {
                    start: window.start_date,
                    end: window.end_date,
                }, 
                month = $month.children("option:selected").val();
                date= $date.children("option:selected").val();
                data.month=month;
                data.date=date;
                $.ajax({
                    url: '{{route('getCalendarBooking')}}',
                    method: 'GET',
                    dataType: 'JSON',
                    data: data,
                    success: function (response) {
                        if (response.code == 200 && response.data.bookings) {
                            $calendar.fullCalendar('removeEvents');
                            var bookings = response.data.bookings;
                            $calendar.fullCalendar('addEventSource', bookings);
                            $calendar.fullCalendar('rerenderEvents');
                        }
                    }
                });
            }

            $month.change(function () {
                renderCalendar();
            });
            $date.change(function () {
                renderCalendar();
            });

            $calendar.fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                defaultView:'agendaWeek',
                allDaySlot: false,
                minTime: "08:00",
                maxTime: "18:30",

                defaultDate: '{{date('Y-m-d')}}',
                locale: 'vi',
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                height: 650,
                eventRender: function (eventObj, $el) {
                    $el.popover({
                        title: eventObj.title,
                        content: eventObj.description,
                        trigger: 'hover',
                        placement: 'top',
                        container: 'body'
                    });
                },
                viewRender: function (newView, oldView) {
                    window.start_date = newView.start.format('Y/M/D');
                    window.end_date = newView.end.format('Y/M/D');

                    renderCalendar();
                },
                eventClick: function (calEvent, jsEvent, view) {
                    window.open('/su-kien/' + calEvent.id);
                }
            });
        });
    </script>
@endpush