import { createRouter, createWebHistory } from "vue-router";

import { Home } from "~/views";
import { TheEmptyLayout, TheMainLayout } from "~/components";
import guest from "~/router/middleware/guest";
import auth from "~/router/middleware/auth";
import middlewarePipeline from "~/router/middleware/middlewarePipeline";
import { Login, Register } from "~/views/account";
import { AddEdit, List } from "~/views/users";
import { useAuthStore } from '~/stores';

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
          component: List,
        },
        {
          path: "add",
          name: "usersAdd",
          component: AddEdit,
        },
        {
          path: "edit/:id",
          name: "usersEdit",
          component: AddEdit,
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
          component: Login,
        },
        {
          path: "register",
          name: "register",
          component: Register,
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

router.beforeEach(async(to, from) => {
  /** Navigate to next if middleware is not applied */
  if (!to.meta.middleware) {
    return true;
  }

  const auth = useAuthStore();
  const middleware = to.meta.middleware;
  const context = {
    to,
    from,
    auth
  };

  return middleware[0]({
    ...context,
    next: middlewarePipeline(context, middleware, 1),
  });
});
