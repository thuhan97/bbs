$(function () {

        $(".button-collapse").sideNav();
// SideNav Scrollbar Initialization

        $(".pageSize").change(function () {
            location.href = $(".pageSize option:selected").data('href');
        });
        var subcribeTimeInterval = null;

        function subcribeTime() {
            if ($(".time-subcribe").length > 0) {

                $(".time-subcribe").each(function () {
                    var text = $(this).text();

                    if (text.indexOf('giờ trước') >= 0 || text.indexOf('phút trước') >= 0 || text.indexOf('giây trước') >= 0 || text.indexOf('xong') >= 0) {
                        var time = $(this).data('time');
                        moment.locale('vi');
                        var fromNow = moment(time).fromNow();
                        $(this).text(fromNow);
                    }
                });
            } else if (subcribeTimeInterval) {
                clearInterval(subcribeTimeInterval);
            }
        }

        subcribeTime();

        subcribeTimeInterval = setInterval(function () {
            subcribeTime();
        }, 10000);
    }
);

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
