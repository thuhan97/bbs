$(function () {
    $(".button-collapse").sideNav();
// SideNav Scrollbar Initialization

    $(".pageSize").change(function () {
        location.href = $(".pageSize option:selected").data('href');
    });
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
