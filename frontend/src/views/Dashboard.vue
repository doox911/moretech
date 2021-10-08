<template>
  <div class="page">
    <v-row>
      <v-col cols="8">
        <v-btn
          v-for="entityName in entities"
          :key="entityName"
          color="success"
          class="mx-1"
          @click="getData(entityName)"
        >{{ entityName }}</v-btn>
      </v-col>

      <v-col>
        <v-row>
          <v-col>
            <v-select
              label="Поля объекта"
              :items="entityKeys"
              multiple
              v-model="entityKeysForChart"
            ></v-select>
          </v-col>

          <v-btn
            color="primary"
            @click="updateChart"
          >Update</v-btn>
        </v-row>
      </v-col>
    </v-row>

    <v-row>
      <bar-chart class="bar-chart" :chart-data="dataset" />
    </v-row>

    <v-row>
      <v-col cols="12">
        <v-data-table
          :headers="headers"
          :items="data"
        ></v-data-table>
      </v-col>
    </v-row>

  </div>
</template>

<script>
  import BarChart from '@/components/Charts/Bar';

  export default {
    components: {
      BarChart,
    },
    data() {
      return {
        entities: [
          'todos',
          'users',
          'albums',
          'photos',
          'comments',
          'custom',
        ],
        data: [],
        entityKeys: [],
        entityKeysForChart: [],
        dataset: {
          labels: [this.getRandomInt(), this.getRandomInt()],
          datasets: [
            {
              label: 'Data One',
              backgroundColor: 'red',
              data: [this.getRandomInt(), this.getRandomInt()],
            },
            {
              label: 'Data two',
              backgroundColor: 'black',
              data: [this.getRandomInt(), this.getRandomInt()],
            },
            {
              label: 'Data three',
              backgroundColor: 'green',
              data: [this.getRandomInt(), this.getRandomInt()],
            },
          ],
        },
      };
    },
    computed: {
      headers() {
        return this.entityKeysForChart.map(key => {
          return {
            text: key,
            value: key,
          }
        })
      },
    },
    methods: {
      getRandomInt() {
        return Math.round(Math.random() * 1000);
      },
      async getData(entityName = 'users') {
        this.entityKeysForChart = [];

        let data = []
        if(entityName === 'custom') {
          data = [
            {
              "value": 180,
              "title": "Weekly Active Users",
              "body": ""
            },
            {
              "value": 6,
              "title": "Datasets",
              "body": "83.33% have owners assigned!"
            },
            {
              "value": 1,
              "title": "Dashboards",
              "body": "100.00% have owners assigned!"
            },
            {
              "value": 2,
              "title": "Charts",
              "body": "0.00% have owners assigned!"
            },
            {
              "value": 1,
              "title": "Pipelines",
              "body": "100.00% have owners assigned!"
            },
            {
              "value": 2,
              "title": "Tasks",
              "body": "100.00% have owners assigned!"
            }
          ]
        } else {
          const response = await fetch(`https://jsonplaceholder.typicode.com/${entityName}`)
          data = await response.json()
        }

        this.data = data;

        const [entity] = data;
        this.entityKeys = Object.keys(entity)
      },
      randomColor() {
        return '#' + Math.floor(Math.random()*16777215).toString(16);
      },
      updateChart() {
        let datasets = []

        this.entityKeysForChart.map((label) => {
          const items = this.data.map(item => item[label])

          const itemsCount = {}
          items.map((item) => {
            if(itemsCount[item]) {
              itemsCount[item] += 1
            } else {
              itemsCount[item] = 1
            }
          })

          datasets.push({
            label,
            backgroundColor: this.randomColor(),
            data: Object.values(itemsCount),
          })
        })

        console.log('object', datasets);

        this.dataset = {
          labels: this.entityKeysForChart,
          datasets,
        }
      },
    },
  };
</script>

<style scoped>
.page {
  padding: 2rem;
}

.bar-chart {
  height: 100%;
  max-height: 400px;
}
</style>
