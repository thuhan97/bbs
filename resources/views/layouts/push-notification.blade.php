@if(env('ENABLE_PUSH_NOTIFY', false))
    <script>
        window.messagingSenderId = "{{env('FIREBASE_SENDER_ID')}}";
    </script>
    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/6.1.0/firebase.js"></script>

    <script>
        // TODO: Replace the following with your app's Firebase project configuration
        var firebaseConfig = {
            apiKey: "{{env('FIREBASE_APP_KEY')}}",
            authDomain: "{{env('FIREBASE_PROJECT_ID')}}.firebaseapp.com",
            databaseURL: "https://{{env('FIREBASE_PROJECT_ID')}}.firebaseio.com",
            projectId: "{{env('FIREBASE_PROJECT_ID')}}",
            storageBucket: "{{env('FIREBASE_PROJECT_ID')}}.appspot.com",
            messagingSenderId: "{{env('FIREBASE_SENDER_ID')}}",
            appID: "{{env('FIREBASE_APP_ID')}}",
        };
        window.firebaseToken = null;
        window.firebaseTokenId = null;
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        const messaging = firebase.messaging();
        messaging
            .requestPermission()
            .then(function () {

                // get the token in the form of promise
                return messaging.getToken()
            })
            .then(function (token) {
                window.firebaseToken = token;
                $.ajax({
                    url: '{{route('notification_save_token')}}',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {notify_token: token},
                    success: function (data) {
                        window.firebaseTokenId = data.id;
                    }
                });

                //save tokenNgười tạo
            })
            .catch(function (err) {
                console.log("Unable to get permission to notify.", err);
            });

        messaging.onMessage(function (payload) {
            var notification = new Notification(payload.notification.title, {
                body: payload.notification.body,
                icon: payload.data.icon || '{{JVB_LOGO_URL}}'
            });

            notification.onclick = function () {
                window.open('/');
            }
        });

        {{--$(window).on('beforeunload', function () {--}}
        {{--    if (window.firebaseTokenId) {--}}
        {{--        //notification_enable_push--}}
        {{--        $.ajax({--}}
        {{--            url: '{{route('notification_enable_push')}}',--}}
        {{--            method: 'POST',--}}
        {{--            dataType: 'JSON',--}}
        {{--            data: {id: window.firebaseTokenId},--}}
        {{--            async: false,--}}
        {{--            success: function (data) {--}}
        {{--            }--}}
        {{--        });--}}
        {{--    }--}}
        {{--    return;--}}
        {{--});--}}
    </script>
@endif
