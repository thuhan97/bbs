$(".checkout-approve").click(function(){
	var check = $(this); 
    var data = check.attr("data");
    var data_status = check.attr("data-status");
    $.ajax({
        url : "/approve_suggestion",
        type : "post",
        dataType:"html",
        data : {
            data : data,
            data_status : data_status
        },
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },                     
        success : function (response){
            if(response == 1){
            	check.prop('checked', true);
            	check.siblings( ".form-check-label" ).html('<strong style="color:blue;">Đã duyệt</strong>');
            	check.attr("data-status","1");
            }else{
            	check.prop('checked', false);
            	check.siblings( ".form-check-label" ).html('<strong style="color:red;">Chưa duyệt</strong>');
            	check.attr("data-status","0");
            }
        }
    })
});