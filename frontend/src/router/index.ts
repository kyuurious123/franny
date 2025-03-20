import { createRouter, createWebHashHistory } from "vue-router";
import type { RouteRecordRaw } from "vue-router";
import Home from '../views/Home.vue'
import Profile from '../views/Profile.vue'
import BestarWritingList from '../views/BestarWritingList.vue'
import EnstarWritingList from '../views/EnstarWritingList.vue'
import BestarWritingDetail from '../views/BestarWritingDetail.vue'
import EnstarWritingDetail from '../views/EnstarWritingDetail.vue'
import Guest from '../views/Guest.vue'

// 배포 환경에 맞는 base URL 설정
const base = import.meta.env.BASE_URL || '/';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/profile',
    name: 'Profile',
    component: Profile
  },
  {
    path: '/bestar',
    name: 'BestarWritingList',
    component: BestarWritingList
  },
  {
    path: '/bestar/:id',
    name: 'BestarWritingDetail',
    component: BestarWritingDetail,
    props: true
  },
  {
    path: '/enstar',
    name: 'EnstarWritingList',
    component: EnstarWritingList
  },
  {
    path: '/enstar/:id',
    name: 'EnstarWritingDetail',
    component: EnstarWritingDetail,
    props: true
  },
  {
    path: '/guest',
    name: 'Guest',
    component: Guest
  },
  // 404 페이지
  {
    path: '/:pathMatch(.*)*',
    redirect: '/'
  }
]

const router = createRouter({
  history: createWebHashHistory(base),
  routes,
  scrollBehavior() {
    return { top: 0 }
  }
})

export default router