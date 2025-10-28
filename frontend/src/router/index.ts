import { createRouter, createWebHashHistory } from "vue-router";
import type { RouteRecordRaw } from "vue-router";
import Home from '../views/Home.vue'
import BestarWritingList from '../views/BestarWritingList.vue'
import EnstarWritingList from '../views/EnstarWritingList.vue'
import DcWritingList from '../views/DcWritingList.vue'
import BestarWritingDetail from '../views/BestarWritingDetail.vue'
import EnstarWritingDetail from '../views/EnstarWritingDetail.vue'
import DcWritingDetail from '../views/DcWritingDetail.vue'
import Guest from '../views/Guest.vue'
import WritingHelper from '../views/WritingHelper.vue'


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
    path: '/dc',
    name: 'DcWritingList',
    component: DcWritingList,
    // DcWritingList 페이지에서는 기본적으로 id:1인 글을 보여줌
    children: [
      {
        path: '',
        component: DcWritingDetail,
        props: { id: 'dc01' }
      }
    ]
  },
  {
    path: '/dc/:id',
    name: 'DcWritingDetail',
    component: DcWritingDetail,
    props: true
  },
  {
    path: '/guest',
    name: 'Guest',
    component: Guest
  },

  {
    path: '/writinghelper',
    name: 'WritingHelper',
    component: WritingHelper,
  },


  // 404 페이지
  {
    path: '/:pathMatch(.*)*',
    redirect: '/'
  }
]

const router = createRouter({
  // ✅ hash mode에서는 base 인자를 전달하지 않음
  history: createWebHashHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  }
})

export default router