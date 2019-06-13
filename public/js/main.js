$(function () {

    $(".button-collapse").sideNav();
// SideNav Scrollbar Initialization

    $(".pageSize").change(function () {
        location.href = $(".pageSize option:selected").data('href');
    });

    window.subcribeList = [];
    var subcribeHourList = [];

    if ($(".time-subcribe").length > 0) {
        $(".time-subcribe").each(function () {
            var text = $(this).text();

            if (text.indexOf('giờ trước') >= 0 || text.indexOf('phút trước') >= 0) {
                subcribeHourList.push(this);
            } else if (text.indexOf('giây trước') >= 0 || text.indexOf('xong') >= 0) {
                subcribeList.push(this);
            }
        });
    }

    function _changeText(that) {
        var time = $(that).data('time');
        if (!time) time = new Date();
        moment.locale('vi');
        var fromNow = moment(time).fromNow();
        $(that).text(fromNow);
    }

    function subcribeTime() {
        for (let item in subcribeList) {
            _changeText(subcribeList[item]);
        }
    }

    function subcribeTimeHour() {
        for (let item in subcribeHourList) {
            _changeText(subcribeHourList[item]);
        }
    }

    setInterval(function () {
        subcribeTime();
    }, 1000);

    if (subcribeHourList.length > 0) {
        setInterval(function () {
            subcribeTimeHour();
        }, 30000);
    }
    window.myDataTable = function ($selector, options) {
        $selector.each(function () {
            $(this).DataTable({
                "language": {
                    "lengthMenu": "",
                    "zeroRecords": "Không tìm thấy dữ liệu",
                    "info": "Trang _PAGE_/_PAGES_",
                    "infoEmpty": "Dữ liệu trống",
                    "infoFiltered": "(_TOTAL_ kết quả từ _MAX_ bản ghi)",
                    "sSearch": "Tìm kiếm"
                },
                "paginate": $(this).find('tbody tr').length > 10,
                "pageLength": 10,
                "lengthMenu": -1,
                "columnDefs": [
                    {orderable: false, targets: [0, -1]},
                ]
            });
        })

    }
});

String.prototype.toGeneralConcurency = function (separator, number) {
    number = number || 3;
    separator = separator || ",";
    var input = this.toString();
    var ouput = "";
    if (input.indexOf(separator) >= 0) {
        return input;
    }

    while (input.length > number) {
        var temp = input.substr(input.length - number);
        ouput = separator + temp + ouput;
        input = input.substr(0, input.length - number);
    }
    return input + ouput;
}
