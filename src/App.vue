<template>
  <nav class="navbar bg-light">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">SoloTrack - Cek Ongkir Paket</span>
  </div>
</nav>
</template>

<script>
import { onMounted, reactive, ref } from 'vue'
import axios from 'axios'

  export default {
    setup() {

      /**
       * state province
       */
      const provinces = ref({})

      /**
       * state ID for province and city
       */
      const state = reactive({
        
        province_origin: "",
        city_origin: "",

        province_destination: "",
        city_destination: "",

        weight: "",
        courier: ""
      })

      /**
       * state cities origin
       */
      const cities_origin    = ref({}) 

      /**
       * state cities destination
       */
      const cities_destination    = ref({}) 

      /**
       * resulCost
       */
      const resultCost = ref(null)

      onMounted(() => {

        axios.get('http://localhost:8000/api/provinces').then(response => {
          provinces.value = response.data.data
        })
        .catch(error => {
          console.log(error.response.data)
        })

      })
      
      /**
       * function getCitiesOrigin
       */
      function getCitiesOrigin() {
        
        axios.get(`http://localhost:8000/api/cities/${state.province_origin}`).then(response => {
          cities_origin.value = response.data.data
        })
        .catch(error => {
          console.log(error.response.data)
        })

      }

      /**
       * function getCitiesDestination
       */
      function getCitiesDestination() {

        axios.get(`http://localhost:8000/api/cities/${state.province_destination}`).then(response => {
          cities_destination.value = response.data.data
        })
        .catch(error => {
          console.log(error.response.data)
        })

      }

      /**
       * function getCostOngkir
       */
      function getCostOngkir() {

        axios.post('http://localhost:8000/api/checkOngkir/', {

          //send data ke server laravel
          origin: state.city_origin,
          destination: state.city_destination,
          weight: state.weight,
          courier: state.courier

        }).then(response => {
          resultCost.value = response.data.data[0].costs
        })
        .catch(error => {
          console.log(error.response.data)
        })

      }

      return {
        provinces, state, cities_origin, cities_destination, getCitiesOrigin, getCitiesDestination, getCostOngkir, resultCost
      }

    }

  }
</script>

<style>
  body {
    background: lightgrey !important;
  }
</style>
