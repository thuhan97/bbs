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

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();
    messaging
        .requestPermission()
        .then(function () {
            console.log("Notification permission granted.");

            // get the token in the form of promise
            return messaging.getToken()
        })
        .then(function (token) {
            console.log(token);
            //save token
        })
        .catch(function (err) {
            console.log("Unable to get permission to notify.", err);
        });

    messaging.onMessage(function (payload) {
        var notification = new Notification(payload.notification.title, {body: payload.notification.body});
    });
</script>
