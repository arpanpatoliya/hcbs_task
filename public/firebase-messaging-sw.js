// firebase-messaging-sw.js
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in the messagingSenderId.
firebase.initializeApp({
    apiKey: "AIzaSyDsjm9vs3JGfgyLFlJznF2zplIkvhXpn0M",
    authDomain: "hcbs-56471.firebaseapp.com",
    projectId: "hcbs-56471",  // Ensure projectId is included
    storageBucket: "hcbs-56471.appspot.com",
    messagingSenderId: "302674066698",
    appId: "1:302674066698:web:ab0a689760a1ee9d1dcef3",
    measurementId: "G-1NCMPLVMS3"
});

// Retrieve an instance of Firebase Messaging so that it can handle background messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon
    };

    return self.registration.showNotification(notificationTitle, notificationOptions);
});
