<template>
  <v-container fluid>
    <v-row
      v-for="(dataset, index) in datasets"
      :key="index"
    >
      <v-col cols="3">
        <v-card>
          <v-card-title> {{ dataset.name }}</v-card-title>
          <v-card-text>
            <div
              v-for="(schema, schema_index) in dataset.schemas"
              :key="schema_index"
            >
              <v-chip
                v-for="(field, field_index) in schema.fields"
                :key="field_index"
                class="ma-1"
                :draggable="true"
                @dragstart="onDragStart(field, field_index)"
                @dragend="onDragEnd()"
              >
                {{ field.name }}({{ field.type }})
              </v-chip>
            </div>
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
            @dblclick="removeFieldFromSelect(index)"
          >
            {{ field.name }}
          </v-chip>
        </template>
        <template v-else>
          <v-row justify="center">
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
            @dblclick="removeFieldFromSort(index)"
          >
            {{ field.name }}
          </v-chip>
        </template>
        <template v-else>
          <v-row justify="center">
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
        >
          <v-col>
            <div
              @dragenter.prevent
              @dragover.prevent
              @dragleave.prevent
              @drop.prevent="onDropOperationField(index)"
            >
              <template v-if="item.field">
                <v-chip
                  class="ma-2"
                >
                  {{ item.field.name }}
                </v-chip>
              </template>
              <template v-else>
                <v-row justify="center">
                  <v-col cols="auto">
                    <span class="user-select-none grey--text text--lighten-1 text-h4">
                      Свойство датасета
                    </span>
                  </v-col>
                </v-row>
              </template>
            </div>
          </v-col>
          <v-col>
            <v-select
              v-model="item.condition"
              :items="operations"
            />
          </v-col>
          <v-col>
            <v-text-field
              v-model="item.value"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-btn
              @click="addCondition"
            >
              Добавить условие
            </v-btn>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>

  /**
   * Classes
   */

  export default {
    name: 'Constructor',

    data: () => ({
      datasets: [],
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
      const path = 'https://datahub.io/core/population/datapackage.json';

      const response = await fetch(path);

      const data = await response.json();

      const schemas = data.resources.map(r => r.schema).filter(e => !!e);

      this.datasets.push({
        name: data.name,
        schemas,
      });

      console.log(this.datasets);
    },

    methods: {
      addCondition() {
        this.operations_to_fields.push({
          field: null,
          condition: '=',
          value: '',
        });
      },

      onDragStart(field, field_index) {
        this.dragged_field = field;
        this.dragged_field_index = field_index;
      },

      onDragEnd() {
        this.dragged_field = null;
        this.dragged_field_index = null;
      },

      async onDropSelectedFields() {
        this.to_selected_fields.push({ ...this.dragged_field });

        this.to_selected_fields = [...this.to_selected_fields];
      },

      async onDropSortFields() {
        this.to_sort_fields.push({ ...this.dragged_field });

        this.to_sort_fields = [...this.to_sort_fields];
      },

      async onDropOperationField(index) {
        this.operations_to_fields[index].field = { ...this.dragged_field };

        this.to_sort_fields = [...this.to_sort_fields];
      },

      removeFieldFromSelect(index) {
        this.to_selected_fields.splice(index, 1);
      },

      removeFieldFromSort(index) {
        this.to_sort_fields.splice(index, 1);
      },
    },
  };
</script>

<style scoped>

  .fields-container {
    min-height: 3.2em;
    border: 2px dashed #03A9F4;
  }
</style>
