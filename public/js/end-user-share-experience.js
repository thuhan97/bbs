// $( document ).ready(function() {
//     var heightPosts  = $( ".content-posts" );
//     heightPosts.each(function(){
//         if($(this).height() < 300){
//             $(this).siblings("p.show-more").css('display','none');
//         }
//     });    
// });

window.myEditor = function ($selector, height) {
    function myFileBrowser(field_name, url, type, win) {

        // alert("Field_Name: " + field_name + "nURL: " + url + "nType: " + type + "nWin: " + win); // debug/testing

        /* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry
           the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
           These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */

        /* Here goes the URL to your server-side script which manages all file browser things. */
        var cmsURL = window.location.pathname;     // your URL could look like "/scripts/my_file_browser.php"
        var searchString = window.location.search; // possible parameters
        if (searchString.length < 1) {
            // add "?" to the URL to include parameters (in other words: create a search string because there wasn't one before)
            searchString = "?";
        }

        // newer writing style of the TinyMCE developers for tinyMCE.openWindow

        tinyMCE.openWindow({
            file: cmsURL + searchString + "&type=" + type, // PHP session ID is now included if there is one at all
            title: "File Browser",
            width: 420,  // Your dimensions may differ - toy around with them!
            height: 400,
            close_previous: "no"
        }, {
            window: win,
            input: field_name,
            resizable: "yes",
            inline: "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
            editor_id: tinyMCE.selectedInstance.editorId
        });
        return false;
    }

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
        file_browser_callback: "image",
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

// $("#buttonExperience").click(function(){
//     var content = $("#editorContainer_ifr").contents().find("body").text();
//     if(content.trim() != ''){
//         $('#formExperience').submit();
//     }else{
//         alert('Bạn cần nhập nội dung kinh nghiệm làm việc!');
//     }
// });

$(".form-comment2").click(function () {
    $(this).closest(".info-user-comment").find(".content-form-comment2").css('display', 'flex').find(".input-comment2").focus();
});

$(".form-comment1").click(function () {
    $(this).closest(".content-share-experience").find(".input-comment1").focus();
});

$(".button-send").click(function () {
    var contentComment = $(this).closest("form").find("input.input-comment").val();
    var share_id = $(this).closest("form").find("input.share_id").val();
    if (contentComment.trim() != '') {
        $.ajax({
            url: "/add_comment",
            type: "post",
            dataType: "html",
            data: {
                contentComment: contentComment,
                share_id: share_id
            },
            headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            success: function (response) {
                console.log(response);
                $(".contentajax").html(response);
            }
        })
    }
});

// function showMoreLess(that) {
//     var dots = $(that).closest(".posts").find(".content-posts");
//     if (dots.css("max-height") === "300px") {
//         dots.css('max-height','none');
//         that.innerHTML = "Rút gọn";
//     } else {
//         dots.css('max-height','300px');
//         that.innerHTML = "Xem thêm";
//     }
// } 
function sendForm() {
    var content = $("#editorContainer_ifr").contents().find("body").text();
    var introduction = $("#introduction").val();
    if (content.trim() != '' && introduction.trim() != '') {
        $("#formExperience").submit();
    } else {
        let errorBox = document.getElementById('ErrorMessaging');
        errorBox.innerHTML = "<div class='card-body'>Tóm tắt và nội dung không được để trống!</div>";
    }
}