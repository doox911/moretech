<template>
  <v-container>
    <v-dialog
      v-model="dialog"
      max-width="700px"
      :transition="false"
      persistent
    >
      <v-card>
        <v-card-title style="padding-bottom: 0;">
          <span class="text-h5">
            Добавить операцию над полем датасета
          </span>
        </v-card-title>

        <v-card-text class="pt-0">
          <v-row>
            <v-col
              class="pl-2 pr-2"
              cols="5"
            >
              <v-text-field
                v-model="new_data_operation.name"
                label="Название операции"
                hide-details
              />
            </v-col>
            <v-col
              class="pl-2 pr-2"
              cols="7"
            >
              <v-text-field
                v-model="new_data_operation.formula"
                label="Формула (символ или набор символов)"
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
            @click="addDataOperation"
          >
            Применить
          </v-btn>
          <v-btn
            color="primary"
            text
            :disabled="create_loading"
            @click="closeAddDataOperationDialog"
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
  import DataOperation from 'Classes/DataOperation';

  export default {
    name: 'AddDataOperation',
    data: () => ({
      dialog: true,
      new_data_operation: new DataOperation({}),
      create_loading: false,
    }),
    computed: {},
    watch: {},
    async mounted() {
      this.new_data_operation = new DataOperation({});
    },
    methods: {

      /**
       * Добавляет операцию над полем датасета
       */
      addDataOperation() {
        this.create_loading = true;

        window.axios.post('/api/data_operation', {
          name: this.new_data_operation.name,
          formula: this.new_data_operation.formula,
        }).then(response => {
          this.new_data_operation = new DataOperation({});

          this.$toast.open({
            message: 'Операция ' + response.data.content.new_data_operation.name + ' над полем датасета добавлена',
            type: 'success',
            duration: 3000,
          });

          this.closeAddDataOperationDialog();
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
       * Закрывает диалоговое окно добавления операции над полем датасета
       */
      closeAddDataOperationDialog() {
        this.$emit('close');
      },

    },
  };
</script>
