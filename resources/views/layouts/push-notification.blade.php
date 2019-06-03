<!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/6.1.0/firebase-app.js"></script>

<!-- Add Firebase products that you want to use -->
<script src="https://www.gstatic.com/firebasejs/6.1.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.1.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.1.0/firebase-messaging.js"></script>

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
    messaging.usePublicVapidKey('{{env('FIREBASE_MESSAGING_VALID_KEY')}}');

</script>
<script type="text/javascript" src="{{ cdn_asset('js/push-notify.js') }}"></script>
