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

    <div id="calendar-meeting">
    </div>

    <!-- add booking -->
    <form name="addBooking" action="" id="addBooking" method="post">
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 450px;padding: 5px;margin-top: 100px;font-size: 13px;">
                
                <div class="modal-body">
                    <h4 class="text-center font-weight-bold ">Đặt lịch họp</h4>
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" >
                    <input type="hidden" name="color" id="color" value="" >
                    <input type="hidden" name="days_repeat" id="days_repeat" value="">
                    <div class="title">
                    <lable class="m-3">Tiêu đề *</lable>
                    <input type="text" class="form-control mt-2 mb-3" name="title" id="title" placeholder="Tiêu đề cuộc họp..." >
                    </div>
                    <div class="content">
                    <lable class="ml-3 mt-1">Nội dung *</lable>
                    <textarea  class="form-control mt-2" name="content" id="content" placeholder="Nội dung cuộc họp ..." ></textarea>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6 users_id">
                            <label class="ml-3">Chọn đối tượng *</label>
                            <select class=" selectpicker form-control" multiple data-live-search="true" name="participants" id="participants" data-none-selected-text title="Chọn đối tượng"  >
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                             @endforeach   
                            </select>
                        </div>
                        <div class="col-6 meetings_id">
                            <label class="ml-3">Chọn phòng họp *</label>
                            <select class="form-control browser-default" name="meetings_id" id="meetings_id" >
                                <option value="">Chọn phòng họp</option>
                                @foreach($meetings as $meeting)
                                <option value="{{$meeting->id}}">{{$meeting->name}}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6 start_time">
                            
                            <label class="ml-3">Thời gian bắt đầu *</label>
                            <div class="  timepicker">
                                <input class="form-control"  name="start" id="start_time" data-format="hh:mm" data-provide="timepicker"  >
                            </div>
                        </div>
                        <div class="col-6 mb-1 end_time" >
                            <label class="ml-3">Thời gian kết thúc *</label>
                            <div class=" bootstrap-timepicker timepicker">
                                <input class="form-control  timepicker "   name="end" id="end_time" data-format="hh:mm" data-provide="timepicker">
                            </div>
                        </div>
                    </div>
                    <div id="#repeat">
                        <lable class="mr-5">Chọn định kỳ: </lable>
                        <input type="radio" name="repeat_type" id="non_repeat" value="0" checked style="display: none;">
                        <label class="radio-inline">
                              <input type="radio" name="repeat_type" id="year" value="3"><span>Năm</span>
                        </label>
                        <label class="radio-inline">
                              <input type="radio" name="repeat_type" id="month" value="2"><span>Tháng</span>
                        </label>
                        <label class="radio-inline">
                              <input type="radio" name="repeat_type" id="week" value="1"><span>Tuần</span>
                        </label>
                    </div>
                    </br>
                    <div class="mt-0">
                    <input type="checkbox" name="is_notify" class="" value="1" checked="true" id="is_notify"><span> Chọn thông báo cho các thành viên</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="booking" >Lưu</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- show modal -->
<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        
        <div class="modal-content" style="width: 450px;padding: 5px;margin-top: 100px;font-size: 13px;">
        
            <div class="modal-body">
                <h4 class="text-center font-weight-normal ">Lịch họp</h4>
                <input type="hidden" name="id" id="id_booking" value="">
                <input type="hidden" name="start_date" id="start_date" value="">
                <h6 class="font-weight-normal ">Tiêu đề:</h6>
                <p id="show-title"></p>
                
                <h6 class="font-weight-normal">Nội dung:</h6>
                <p id="show-content"></p>
                <h6 class="font-weight-normal">Đối tượng:</h6>
                <p id="show-object"></p>
                <h6 class="font-weight-normal">Phòng họp:</h6>
                <p id="show-meeting"></p>
                <h6 class ="font-weight-normal">Thời gian:</h6>
                <p id="time"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="edit" >Sửa lịch</button>
                <button class="btn btn-danger" id="deleteMessage" >Hủy lịch</button>
            </div>       
        </div>
    </div>
</div>
<!-- delete modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        
        <div class="modal-content" style="width: 450px;padding: 5px;margin-top: 100px;font-size: 13px;">
            
            <div class="modal-body">
                <h6>Bạn có chắc chắn muốn xóa buổi họp này không?</h6>
            </div>
            <div class="modal-footer">
               <button class="btn btn-white" id="cancel"  >Hủy</button>
                <button class="btn btn-danger" id="delete" >Xóa</button>
            </div>       
        </div>
    </div>
</div>
<!-- success modal -->
<div class="modal fade" id="deleteSuccessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        
        <div class="modal-content" style="width: 450px;padding: 5px;margin-top: 100px;font-size: 13px;">
        
            <div class="modal-body">
                <h6 id="message" class="text-center"></h6>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="ok" >OK</button>
            </div>       
        </div>
    </div>
