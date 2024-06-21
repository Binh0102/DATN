import { createStore } from "vuex";

export default createStore({
  state: {
    loginErro: {
      show: false,
      content: "ok nhé",
      icon: "$success",
      color: "success",
    },
  },
  getters: {
    loginErro: (state) => state.loginErro,
  },
  mutations: {
    // lúc toast message
    setLoginError(state, { show, icon, content, color }) {
      state.loginErro = { show, icon, content, color };
    },
    clearLoginError(state) {
      state.loginErro = { show: false, icon: "", content: "", color: "" };
    },
  },
  actions: {},
  modules: {},
});
