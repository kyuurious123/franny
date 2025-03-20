// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getDatabase } from "firebase/database"; // ✅ Firestore → Realtime Database로 변경

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyAXp1ZxTHMJCjj0LO7fD2GhjPEnjtsjxuA",
  authDomain: "kyuurious824.firebaseapp.com",
  databaseURL: "https://kyuurious824-default-rtdb.firebaseio.com", // ✅ Realtime Database URL 추가
  projectId: "kyuurious824",
  storageBucket: "kyuurious824.appspot.com",
  messagingSenderId: "949130119822",
  appId: "1:949130119822:web:60ea7665ec25103f05d7df",
  measurementId: "G-2R4H847ZSB"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const db = getDatabase(app); // ✅ Firestore → Realtime Database로 변경

export { db }; // ✅ `db`를 올바르게 `export`
