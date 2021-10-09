<template>
  <v-app>
    <v-app-bar
      class="black"
      app
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

  export default {
    name: 'App',

    data: () => ({
    //
    }),
  };
</script>
