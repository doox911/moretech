<template>
  <v-container fluid>
    <v-row>
      <v-col
        cols="12"
        md="5"
        sm="12"
      >
        <h1>Выберите датасеты</h1>
      </v-col>
      <v-col>
        <select-datasets
          @openDatasets="openDatasets"
        />
      </v-col>
    </v-row>
    <v-row>
      <v-col
        v-for="(dataset, index) in datasets"
        :key="index"
        cols="12"
        sm="6"
        md="4"
      >
        <v-card height="100%">
          <v-card-title class="mb-3 vtb-color white--text">
            {{ dataset.name }}
          </v-card-title>
          <v-card-text>
            <v-chip
              v-for="(field, field_index) in dataset.schema.fields"
              :key="field_index"
              class="ma-1"
              color="vtb-color"
              outlined
              text-color="vtb-color"
              :draggable="true"
              @dragstart="onDragStart(field, field_index, dataset)"
              @dragend="onDragEnd()"
            >
              {{ field.name }}({{ field.type }})
            </v-chip>
          </v-card-text>
        </v-card>
      </v-col>
      <!-- operations -->
      <v-col
        v-if="datasets.length"
        cols="12"
        sm="6"
        md="4"
      >
        <v-card height="100%">
          <v-card-title class="mb-3 vtb-color white--text">
            <v-row justify="space-between">
              <v-col cols="auto">
                Операции
              </v-col>
              <v-col
                cols="auto"
              >
                <v-btn
                  color="white"
                  fab
                  icon
                  outlined
                  x-small
                  :loading="loading_data_operations"
                  :disabled="loading_data_operations"
                  title="добавить новую операцию"
                  @click="openAddOperationComponent"
                >
                  <v-icon>
                    mdi-plus
                  </v-icon>
                </v-btn>

                <add-data-operation
                  v-if="show_operation_component"
                  @close="closeAddOperationComponent"
                />
              </v-col>
            </v-row>
          </v-card-title>
          <v-card-text>
            <v-chip
              v-for="(data_operation, data_operation_index) in data_operations"
              :key="data_operation_index"
              class="ma-1"
              color="vtb-color"
              outlined
              text-color="vtb-color"
              :draggable="true"
              @dragstart="onDragStartDataOperation(data_operation, data_operation_index)"
              @dragend="onDragEndDataOperation()"
            >
              {{ data_operation.name }} ({{ data_operation.formula }})
            </v-chip>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row justify="space-around">
      <!-- Selected -->
      <v-col
        class="pa-3 ma-2 rounded-lg fields-container"
        md="3"
        sm="12"
        draggable="false"
        @dragenter.prevent
        @dragover.prevent
        @dragleave.prevent
        @drop.prevent="onDropSelectedFields"
      >
        <template v-if="to_selected_fields.length">
          <v-chip
            v-for="(field, index) in to_selected_fields"
            :key="index"
            class="ma-2"
            color="vtb-color"
            outlined
            text-color="vtb-color"
            @dblclick="removeFieldFromSelect(index)"
          >
            {{ field.name }}
          </v-chip>
        </template>
        <template v-else>
          <v-row
            align="center"
            class="fill-height"
            justify="center"
          >
            <v-col
              class="text-center"
              cols="auto"
            >
              <span class="user-select-none grey--text text--lighten-1 text-h4">
                Поместите поля датасетов для выборки
              </span>
            </v-col>
          </v-row>
        </template>
      </v-col>

      <!-- Sort -->
      <v-col
        class="pa-3 ma-2 rounded-lg fields-container"
        md="3"
        sm="12"
        draggable="false"
        @dragenter.prevent
        @dragover.prevent
        @dragleave.prevent
        @drop.prevent="onDropSortFields"
      >
        <template v-if="to_sort_fields.length">
          <v-chip
            v-for="(field, index) in to_sort_fields"
            :key="index"
            class="ma-2"
            color="vtb-color"
            outlined
            text-color="vtb-color"
            @dblclick="removeFieldFromSort(index)"
          >
            {{ field.name }}
          </v-chip>
        </template>
        <template v-else>
          <v-row
            align="center"
            class="fill-height"
            justify="center"
          >
            <v-col
              class="text-center"
              cols="auto"
            >
              <span class="user-select-none grey--text text--lighten-1 text-h4">
                Поместите поля датасетов для сортировки
              </span>
            </v-col>
          </v-row>
        </template>
      </v-col>

      <!-- Where -->
      <v-col
        class="my-2"
        md="5"
        sm="12"
      >
        <template
          v-for="(item, index) in operations_to_fields"
        >
          <v-row
            :key="index"
            align="center"
          >
            <v-col
              sm="12"
            >
              <v-row>
                <v-col
                  class="ma-2 pa-3 rounded-lg fields-container"
                >
                  <div
                    @dragenter.prevent
                    @dragover.prevent
                    @dragleave.prevent
                    @drop.prevent="onDropOperationField(index)"
                    @dblclick="removeFieldFromOperationField(index)"
                  >
                    <template v-if="item.field">
                      <v-chip
                        class="ma-2"
                        color="vtb-color"
                        outlined
                        text-color="vtb-color"
                      >
                        {{ item.field.name }}
                      </v-chip>
                    </template>
                    <template v-else>
                      <v-row justify="center">
                        <v-col cols="auto">
                          <span class="user-select-none grey--text text--lighten-1 text-h4">
                            Поле
                          </span>
                        </v-col>
                      </v-row>
                    </template>
                  </div>
                </v-col>
              </v-row>
            </v-col>

            <v-col cols="12">
              <v-row
                align="center"
                class="d-flex flex-nowrap"
              >
                <v-col
                  cols="3"
                >
                  <v-select
                    v-model="item.condition"
                    class="width-select background-vtb-l-blue border-radius"
                    outlined
                    :items="operations"
                    hide-details
                  />
                </v-col>

                <v-col cols="auto">
                  <v-text-field
                    v-model="item.value"
                    label="Значение для операции"
                    class="border-radius"
                    color="primary"
                    hide-details
                    outlined
                  />
                </v-col>

                <v-spacer />

                <v-col cols="1">
                  <v-btn
                    icon
                    color="red"
                    @click="removeOperation(index)"
                  >
                    <v-icon>mdi-close</v-icon>
                  </v-btn>
                </v-col>
              </v-row>
            </v-col>
          </v-row>

          <div
            :key="`where-divider-${index}`"
            class="divider vtb-color-border"
          />
        </template>

        <v-row>
          <v-col>
            <v-btn
              color="vtb-color"
              text
              rounded
              @click="addCondition"
            >
              Добавить условие
            </v-btn>
          </v-col>
        </v-row>
      </v-col>
    </v-row>

    <!-- result_fields -->
    <v-row v-if="datasets.length">
      <v-col class="ma-2 pa-3 rounded-lg fields-container">
        <template v-if="result_fields.length">
          <v-row
            v-for="(item, index) in result_fields"
            :key="index"
            align="center"
          >
            <v-col cols="2">
              <v-text-field
                v-model="item.name"
                clearable
                label="Наименование поля"
              />
            </v-col>
            <v-col cols="auto">
              <span class="user-select-none grey--text text--lighten-1 text-h4">
                =
              </span>
            </v-col>
            <v-col cols="6">
              <v-text-field
                v-model="item.formula"
                clearable
                label="Перетащите поля или операции"
                hint="Составление формулы"
                persistent-hint
                @dragenter.prevent
                @dragover.prevent
                @dragleave.prevent
                @drop.prevent="onDropResultField(item)"
              />
            </v-col>
            <v-col cols="auto">
              <v-btn
                color="vtb-color"
                fab
                rounded
                icon
                @click="removeResultField(index)"
              >
                <v-icon>
                  mdi-delete
                </v-icon>
              </v-btn>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-btn
                color="vtb-color"
                text
                rounded
                @click="addResultField"
              >
                Добавить поле
              </v-btn>
            </v-col>
          </v-row>
        </template>
        <template v-else>
          <v-row
            align="center"
            class="fill-height"
            justify="center"
          >
            <v-col
              class="text-center"
              cols="auto"
            >
              <div
                class="user-select-none grey--text text--lighten-1 text-h4"
                @click="addResultField"
              >
                Нажмите чтобы добавить поле в результирующую выборку
              </div>
            </v-col>
          </v-row>
        </template>
      </v-col>
    </v-row>

    <v-row
      v-if="to_selected_fields.length"
      align="center"
      justify="center"
    >
      <v-col cols="auto">
        <v-btn
          color="vtb-color"
          text
          rounded
          :disabled="file_task_loading"
          @click="createTask"
        >
          {{ download_file_task_button_text }}&nbsp;
          <v-progress-circular
            v-if="file_task_loading"
            indeterminate
            color="primary"
          />
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>

  /**
   * Functions
   */
  import { isEqual, uniqWith } from 'lodash';

  /**
   * Components
   */
  import SelectDatasets from 'Components/SelectDatasets';
  import AddDataOperation from 'Components/AddDataOperation';
  import DataOperation from 'Classes/DataOperation';

  export default {
    name: 'Constructor',
    components: {
      SelectDatasets,
      AddDataOperation,
    },
    data: () => ({
      datasets: [],
      dragged_dataset: [],
      dragged_field: null,
      dragged_field_index: null,

      /**
       * Поля для перестаскивания операций
       */
      dragged_data_operation: null,
      dragged_data_operation_index: null,

      to_selected_fields: [],
      to_sort_fields: [],
      operations_to_fields: [],
      result_fields: [],

      show_operation_component: false,

      loading_data_operations: false,
      data_operations: [],

      operations: [
        '>',
        '<',
        '<>',
        '=',
      ],

      file_task_loading: false,
    }),
    computed: {

      /**
       * @return {string}
       */
      download_file_task_button_text() {
        return this.file_task_loading ? 'Формируется файл с заданием' : 'Сформировать задание';
      },

    },
    async mounted() {
      await this.loadDataOperations();
    },
    methods: {

      /**
       * Загружает сохранённые операции над полями датасетов
       */
      async loadDataOperations() {
        this.loading_data_operations = true;

        window.axios.get('/api/data_operation').then(response => {
          this.data_operations = response.data.content.data_operations.map(data => {
            return new DataOperation(data);
          });
        }).catch(errors => {
          console.error(errors.response.data.messages);
        }).finally(() => {
          this.loading_data_operations = false;
        });
      },

      /**
       * Открывает окно компонента добавления операции для применения к данным датасетов
       */
      openAddOperationComponent() {
        this.show_operation_component = true;
      },

      /**
       * Закрывает окно компонента добавления операции для применения к данным датасетов
       */
      async closeAddOperationComponent() {
        this.show_operation_component = false;
        await this.loadDataOperations();
      },

      /**
       * Открывает датасеты для работы с ними
       *
       * @param {Array<DataSet>} datasets
       */
      openDatasets(datasets) {
        this.datasets.push(...datasets);
      },

      addResultField() {
        this.result_fields.push({
          name: '',
          formula: '',
        });
      },

      removeResultField(index) {
        this.result_fields.splice(index, 1);
      },

      addCondition() {
        this.operations_to_fields.push({
          field: null,
          condition: '=',
          value: '',
        });
      },

      onDragStart(field, field_index, dataset) {
        this.dragged_dataset = dataset;
        this.dragged_field = field;
        this.dragged_field_index = field_index;
      },

      onDragEnd() {
        this.dragged_dataset = null;
        this.dragged_field = null;
        this.dragged_field_index = null;
      },

      /**
       * Срабатывает при перетаскивании мышки с чипсом операцией
       *
       * @param {DataOperation} data_operation
       * @param {number} data_operation_index
       */
      onDragStartDataOperation(data_operation, data_operation_index) {
        this.dragged_data_operation = data_operation;
        this.dragged_data_operation_index = data_operation_index;
      },

      /**
       * Срабатывает при отпускании мышки с чипсом операцией
       */
      onDragEndDataOperation() {
        this.dragged_data_operation = null;
        this.dragged_data_operation_index = null;
      },

      onDropSelectedFields() {
        if (this.dragged_dataset.id) {
          this.to_selected_fields.push({
            ...this.dragged_field,
            dataset_id: this.dragged_dataset.id,
            dataset_name: this.dragged_dataset.name,
          });

          this.to_selected_fields = [...uniqWith(this.to_selected_fields, isEqual)];
        }
      },

      onDropResultField(item) {
        let ds_name = '';

        if (item.formula === undefined) {
          item.formula = '';
        }

        if (this.dragged_data_operation) {
          ds_name = this.dragged_data_operation.formula;
        } else {
          ds_name = `[${this.dragged_dataset.name}.${this.dragged_field.name}]`;

          if (!item.name) {
            item.name = `\`${this.dragged_dataset.name}.${this.dragged_field.name}\``;
          }
        }

        item.formula += ds_name;
      },

      onDropSortFields() {
        if (this.dragged_dataset.id) {
          this.to_sort_fields.push({
            ...this.dragged_field,
            dataset_id: this.dragged_dataset.id,
            dataset_name: this.dragged_dataset.name,
          });

          this.to_sort_fields = [...uniqWith(this.to_sort_fields, isEqual)];
        }
      },

      /**
       * @param {number} index
       */
      onDropOperationField(index) {
        this.operations_to_fields[index].field = { ...this.dragged_field, dataset_name: this.dragged_dataset.name };

        this.to_sort_fields = [...this.to_sort_fields];
      },

      /**
       * @param {number} index
       */
      removeFieldFromSelect(index) {
        this.to_selected_fields.splice(index, 1);
      },

      /**
       * @param {number} index
       */
      removeFieldFromSort(index) {
        this.to_sort_fields.splice(index, 1);
      },
      removeFieldFromOperationField(index) {
        this.operations_to_fields[index].field = null;
      },
      removeOperation(index) {
        this.operations_to_fields.splice(index, 1);
      },

      async createTask() {
        this.file_task_loading = true;

        const queries = await window.axios.post(
          '/api/run_query',
          {
            select: this.to_selected_fields,
            where: this.operations_to_fields,
            sort: this.to_sort_fields,
          },
        );

        const task_object = {
          result_fields: this.result_fields,
          queries: queries.data.content.queries,
        };

        this.downloadTaskFile(task_object);
      },

      /**
       * Формирует объект задания на выборку датасета
       *
       * @param {Object} task_object
       * @return {Object} this (VueComponent)
       */
      downloadTaskFile(task_object) {
        window.axios({
          url: '/api/download_task_file',
          method: 'POST',
          responseType: 'blob',
          data: {
            task: task_object,
          },
        }).then(response => {
          const task_filename = response.headers.filename;
          const task_blob = new Blob([response.data]);

          this.downloadBlob(task_blob, `${task_filename}`);
        }).finally(() => {
          this.file_task_loading = false;
        });
      },

      /**
       * Скачивает блоб-файл
       *
       * @param {Blob} blob - блоб-объект
       * @param {string} filename - название файла
       * @return {Object} this (VueComponent)
       */
      downloadBlob(blob, filename) {
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');

        link.href = url;
        link.setAttribute('download', filename);
        link.click();

        return this;
      },
    },
  };
</script>

<style scoped>
  .fields-container {
    min-height: 3.2em;
    border: 2px dashed #46abf8;
  }

  .border-vtb-blue {
    border: 2px solid #46abf8 !important;
  }

  .width-select {
    max-width: 100px;
  }

  ::v-deep .v-text-field--outlined fieldset {
    color: #46abf8 !important;
  }
</style>
