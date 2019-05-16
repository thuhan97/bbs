$(function () {
    $(".pageSize").change(function () {
        location.href = $(".pageSize option:selected").data('href');
    });
    /* Store sidebar state */
    $('.sidebar-toggle').click(function (event) {
        event.preventDefault();
        if (Boolean(localStorage.getItem('sidebar-toggle-collapsed'))) {
            localStorage.setItem('sidebar-toggle-collapsed', '');
        } else {
            localStorage.setItem('sidebar-toggle-collapsed', '1');
        }
    });

    $.each($('[with-preview]'), function () {
        var $target = $('#' + $(this).attr('with-preview'));

        uploadPreview($(this), $target);
    });

    $("#exportExcel").click(function () {
        $("#searchForm").append('<input id="is_export" type="hidden" name="is_export" value="1" />');
        $("#searchForm").submit();
        $("#is_export").remove();
    });
});

window.uploadPreview = function ($input, $preview, isChangeBg) {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                if (isChangeBg) {
                    $preview.css("background-image", "url(" + e.target.result + ")");
                } else {
                    if (!$preview.is('img')) {
                        var $img = $('<img class="full-width" />');
                        $img.attr('src', e.target.result);
                        $preview.html($img);
                    } else {
                        $preview.attr('src', e.target.result);
                    }
                }
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $input.change(function () {
        readURL(this);
    });
}

window.openAlert = function (content, title, type) {
    var $modal = $("#modalAlert");
    if (title) {
        $modal.find('.modal-title').text(title);
    }
    $modal.find('.modal-body').text(content);
    $modal.modal('show');
}

window.myDatePicker = function ($selector, date) {
    if (!date) date = new Date();
    $selector.datepicker({
        setDate: new Date(),
        // useCurrent: date,
        todayHighlight: true,
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
}
window.myDateTimePicker = function ($selector, date) {
    if (!date) date = new Date();

    $selector.datetimepicker({
        defaultDate: date,
    });
}
window.myTimePicker = function ($selector, date) {
    if (!date) date = new Date();

    $selector.datetimepicker({
        pickDate: false
    });
}

window.myEditor = function ($selector, height) {
    var editorConfig = {
        path_absolute: "/",
        height: height || 300 + 'px',
        theme: "modern",
        paste_data_images: true,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "fullscreen preview media | forecolor backcolor emoticons",
        image_advtab: true,
        file_browser_callback: function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editorConfig.path_absolute + 'file-manager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        },
        templates: [{
            title: 'Test template 1',
            content: 'Test 1'
        }, {
            title: 'Test template 2',
            content: 'Test 2'
        }]
    };
    $.each($selector, function () {
        editorConfig.selector = "#" + this.id;
        tinymce.init(editorConfig);
    })
}

window.myFilemanager = function ($selector, type, options) {
    options = options || {};
    if (!options.prefix) {
        options.prefix = '/file-manager';
    }
    $selector.filemanager(type, options);
};
