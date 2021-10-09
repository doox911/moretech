<template>
  <v-container>
    <v-row class="text-center">
      <v-col
        v-for="(dataset) in datasets"
        :key="dataset.id"
      >
        <v-card
          class="mx-auto"
          max-width="344"
        >
          <v-card-text>
            <div>{{ dataset.name }}</div>
            <v-card-text>
              {{ dataset.schema }}
            </v-card-text>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>

  export default {
    name: 'ViewDatasets',
    props: {

      /**
       * Датасеты для визуализации
       */
      datasets: {
        type: Array,
        default: null,
      },

    },
    async mounted() {
    },
    methods: {

    },
  };
</script>