</div>
@endsection
@push('extend-css')
<style >
 #addModal .modal-content{
        font-weight: normal;
        margin-left: 10%;
       width: 450px;
       padding: 5px;
       margin-top: 100px;
       font-size: 13px;
       color:#000;
    }
    .modal-footer{
        margin:auto!important;
        border: none!important;
    }
    .modal-header{
        border: none!important;
    }
    
    .close{
        height: 0.5px !important;
        width: 0.5px!important;
        background: #ccc!important; 
        border: 0.1px solid #ccc !important;
        border-radius: 50% !important
    }
    #showModal .modal-content{
       width: 450px;
       padding: 5px;
       margin-top: 100px;
        margin-left: 10%;
    }
    #deleteModal .modal-content{
        width: 450px;
        padding: 5px;
        margin-top: 300px!important;
        margin: auto;
    }
    #deleteSuccessModal .modal-content{
        width: 450px;
        padding: 5px;
        margin-top: 300px!important;
        margin: auto;
    }
    select, option{
        font-size: 13px!important;
    }
    input, input::-webkit-input-placeholder {
    font-size: 13px;
    color: #ccc;
    padding: 5px;
    }
    .form-control{
        border: -2px solid #dedede75;
    }
    textarea{
        height: 100px !important;
    }
    textarea, textarea::-webkit-input-placeholder{
        color: #ccc;
        font-size: 13px;
        padding: 5px;
    }
    input[type="radio"]{
        position: relative !important;
        opacity:1 !important;
        margin: 3px !important;
        vertical-align:middle!important;
        pointer-events: auto!important;
    }
    input[type="checkbox"]{
        position: relative !important;
        opacity:1 !important;
        margin: 3px !important;
        vertical-align:middle!important;
        pointer-events: auto!important;
    }

    span{
        margin-right: 10px;
    }
    
    /*.btn-light.dropdown-toggle{
        background: #fff !important;
        box-shadow: none !important;
        border: 2px solid #ccc;
        border-radius: .25rem;
        height: calc(2.25rem + 2px);
    }*/
    
    .btn-light.dropdown-toggle{
        height: calc(2.25rem)!important;
        margin-top: 0!important;
        padding: 0 10px!important;
        font-size: 1rem!important;
        line-height: 1.5!important;
        color: #495057!important;
        background-color: #fff!important;
        background-clip: padding-box!important;
        border: 2px solid #dedede75;
        border-radius: .25rem!important;
        transition: none!important;
        box-shadow: none!important;
        position: relative!important;
        margin-left: 0px!important;

    }
    .filter-option-inner-inner{
        font-size: 13px!important;
        text-transform: none;
    }
    .dropdown-toggle.bs-placeholder:active {
    background: #fff!important;
     transition: none!important;
     box-shadow: none!important;
}
    .dropdown-menu {
        position: absolute;
        top: 0!important;
        height: 200px!important;
    }
    .fc-event-container{
        text-align: center;
    }
    .fc-content .fc-time{
       
        font-size: 13px !important;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .input-group-prepend{
        margin-right: -10px!important;
    }
</style>
@endpush
@push('extend-js')
    <link rel="stylesheet" type="text/css" href="{{asset('mdb/css/bootstrap.css')}}">
    <script type="text/javascript" src="{{asset('mdb/js/bootstrap.js')}}"></script>
    <link href="{{asset('bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
    <script src="{{asset('bootstrap-select/js/bootstrap-select.js')}}" type="text/javascript"></script>
    <link href="{{asset('bootstrap-datetimepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" />
    <script src="{{asset('bootstrap-datetimepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
    <link href="{{ asset('fullcalendar/fullcalendar.min.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="">
        $(document).ready(function () {
            $('.selectpicker').selectpicker();
        });
        $('#start_time').timepicker({
            // 12 or 24 hour
              showInputs: false,
                showMeridian: false 
            });
         $('#end_time').timepicker({
            // 12 or 24 hour
             showInputs: false,
            showMeridian: false 
            });

    </script>
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
            var $calendar = $('#calendar-meeting');
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
                maxTime: "19:00",

                defaultDate: '{{date('Y-m-d')}}',
                locale: 'vi',
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                height: 570,
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
                selectable:true,
                select: function (start, end, allDay=false) {
                    
                        //do something when space selected
                        $('#start_time').val(moment(start).format('HH:mm'));
                        $('#end_time').val(moment(end).format(' HH:mm'));
                        $('#days_repeat').val(moment(start).format('YYYY-MM-DD'));
                        //Show 'add event' modal
                        $('#addModal').modal('show');
                        
                      
                },
                eventClick: function(calEvent, jsEvent, view) {
                    console.log(calEvent.start);
                    // 
                    $.ajax({
                        url:'get-booking/'+calEvent.id,
                        data:{'start_date':calEvent.start.format('YYYY-MM-DD HH:mm:00')},
                        type:'GET',
                        success:function(data){
                            $('#id_booking').val(calEvent.id);
                            $('#start_date').val(calEvent.start.format('YYYY-MM-DD HH:mm:00'));
                            $('#show-title').text(data.booking.title);
                            $('#show-content').text(data.booking.content);
                            $('#show-object').text(data.participants);
                            $('#show-meeting').text(data.meeting);
                            $('#time').text(moment(calEvent.start).format('HH:mm')+ '-' + moment(calEvent.end).format('HH:mm'));
                            $('#showModal').modal();
                        }
                    });
                    // 

                    
                },
            });
        });

        $('#booking').click(function(event){
            event.preventDefault();
            var repeat_type= $('[name="repeat_type"]:checked').val();
            var days_repeat=$('#days_repeat').val();
            var participants = [];
            $.each($(".selectpicker option:selected"), function(){            
                participants.push($(this).val());
            });
            participants= participants.toString();
            var meetings_id= $('#meetings_id').val();
            if(meetings_id==1) $('#color').val('blue');
            else if(meetings_id==2) $('#color').val('green');
            else if(meetings_id==3) $('#color').val('orange');
            var start_time= $('#start_time').val();
            var end_time= $('#end_time').val();
            var title= $('#title').val();
            var content= $('#content').val();
            var is_notify=$('input[name="is_notify"]:checked').val();
            is_notify= (is_notify)?is_notify:"0"; 
            var _token= $('#_token').val();
            var color= $('#color').val();
            var id=$('#id').val();
            if(id>0) var url= '/sua-phong-hop/'+id;
            else var url='/them-phong-hop';
                $.ajax({
                    url:url,
                    type:"post",
                    data:{
                        "_token":_token,
                        "participants":participants,
                        "meetings_id":meetings_id,
                        "title":title,
                        "content":content,
                        "start_time":start_time,
                        "end_time":end_time,
                        "repeat_type":repeat_type,
                        "is_notify": is_notify,
                        "days_repeat":days_repeat,
                        "color":color
                        
                    },
                    
                    success: function(data){
                        if(data.status==422){
                            alert("Vui lòng không để trống các trường có viền đỏ!")
                            if(data.errors.participants){
                                $('.btn-light').css("border","1px solid red");
                                $('.selectpicker').change(function(){
                                    $('.btn-light').css("border","1px solid #ccc");
                                });

                            }
                            $.each(data.errors, function (i, error) {
                                var el = $('#'+i);
                                el.css("border","1px solid red");
                                 el.change(function(){
                                    $(this).css("border","1px solid #ccc    ");
                                });
                            });    
                        }
                        else if(data.status==500){
                            if(data.duplicate){
                                $('#meetings_id').css("border","1px solid red");
                                alert("Phòng hoặc thời gian bạn chọn cho cuộc họp đã được đặt, vui lòng chọn lại!");
                            }
                        }
                        else if(data.success){
                            console.log(data.success)
                                location.reload();
                        }
                    },
            });
        
          });

        $('#edit').click(function(){
            var id=$('#id_booking').val();
            $.ajax({
                url:'get-booking/'+id,
                data:{'start_date':$('#start_date').val()},
                type:'GET',
                success:function(data){
                    var booking=data.booking;
                    $('#id').val(id);
                    $('#title').val(booking.title);
                    $('#content').val(booking.content);
                    $('#participants').val(booking.participants);
                    $('.selectpicker').selectpicker('refresh');
                    $('#meetings_id').val(booking.meetings_id);
                    $('#start_time').val((booking.start_time.substring(0,5)));
                    $('#end_time').val(booking.end_time.substring(0,5));
                    $('#days_repeat').val(booking.date);
                    (booking.is_notify==0)? $('input[name="is_notify"]').attr('checked', false): $('input[name="is_notify"]').attr('checked', true);
                   
                    if(data.type=='PAST'){
                        $('#repeat').css('display','none');
                    }
                    else{
                       $('input:radio[name="repeat_type"]').filter('[value='+booking.repeat_type+']').attr('checked', true);
                    }
                    $('#showModal').modal('hide');
                    $('#addModal').modal();
                }
            });
        });
        $('#deleteMessage').click(function(){
            $('#showModal').modal('hide');
            $('#deleteModal').modal();
        });

        $('#delete').click(function(){
            var id=$('#id_booking').val();
            $.ajax({
                url:'delete-booking/'+id,
                data:{'start_date':$('#start_date').val()},
                type:'GET',
                success:function(data){
                    $('#deleteModal').modal('hide');
                    $('#message').text('Bạn đã xóa thành công buổi họp!')
                            $('#deleteSuccessModal').modal();
                     
                        
                      
                },
                fail:function(data){
                    $('#deleteModal').modal('hide');
                    $('#message').text('Thao tác xóa không thành công!')
                        $('#deleteSuccessModal').modal();
                        
                        
                     
                }
            });
        });
        $('#ok').click(function(){
            $('#deleteSuccessModal').modal('hide');
            location.reload();
        });
        $('#cancel').click(function(){
            $('#deleteModal').modal('hide');
            $('#showModal').modal();
        });
       

    </script>
@endpush