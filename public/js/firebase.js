
// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyDsjm9vs3JGfgyLFlJznF2zplIkvhXpn0M",
    authDomain: "hcbs-56471.firebaseapp.com",
    projectId: "hcbs-56471",
    storageBucket: "hcbs-56471.appspot.com",
    messagingSenderId: "302674066698",
    appId: "1:302674066698:web:ab0a689760a1ee9d1dcef3",
    measurementId: "G-1NCMPLVMS3"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/firebase-messaging-sw.js')
        .then((registration) => {
            console.log('Service Worker registered with scope:', registration.scope);
            messaging.useServiceWorker(registration);
        })
        .catch((error) => {
            console.error('Service Worker registration failed:', error);
        });
}
Notification.requestPermission().then((permission) => {
    if (permission === 'granted') {
        console.log('Notification permission granted.');
    } else {
        console.log('Unable to get permission to notify.');
    }
});

// Handle incoming messages
messaging.onMessage((payload) => {
    console.log('Message received. ', payload);
    const notificationTitle = payload.notification.title;
    const options = {
        body: payload.notification.body,
        icon: payload.notification.icon,
        data: payload.notification.data
    };

    const notif = new Notification(payload.notification.title, options);
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };

    if (Notification.permission === 'granted') {
        new Notification(notificationTitle, notificationOptions);
    }
});

messaging.requestPermission()
    .then(function () {
        return messaging.getToken();
    })
    .then(function (token) {
        console.log("FCM Token:", token);
        $('#fcm_token').val(token);
        // You can do something with the token here if needed
    })
    .catch(function (error) {
        console.error("Error getting token:", error);
    });
