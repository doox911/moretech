<template>
  <v-container>
    <v-row class="text-center">
      <v-col
        v-for="(data_sample) in data_sampling"
        :key="data_sample.id"
      >
        <v-card
          class="mx-auto"
          max-width="344"
        >
          <v-card-text>
            <div>{{ data_sample.name }}</div>
            <p>adjective</p>
            <v-card-text v-if="data_sample.settings.reveal">
              <v-data-table
                :headers="data_sample.data.headers"
                :items="data_sample.data.items"
                :items-per-page="5"
                class="elevation-1"
              />
            </v-card-text>
            <v-card-text v-else>
              <v-sheet color="rgba(0, 0, 0, .12)">
                <v-sparkline
                  :value="data_sample.settings.value"
                  color="rgba(255, 255, 255, .7)"
                  height="100"
                  padding="24"
                  stroke-linecap="round"
                  smooth
                >
                  <template v-slot:label="item">
                    ${{ item.value }}
                  </template>
                </v-sparkline>
              </v-sheet>
            </v-card-text>
          </v-card-text>
          <v-card-actions>
            <v-btn
              text
              color="teal accent-4"
              @click="changeView(data_sample)"
            >
              табличный вид
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>

  /**
   * Classes
   */
  import DataSample from 'Classes/DataSample';

  export default {
    name: 'HelloWorld',
    data: () => ({
      data_sampling: [],
    }),
    computed: {

      DEFAULT_DATA_OBJECT() {
        return {
          headers: [
            { text: 'Специальность', value: 'name' },
            { text: 'Зарплата', value: 'salary' },
          ],
          items: [
            {
              name: 'Программист',
              salary: 200000,
            },
            {
              name: 'Менеджер',
              salary: 30000,
            },
            {
              name: 'Сис.админ',
              salary: 15000,
            },
          ],
        };
      },
    },
    mounted() {
      this.data_sampling.push(new DataSample({
        id: 1,
        name: 'Заработные платы Московская область',
        settings: {
          value: [
            423,
            446,
            675,
            510,
            590,
            610,
            760,
          ],
        },
        data: this.DEFAULT_DATA_OBJECT,
      }));

      this.data_sampling.push(new DataSample({
        id: 2,
        name: 'Заработные платы Пензенская область',
        settings: {
          value: [
            423,
            446,
            675,
            510,
            590,
            610,
            760,
          ],
          reveal: false,
        },
        data: this.DEFAULT_DATA_OBJECT,
      }));

      this.onDataLoaded();
    },
    methods: {

      /**
       * Вызывается в момент срабатывания события сокета, пришли данные на запрос
       *
       * @return {undefined}
       */
      onDataLoaded() {
        this.data_sampling.push(new DataSample({
          id: 3,
          name: 'Заработные платы Астраханская область',
          settings: {
            value: [
              423,
              446,
              675,
              510,
              590,
              610,
              760,
            ],
            reveal: false,
          },
          data: this.DEFAULT_DATA_OBJECT,
        }));
      },

      changeView(data_sample) {
        this.$nextTick(() => {
          // this.$set;
          data_sample.settings.reveal = !data_sample.settings.reveal;
        });
      },

    },
  };
</script>

<style>
  .v-card--reveal {
    bottom: 0;
    opacity: 1 !important;
    position: absolute;
    width: 100%;
  }
</style>
