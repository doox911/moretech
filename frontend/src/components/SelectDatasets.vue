<template>
  <v-container>
    <v-row>
      <v-col cols="2">
        <v-autocomplete
          v-model="selected_data_sources"
          :items="data_sources"
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
          :disabled="is_enable_button_open_datasets"
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
  import DataSource from 'Classes/DataSource';

  export default {
    name: 'SelectDatasets',
    data: () => ({

      /**
       * Источники датасетов
       *
       * @return {Array<DataSource>}
       */
      data_sources: [],

      /**
       * Датасеты из интернета
       *
       * @return {Array<DataSet>}
       */
      default_datasets: [],

      /**
       * Выбранные источники данных
       *
       * @return {Array<DataSource>}
       */
      selected_data_sources: [],

      loading: false,
      loading_toast: null,
      toasts: [],
    }),
    computed: {

      is_enable_button_open_datasets() {
        return !this.selected_data_sources ||
          this.selected_data_sources.some(ds => !ds.loaded) ||
          this.selected_data_sources.length === 0;
      },
    },
    watch: {

      selected_data_sources() {
        this.selected_data_sources.map(data_source => {
          data_source.loadDataSet();
        });
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
        this.$emit('openDatasets', this.selected_data_sources.map(data_source => data_source.dataset.getCopy()));

        this.selected_data_sources.map(data_source => {
          const toast = this.$toast.open({
            message: 'Датасет ' + data_source.dataset.name + ' готов к использованию',
            type: 'success',
            duration: 6000,
            // all of other options may go here
          });

          this.toasts.push(toast);
        });

        this.selected_data_sources = [];
      },

      async loadDefaultDatasets() {
        window.axios.get('/api/datasource').then(response => {
          this.data_sources = response.data.content.data_sources.map(data => {
            return new DataSource(data);
          });
        }).catch(errors => {
          console.error(errors.response.data.messages);
        }).finally(() => {
          this.loading = false;
        });

        this.loading = false;
      },

    },
  };
</script>
