$(function () {
    $(".pageSize").change(function () {
        location.href = $(".pageSize option:selected").data('href');
    });
});