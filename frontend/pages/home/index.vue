<template>
  <div class="container mx-auto align-middle flex w-100">
    <product-list></product-list>
  </div>
</template>

<script>

import ProductList from "../../components/models/ProductList";

export default {
  name: "home",
  components: {
    ProductList
  },

  middleware: 'auth',
}
</script>

<style scoped>

</style>
