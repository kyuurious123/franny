import { createRouter, createWebHashHistory } from "vue-router";
import type { RouteRecordRaw } from "vue-router";
import Home from '../views/Home.vue'
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
    path: '/bestar',
    name: 'BestarWritingList',
    component: BestarWritingList,
    // BestarWritingList 페이지에서는 기본적으로 id:1인 글을 보여줌
    children: [
      {
        path: '',
        component: BestarWritingDetail,
        props: { id: '01' }
      }
    ]
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
    component: EnstarWritingList,
    // EnstarWritingList 페이지에서는 기본적으로 id:zombie-01인 글을 보여줌
    children: [
      {
        path: '',
        component: EnstarWritingDetail,
        props: { id: 'zombie-01' }
      }
    ]
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