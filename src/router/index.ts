
import { createRouter, createWebHistory } from "vue-router";
import type { RouteRecordRaw } from "vue-router";
import Home from '../views/Home.vue'
import Profile from '../views/Profile.vue'
import WritingList from '../views/WritingList.vue'
import WritingDetail from '../views/WritingDetail.vue'
import Guest from '../views/Guest.vue'

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
    path: '/writing',
    name: 'WritingList',
    component: WritingList
  },
  {
    path: '/writing/:id',
    name: 'WritingDetail',
    component: WritingDetail,
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
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    // 페이지 이동 시 맨 위로 스크롤
    return { top: 0 }
  }
})

export default router