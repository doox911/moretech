<template>
  <v-container>
    <v-row>
      <v-col cols="2">
        <v-autocomplete
          v-model="selected_default_datasets"
          :items="default_datasets"
          item-value="id"
          item-text="name"
          persistent-hint
          multiple
          autocomplete="off"
          return-object
          :loading="loading"
        />

        <v-btn
          text
          color="teal accent-4"
          :disabled="!selected_default_datasets || selected_default_datasets.length === 0"
          @click="openDataset"
        >
          открыть датасеты
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>

  /**
   * Classes
   */
  import DataSet from 'Classes/DataSet';

  export default {
    name: 'SelectDatasets',
    data: () => ({
      /**
       * Датасеты из интернета
       *
       * @return {Array<DataSet>}
       */
      default_datasets: [],

      /**
       * Выбранные датасеты
       *
       * @return {Array<DataSet>}
       */
      selected_default_datasets: [],

      loading: false,
      loading_toast: null,
      toasts: [],
    }),
    computed: {

      collections_dataset_from_internet() {
        return [
          'country-list',
          'population',
          'covid-19',
        ];
      },
    },
    async mounted() {
      await this.loadDefaultDatasets();
    },
    methods: {

      showLoadingMessage() {
        this.loading_toast = this.$toast.open({
          message: 'Загрузка списка датасетов',
          type: 'success',
          duration: 6000000,
        });
      },

      openDataset() {
        this.$emit('openDatasets', this.selected_default_datasets.map(ds => ds.getCopy()));

        this.selected_default_datasets.map(dataset => {
          const toast = this.$toast.open({
            message: 'Датасет ' + dataset.name + ' готов к использованию',
            type: 'success',
            duration: 6000,
            // all of other options may go here
          });

          this.toasts.push(toast);
        });

        this.selected_default_datasets = [];
      },

      async loadDefaultDatasets() {
        this.collections_dataset_from_internet.map(async dataset_name => {
          const url = `https://datahub.io/core/${dataset_name}/datapackage.json`;

          this.default_datasets.push(await DataSet.fromUrl(url));
        });

        this.loading = false;
      },

    },
  };
</script>
