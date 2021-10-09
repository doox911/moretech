<template>
  <v-container fluid>
    <v-row>
      <v-col cols="auto">
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
        <v-card>
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
        <v-card>
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
    <v-row>
      <!-- Selected -->
      <v-col
        class="ma-2 pa-3 rounded-lg fields-container"
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
        class="ma-2 pa-3 rounded-lg fields-container"
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
      <v-col>
        <v-row
          v-for="(item, index) in operations_to_fields"
          :key="index"
          align="center"
        >
          <v-col
            cols="12"
            class="ma-2 pa-3 rounded-lg fields-container"
          >
            <div
              @dragenter.prevent
              @dragover.prevent
              @dragleave.prevent
              @drop.prevent="onDropOperationField(index)"
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
          <v-col
            cols="12"
          >
            <v-row>
              <v-col cols="10">
                <v-select
                  v-model="item.condition"
                  rounded
                  class="background-vtb-l-blue border-vtb-blue"
                  :items="operations"
                  title="выбрать операцию фильтра"
                  label="выбрать операцию фильтра"
                />
              </v-col>
              <v-col cols="2" />
            </v-row>

            <v-row>
              <v-col>
                <v-text-field
                  v-model="item.value"
                  hide-details
                  label="условие поля"
                />
              </v-col>
            </v-row>
          </v-col>
        </v-row>
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
      align="center"
      justify="center"
    >
      <v-col cols="auto">
        <v-btn
          color="vtb-color"
          text
          rounded
          @click="createTask"
        >
          Сформировать задание
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
        '+',
        '-',
        '/',
        '*',
        '=',
      ],
    }),
    computed: {},
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

      openAddOperationComponent() {
        this.show_operation_component = true;
      },

      closeAddOperationComponent() {
        this.show_operation_component = false;
      },

      /**
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
        this.to_selected_fields.push({
          ...this.dragged_field,
          dataset_id: this.dragged_dataset.id,
          dataset_name: this.dragged_dataset.name,
        });

        this.to_selected_fields = [...uniqWith(this.to_selected_fields, isEqual)];
      },

      onDropResultField(item) {
        let ds_name = '';

        if (this.dragged_data_operation) {
          ds_name = this.dragged_data_operation.formula;
        } else {
          ds_name = `${this.dragged_dataset.name}.${this.dragged_field.name}`;

          if (!item.name) {
            item.name = ds_name;
          }
        }

        item.formula += ds_name;
      },

      onDropSortFields() {
        this.to_sort_fields.push({
          ...this.dragged_field,
          dataset_id: this.dragged_dataset.id,
          dataset_name: this.dragged_dataset.name,
        });

        this.to_sort_fields = [...uniqWith(this.to_sort_fields, isEqual)];
      },

      /**
       * @param {number} index
       */
      onDropOperationField(index) {
        this.operations_to_fields[index].field = { ...this.dragged_field };

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

      async createTask() {
        await window.axios.post('/api/run_query', {
          result_fields: this.result_fields,
          select: this.to_selected_fields,
          where: this.operations_to_fields,
          sort: this.to_sort_fields,
        });
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
</style>
