<template>
  <div class="hello">
    <h1>{{ title }}</h1>
    <p>
      Specify your upper left and lower right coordinates!
    </p>
    <form class="vue-form" @submit.prevent="submit">
      <Point title="Point A" input_i_d="pointA" ref="pointA"></Point>
      <Point title="Point B" input_i_d="pointB" ref="pointB"></Point>
      <br><br>
      <button>SUBMIT</button>
    </form>

    <h3>Results</h3>
    <div v-if="corners">
      <p>The other two corners:</p>
      <div v-for="corner in corners">
          <span>Latitude: {{ corner.x }}, longitude: {{ corner.y }} </span>
      </div>

    </div>
    <div v-if="perimeter && perimeter > 0">
      <p>Length of perimeter:</p>
      <span>{{ perimeter }} meters</span>
    </div>
    <div v-if="area && area > 0">
      <p>Area:</p>
      <span>{{ area }} square meters</span>
    </div>
    <div v-if="cost && cost > 0">
      <p>Cost:</p>
      <span>{{ cost }} EUR</span>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

import Point from './Point.vue';

export default {
  name: 'LotCalc',
  components: {
    Point
  },
  props: {
    title: String,
  },
  data: function() {
    return {
      "corners": [],
      "perimeter": -1,
      "area": -1,
      "cost": -1,
    }
  },
  methods: {
    submit: async function() {
      let response = await this.send([
        this.$refs.pointA.coords,
        this.$refs.pointB.coords,
      ]);

      console.log(response)

      if (!response) {
        return;
      }

      let data = response.data;

      this.corners = [
        data.corners['upper_right'],
        data.corners['lower_left'],
      ];
      this.perimeter = data.perimeter;
      this.area = data.area;
      this.cost = data.cost;
    },
    send: async function(data) {
      return await axios
        .post('http://localhost:7000/calculate', data)
        .catch(this.alertErrorMessage)
    },
    alertErrorMessage: function(error) {
      let data = error.response.data || [];

      data.forEach(dataItem => window.alert(dataItem.message || "Error!"))
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
