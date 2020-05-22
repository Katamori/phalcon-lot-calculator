<template>
  <div id="app">
    <img alt="My Robohash" src="./assets/my_robohash.png">
    <LotCalc msg="Phalcon Lot Calculator"/>
  </div>
</template>

<script>
import LotCalc from './components/LotCalc.vue'

export default {
  name: 'App',
  components: {
    LotCalc
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
