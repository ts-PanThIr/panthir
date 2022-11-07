import { createRouter, createWebHistory } from "vue-router";

import { Home } from "~/views";
import { TheEmptyLayout, TheMainLayout } from "~/components";
import guest from "~/router/middleware/guest";
import auth from "~/router/middleware/auth";
import middlewarePipeline from "~/router/middleware/middlewarePipeline";
import { useAuthStore } from "~/stores";

import PersonEditView from "~/views/person/PersonEditView.vue";
import PersonListView from "~/views/person/PersonListView.vue";
import UserListView from "~/views/user/UserListView.vue";
import UserEditView from "~/views/user/UserEditView.vue";
import LoginView from "~/views/common/LoginView.vue";
import RegisterView from "~/views/common/RegisterView.vue";

export const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  linkActiveClass: "active",
  routes: [
    {
      path: "/users",
      component: TheMainLayout,
      meta: {
        middleware: [auth],
      },
      children: [
        {
          path: "",
          name: "usersList",
          component: UserListView,
        },
        {
          path: "add",
          name: "usersAdd",
          component: UserEditView,
        },
        {
          path: "edit/:id",
          name: "usersEdit",
          component: UserEditView,
        },
      ],
    },
    {
      path: "/person",
      component: TheMainLayout,
      meta: {
        middleware: [auth],
      },
      children: [
        {
          path: "",
          name: "personList",
          component: PersonListView,
        },
        {
          path: "edit/:id",
          name: "personEdit",
          component: PersonEditView,
        },
        {
          path: "new",
          name: "personNew",
          component: PersonEditView,
        },
      ],
    },
    {
      path: "/account",
      component: TheEmptyLayout,
      meta: {
        middleware: [guest],
      },
      children: [
        {
          path: "",
          redirect: "login",
        },
        {
          path: "login",
          name: "login",
          component: LoginView,
        },
        {
          path: "register",
          name: "register",
          component: RegisterView,
        },
      ],
    },
    {
      path: "/",
      component: TheEmptyLayout,
      children: [
        {
          path: "",
          name: "home",
          component: Home,
        },
      ],
    },
    // catch all redirect to home page
    { path: "/:pathMatch(.*)*", redirect: "/" },
  ],
});

router.beforeEach(async (to, from) => {
  /** Navigate to next if middleware is not applied */
  if (!to.meta.middleware) {
    return true;
  }

  const auth = useAuthStore();
  const middleware = to.meta.middleware;
  const context = {
    to,
    from,
    auth,
  };

  return middleware[0]({
    ...context,
    next: middlewarePipeline(context, middleware, 1),
  });
});
