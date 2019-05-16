$( document ).ready(function() {
    var heightPosts  = $( ".content-posts" );
    heightPosts.each(function(){
        if($(this).height() < 300){
            $(this).siblings("p.show-more").css('display','none');
        }
    });    
});

window.myEditor = function ($selector, height) {
    var editorConfig = {
        path_absolute: "/",
        height: height || 250 + 'px',
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

$("#buttonExperience").click(function(){
    var content = $("#editorContainer_ifr").contents().find("body").text();
    if(content.trim() != ''){
        $('#formExperience').submit();
    }else{
        alert('Bạn cần nhập nội dung kinh nghiệm làm việc!');
    }
});

$(".form-comment2").click(function(){
    $( this ).closest(".info-user-comment").find(".content-form-comment2").css('display','flex').find(".input-comment2").focus();
});

$(".form-comment1").click(function(){
    $( this ).closest(".content-share-experience").find(".input-comment1").focus();
});

$( ".button-send" ).click(function() {
    var contentComment = $(this).closest( "form" ).find("input.input-comment").val();
    var share_id = $(this).closest( "form" ).find("input.share_id").val();
    if(contentComment.trim() != ''){
        $.ajax({
            url : "/add_comment",
            type : "post",
            dataType:"html",
            data : {
                contentComment : contentComment,
                share_id : share_id
            },
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },                     
            success : function (response){
                console.log(response);
                $(".contentajax").html(response);
            }
        })
    }    
});

function showMoreLess(that) {
    var dots = $(that).closest(".posts").find(".content-posts");
    if (dots.css("max-height") === "300px") {
        dots.css('max-height','none');
        that.innerHTML = "Rút gọn";
    } else {
        dots.css('max-height','300px');
        that.innerHTML = "Xem thêm";
    }
} 