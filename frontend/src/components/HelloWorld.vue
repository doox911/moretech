<template>
  <v-container>
    <v-row>
      <v-col>
        <select-datasets
          @openDatasets="openDatasets"
        />
      </v-col>
    </v-row>

    <v-row>
      <v-col>
        <view-datasets
          :datasets="custom_datasets"
        />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>

  /**
   * Components
   */
  import SelectDatasets from 'Components/SelectDatasets';
  import ViewDatasets from 'Components/ViewDatases';

  export default {
    name: 'HelloWorld',
    components: {
      SelectDatasets,
      ViewDatasets,
    },
    data: () => ({
      /**
       * Пользовательские датасеты
       *
       * @return {Array<DataSet>}
       */
      custom_datasets: [],
    }),
    async mounted() {
    },
    methods: {

      /**
       * Выбранные датасеты
       *
       * @param {Array<DataSet>} datasets
       * @return {undefined}
       */
      openDatasets(datasets) {
        this.custom_datasets.push(...datasets);
      },

    },
  };
</script>
