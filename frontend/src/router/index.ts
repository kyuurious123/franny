import { createRouter, createWebHashHistory } from "vue-router";
import type { RouteRecordRaw } from "vue-router";
import Home from '../views/Home.vue'
import BestarWritingList from '../views/BestarWritingList.vue'
import EnstarWritingList from '../views/EnstarWritingList.vue'
import BestarWritingDetail from '../views/BestarWritingDetail.vue'
import EnstarWritingDetail from '../views/EnstarWritingDetail.vue'
import Guest from '../views/Guest.vue'
import Igeanya2025 from '../views/Igeanya2025.vue';
import SampleMobile from '../views/SampleMobile.vue';
import Igeanya2025Mobile from '../views/Igeanya2025Mobile.vue';
// 리뷰 게시판 컴포넌트 import
import ReviewBoard from '../views/ReviewBoard.vue';
import WritePost from '../views/WritePost.vue';
import ViewPost from '../views/ViewPost.vue';

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

  // 이게아냐 2025 관련 라우터 설정
  {
    path: '/igeanya2025',
    component: Igeanya2025,
    children: [
      {
        path: 'sample',
        component: SampleMobile
      },
      {
        path: 'list',
        component: Igeanya2025Mobile
      },
      {
        path: ':id',
        component: Igeanya2025Mobile
      },
      {
        // 기본 리다이렉트 - 모바일에서는 sample로 이동
        path: '',
        redirect: _ => {
          // 모바일 체크는 컴포넌트에서 처리
          return { path: '/igeanya2025/sample' }
        }
      }
    ]
  },
  
  // 리뷰 게시판 라우트 추가
  {
    path: '/review',
    name: 'ReviewBoard',
    component: ReviewBoard
  },
  {
    path: '/review/write',
    name: 'WritePost',
    component: WritePost
  },
  {
    path: '/review/post/:id',
    name: 'ViewPost',
    component: ViewPost,
    props: true
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