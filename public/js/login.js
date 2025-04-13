import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-app.js";
import { getAuth, signInWithPopup ,GoogleAuthProvider, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-auth.js";

const firebaseConfig = {
    apiKey: "AIzaSyDHaGqa1nqipwIYZSVrc96z3vbPIAIE-w8",
    authDomain: "onlinemarket-3c635.firebaseapp.com",
    databaseURL: "https://onlinemarket-3c635-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "onlinemarket-3c635",
    storageBucket: "onlinemarket-3c635.firebasestorage.app",
    messagingSenderId: "715713330845",
    appId: "1:715713330845:web:b9c677e36030f7478dde74",
    measurementId: "G-WENZC6DB2Q"
};

console.log('Test')

const app = initializeApp(firebaseConfig);
const auth = getAuth(app)

document.querySelector('.google-btn').onclick = () => {
    const provider = new GoogleAuthProvider()
    signInWithPopup(auth, provider)
    .then((res) => {

    })
}

onAuthStateChanged(auth, user => {
    if (user) {
        // window.location.href = 'localhost/views/homepage.php'
    }
})

