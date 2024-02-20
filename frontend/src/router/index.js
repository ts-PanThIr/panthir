import { createRouter, createWebHistory } from "vue-router";

import {
  CustomerEditView,
  CustomerListView,
  UserListView,
  UserEditView,
  LoginView,
  RegisterView,
  ResetPasswordView,
  FOHomeView,
  ResultsView,
  BOHomeView,
  SupplierListView,
  SupplierEditView,
} from "~/views";

import {
  TheEmptyLayout,
  TheMainLayout,
  TheFrontOfficeLayout,
} from "~/components";
import { useAuthStore, useInterfaceStore } from "~/stores";

export const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  linkActiveClass: "active",
  routes: [
    {
      path: "/bo",
      meta: {
        middleware: { requiresAuth: true },
      },
      children: [
        {
          path: "home",
          component: TheMainLayout,
          children: [
            {
              path: "",
              name: "BOHome",
              component: BOHomeView,
              meta: {
                pageTitle: "Home",
              },
            },
          ],
        },
        {
          path: "users",
          component: TheMainLayout,
          children: [
            {
              path: "",
              name: "usersList",
              component: UserListView,
              meta: {
                pageTitle: "Users list",
              },
            },
            {
              path: "new",
              name: "usersNew",
              component: UserEditView,
              meta: {
                pageTitle: "Create user",
              },
            },
            {
              path: "edit/:id",
              name: "usersEdit",
              component: UserEditView,
              meta: {
                pageTitle: "Edit user",
              },
            },
          ],
        },
        {
          path: "customer",
          component: TheMainLayout,
          children: [
            {
              path: "",
              name: "customerList",
              component: CustomerListView,
              meta: {
                pageTitle: "Customer list",
              },
            },
            {
              path: "edit/:id",
              name: "customerEdit",
              component: CustomerEditView,
              meta: {
                pageTitle: "Edit customer",
              },
            },
            {
              path: "new",
              name: "customerNew",
              component: CustomerEditView,
              meta: {
                pageTitle: "Create customer",
              },
            },
          ],
        },
        {
          path: "supplier",
          component: TheMainLayout,
          children: [
            {
              path: "",
              name: "supplierList",
              component: SupplierListView,
              meta: {
                pageTitle: "Supplier list",
              },
            },
            {
              path: "edit/:id",
              name: "supplierEdit",
              component: SupplierEditView,
              meta: {
                pageTitle: "Edit supplier",
              },
            },
            {
              path: "new",
              name: "supplierNew",
              component: SupplierEditView,
              meta: {
                pageTitle: "Create person",
              },
            },
          ],
        },
      ],
    },
    {
      path: "/auth",
      component: TheEmptyLayout,
      meta: {
        middleware: { requiresAuth: false },
      },
      children: [
        {
          path: "",
          redirect: () => {
            return { name: "login" };
          },
          meta: {
            pageTitle: "Authentication",
          },
        },
        {
          path: "login",
          name: "login",
          component: LoginView,
          meta: {
            pageTitle: "Authentication",
          },
        },
        {
          path: "register",
          name: "register",
          component: RegisterView,
          meta: {
            pageTitle: "User Registration",
          },
        },
        {
          path: "resetPassword/:token",
          name: "resetPassword",
          component: ResetPasswordView,
          meta: {
            pageTitle: "Password reset",
          },
        },
      ],
    },
    {
      path: "/",
      component: TheFrontOfficeLayout,
      meta: {
        middleware: { requiresAuth: false },
      },
      children: [
        {
          path: "",
          name: "FOHome",
          component: FOHomeView,
        },
        {
          path: "resetPassword/:token",
          name: "map",
          component: ResetPasswordView,
          meta: {
            pageTitle: "Password reset",
          },
        },
        {
          path: "results/:search?",
          name: "results",
          component: ResultsView,
          meta: {
            pageTitle: "Search results",
          },
        },
      ],
    },
    // catch all redirect to home page
    { path: "/:pathMatch(.*)*", redirect: "/" },
  ],
});

router.beforeEach(async (to, from, next) => {
  if (
    !["login", "resetPassword"].includes(to.name) &&
    !useAuthStore().user &&
    to.meta.requiresAuth
  ) {
    next({ name: "login" });
  }
  next();
});

router.afterEach((to) => {
  const interfaceStore = useInterfaceStore();
  const pageTitle = to.meta.pageTitle || interfaceStore.pageTitle;
  document.title = `${import.meta.env.VITE_APP_NAME} - ${pageTitle}`;
});
