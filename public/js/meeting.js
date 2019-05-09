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
                url: '/get_calendar-booking',
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

            defaultDate:moment().format('YYYY-MM-DD') ,
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
                var data={
                        'id':calEvent.id,
                        'meetings_id':calEvent.description,
                        'start_time':calEvent.start.format('HH:mm:00'),
                        'end_time':calEvent.end.format('HH:mm:00'),
                        'date':calEvent.start.format('YYYY-MM-DD' ),
                    };
                $.ajax({
                    url:'/get-booking',
                    data:data,
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
                        $('#edit').click(function(){
                                    var booking=data.booking;
                                    $('#id').val(booking.id);
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
                            
                        });
                    }
                });
                        // delete
                $('#delete').click(function(){
                    $.ajax({
                        url:'delete-booking',
                        data:data,
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

    
    $('#deleteMessage').click(function(){
        $('#showModal').modal('hide');
        $('#deleteModal').modal();
    });

    
    $('#ok').click(function(){
        $('#deleteSuccessModal').modal('hide');
        location.reload();
    });
    $('#cancel').click(function(){
        $('#deleteModal').modal('hide');
        $('#showModal').modal();
    });
   