import {
  createRouter,
  createWebHistory,
  type NavigationGuardNext,
  type RouteLocationNormalized,
} from 'vue-router';

import {
  HomeView,
  PersonEditView,
  PersonListView,
  UserListView,
  UserEditView,
  LoginView,
  RegisterView,
  FinancialEditView,
} from '~/views';

import { TheEmptyLayout, TheMainLayout } from '~/components';
import { useAuthStore, useInterfaceStore } from '~/stores';

export const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  linkActiveClass: 'active',
  routes: [
    {
      path: '/users',
      component: TheMainLayout,
      meta: {
        middleware: { requiresAuth: true },
      },
      children: [
        {
          path: '',
          name: 'usersList',
          component: UserListView,
          meta: {
            pageTitle: 'Users list'
          }
        },
        {
          path: 'new',
          name: 'usersNew',
          component: UserEditView,
          meta: {
            pageTitle: 'Create user'
          }
        },
        {
          path: 'edit/:id',
          name: 'usersEdit',
          component: UserEditView,
          meta: {
            pageTitle: 'Edit user'
          }
        },
      ],
    },
    {
      path: '/person',
      component: TheMainLayout,
      meta: {
        middleware: { requiresAuth: true },
      },
      children: [
        {
          path: '',
          name: 'personList',
          component: PersonListView,
          meta: {
            pageTitle: 'Person list'
          }
        },
        {
          path: 'edit/:id',
          name: 'personEdit',
          component: PersonEditView,
          meta: {
            pageTitle: 'Edit person'
          }
        },
        {
          path: 'new',
          name: 'personNew',
          component: PersonEditView,
          meta: {
            pageTitle: 'Create person'
          }
        },
      ],
    },
    {
      path: '/financial',
      component: TheMainLayout,
      meta: {
        middleware: { requiresAuth: true },
      },
      children: [
        {
          path: 'new',
          name: 'financialEdit',
          component: FinancialEditView,
          meta: {
            pageTitle: 'Edite title'
          }
        },
      ],
    },
    {
      path: '/account',
      component: TheEmptyLayout,
      children: [
        {
          path: '',
          redirect: 'login',
          meta: {
            pageTitle: 'Authentication'
          }
        },
        {
          path: 'login',
          name: 'login',
          component: LoginView,
          meta: {
            pageTitle: 'Authentication'
          }
        },
        {
          path: 'register',
          name: 'register',
          component: RegisterView,
          meta: {
            pageTitle: 'User Registration'
          }
        },
        {
          path: 'resetPassword/:token',
          name: 'resetPassword',
          component: RegisterView,
          meta: {
            pageTitle: 'Password recover'
          }
        },
      ],
    },
    {
      path: '/',
      component: TheEmptyLayout,
      children: [
        {
          path: '',
          name: 'home',
          component: HomeView,
        },
      ],
    },
    // catch all redirect to home page
    { path: '/:pathMatch(.*)*', redirect: '/' },
  ],
});

router.beforeEach(
  async (
    to: RouteLocationNormalized,
    from: RouteLocationNormalized,
    next: NavigationGuardNext,
  ) => {
    if (!(['login', 'resetPassword'].includes(to.name as string)) && !useAuthStore().user && to.meta.requiresAuth) {
      next({ name: 'login' });
    }
    next();
  },
);

router.afterEach((to) => {
  const interfaceStore = useInterfaceStore();
  const pageTitle =  to.meta.pageTitle || interfaceStore.pageTitle as string
  document.title = `${import.meta.env.VITE_APP_NAME} - ${pageTitle}`
})
