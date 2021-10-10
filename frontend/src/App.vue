<template>
  <v-app>
    <v-app-bar
      v-if="isAuth"
      class="black"
      app
      :value="v_navigation_drawer"
    >
      <div class="d-flex align-center">
        <v-img
          alt="Vuetify Logo"
          class="shrink mr-2"
          contain
          src="https://static.tildacdn.com/tild6264-3465-4030-a531-396135613230/_8.svg"
          transition="scale-transition"
          width="100"
        />
      </div>
    </v-app-bar>

    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script>

  /**
   * Mixins
   */
  import AuthMixin from './mixins/auth/AuthMixin';

  export default {
    name: 'App',

    mixins: [
      AuthMixin,
    ],

    data: () => ({
    //
    }),

    watch: {
      isAuth() {
        this.toggleVNavigationDrawer();
      },
    },
  };
</script>
