import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './assets/main.css'
import './assets/writing-content.css'

// 환경에 따른 기본 URL 설정
const app = createApp(App)

// 전역 속성으로 baseUrl 추가
app.config.globalProperties.$baseUrl = window.location.origin

// 라우터 사용 및 앱 마운트
app.use(router).mount('#app')