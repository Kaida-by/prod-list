<template>
  <div class="container mx-auto grid-cols-3 grid">
    <div class="prodList">
      <el-button type="success" class="px-6">
        <nuxt-link :to="'/product-list/create'">Create new Product List!</nuxt-link>
      </el-button>
      <product-list></product-list>
    </div>
    <div class="prodType">
      <el-button type="success" class="px-6">
        <nuxt-link :to="'/type-product/create'">Create new Type Product!</nuxt-link>
      </el-button>
      <product-type></product-type>
    </div>
    <div class="prod">
      <el-button type="success" class="px-6">
        <nuxt-link :to="'/product/create'">Create new Product!</nuxt-link>
      </el-button>
      <product></product>
    </div>
  </div>
</template>

<script>

import ProductList from "../../components/models/ProductList";
import ProductType from "../../components/models/ProductType";
import Product from "../../components/models/Product";

export default {
  name: "home",
  components: {
    ProductList,
    ProductType,
    Product
  },

  middleware: 'auth',
}
</script>

<style scoped>
  .prodList {
    background-color: #9ca3af;
  }
  .prodType {
    background-color: aquamarine;
  }
  .prod {
    background-color: burlywood;
  }
</style>
