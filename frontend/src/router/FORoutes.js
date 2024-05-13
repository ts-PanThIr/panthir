import { TheFrontOfficeLayout } from "@/components/index.js";
import { FOHomeView, ResetPasswordView, ResultsView } from "@/views/index.js";

export const FORoutes = {
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
};
