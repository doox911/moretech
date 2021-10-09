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
    </v-row>
    <v-row justify="space-around">

      <!-- Selected -->
      <v-col
        class="pa-3 rounded-lg fields-container"
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
        class="pa-3 rounded-lg fields-container"
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
            <v-row align="center"
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
                  label="Значение для операции"
                  class="border-radius"
                  color="primary"
                  v-model="item.value"
                  hide-details
                  outlined
                />
              </v-col>

              <v-spacer></v-spacer>

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

        <div :key="`where-divider-${index}`"
          class="divider vtb-color-border"
        ></div>
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

  import { isEqual, uniqWith } from 'lodash';
  import SelectDatasets from './SelectDatasets';

  export default {
    name: 'Constructor',

    components: {
      SelectDatasets,
    },

    data: () => ({
      datasets: [],
      dragged_dataset: [],
      dragged_field: null,
      dragged_field_index: null,

      to_selected_fields: [],
      to_sort_fields: [],
      operations_to_fields: [],

      operations: [
        '>',
        '<',
        '=',
      ],
    }),

    computed: {},

    async mounted() {
      // const path = 'https://datahub.io/core/population/datapackage.json';
      //
      // const response = await fetch(path);
      //
      // const data = await response.json();
      //
      // const schemas = data.resources.map(r => r.schema).filter(e => !!e);
      //
      // this.datasets.push({
      //   name: data.name,
      //   schemas,
      // });
      //
      // console.log(this.datasets);
    },

    methods: {
      openDatasets(datasets) {
        this.datasets.push(...datasets);

        console.log(datasets);
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

      onDropSelectedFields() {
        this.to_selected_fields.push({
          ...this.dragged_field,
          dataset_id: this.dragged_dataset.id,
          dataset_name: this.dragged_dataset.name,
        });

        this.to_selected_fields = [...uniqWith(this.to_selected_fields, isEqual)];
      },

      onDropSortFields() {
        this.to_sort_fields.push({
          ...this.dragged_field,
          dataset_id: this.dragged_dataset.id,
          dataset_name: this.dragged_dataset.name,
        });

        this.to_sort_fields = [...uniqWith(this.to_sort_fields, isEqual)];
      },

      onDropOperationField(index) {
        this.operations_to_fields[index].field = { ...this.dragged_field };

        this.to_sort_fields = [...this.to_sort_fields];
      },

      removeFieldFromSelect(index) {
        this.to_selected_fields.splice(index, 1);
      },

      removeFieldFromSort(index) {
        this.to_sort_fields.splice(index, 1);
      },
      removeFieldFromOperationField(index) {
        this.operations_to_fields[index].field = null;
      },
      removeOperation(index) {
        this.operations_to_fields.splice(index, 1);
      },

      createTask() {

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
