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
          :disabled="loading"
          label="Выбор датасетов"
        />
      </v-col>
      <v-col cols="1">
        <v-btn
          color="success"
          fab
          icon
          outlined
          :loading="selected_data_sources.some(ds => ds.loading)"
          :disabled="is_enable_button_open_datasets"
          title="открыть датасеты"
          @click="openDataset"
        >
          <v-icon>
            mdi-play
          </v-icon>
        </v-btn>
      </v-col>
      <v-col cols="1">
        <v-btn
          color="success"
          fab
          icon
          outlined
          title="добавить новый источник"
          @click="openAddDataSourceDialog"
        >
          <v-icon>
            mdi-plus
          </v-icon>
        </v-btn>
      </v-col>
    </v-row>

    <v-dialog
      v-model="data_source_dialog"
      max-width="700px"
      :transition="false"
      persistent
    >
      <v-card>
        <v-card-title style="padding-bottom: 0;">
          <span class="text-h5">
            Добавить источник датасета
          </span>
        </v-card-title>

        <v-card-text class="pt-0">
          <v-row>
            <v-col
              class="pl-2 pr-2"
              cols="5"
            >
              <v-text-field
                v-model="new_data_source.name"
                label="Название датасета"
                hide-details
              />
            </v-col>
            <v-col
              class="pl-2 pr-2"
              cols="7"
            >
              <v-text-field
                v-model="new_data_source.url"
                label="URL"
                hide-details
              />
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn
            color="success"
            text
            :disabled="create_loading"
            :loading="create_loading"
            @click="addDataSource"
          >
            Применить
          </v-btn>
          <v-btn
            color="primary"
            text
            :disabled="create_loading"
            @click="data_source_dialog = null"
          >
            Отмена
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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

      data_source_dialog: false,
      new_data_source: new DataSource({}),

      create_loading: false,
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
      this.new_data_source = new DataSource({});

      await this.loadDefaultDatasets();
    },
    methods: {

      /**
       * Добавляет источник датасета
       */
      addDataSource() {
        this.create_loading = true;

        window.axios.post('/api/datasource', {
          name: this.new_data_source.name,
          url: this.new_data_source.url,
        }).then(response => {
          this.loadDefaultDatasets();

          this.new_data_source = new DataSource({});

          this.$toast.open({
            message: 'Источник датасета ' + response.data.content.new_data_source.name + ' добавлен',
            type: 'success',
            duration: 3000,
          });

          this.closeAddDataSourceDialog();
        }).catch(errors => {
          this.$toast.open({
            message: 'Ошибка: ' + errors.response.data.message,
            type: 'error',
            duration: 30000,
          });
        }).finally(() => {
          this.create_loading = false;
        });
      },

      /**
       * Открывает диалоговое окно добавления источника датасета
       */
      openAddDataSourceDialog() {
        this.data_source_dialog = true;
      },

      /**
       * Закрывает диалоговое окно добавления источника датасета
       */
      closeAddDataSourceDialog() {
        this.data_source_dialog = false;
      },

      /**
       * Формирует событие о готовности к использованию выбранных датасетов
       */
      openDataset() {
        this.$emit('openDatasets', this.selected_data_sources.map(data_source => data_source.dataset.getCopy()));

        this.selected_data_sources.map(data_source => {
          this.$toast.open({
            message: 'Датасет ' + data_source.dataset.name + ' готов к использованию',
            type: 'success',
            duration: 6000,
          });
        });

        this.selected_data_sources = [];
      },

      /**
       * Загружает сохранённые датасеты
       */
      async loadDefaultDatasets() {
        this.loading = true;

        window.axios.get('/api/datasource').then(response => {
          this.data_sources = response.data.content.data_sources.map(data => {
            return new DataSource(data);
          });
        }).catch(errors => {
          console.error(errors.response.data.messages);
        }).finally(() => {
          this.loading = false;
        });
      },

    },
  };
</script>
