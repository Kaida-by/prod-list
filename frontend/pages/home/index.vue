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
        <nuxt-link :to="'/general-type-product/create'">Create new General Type Product!</nuxt-link>
      </el-button>
      <general-product-type></general-product-type>
    </div>
    <div class="prod">
      <el-button type="success" class="px-6">
        <nuxt-link :to="'/general-product/create'">Create new General Product!</nuxt-link>
      </el-button>
      <general-product></general-product>
    </div>
  </div>
</template>

<script>

import ProductList from "../../components/models/ProductList";
import GeneralProductType from "../../components/models/GeneralProductType";
import GeneralProduct from "../../components/models/GeneralProduct";

export default {
  name: "home",
  middleware: 'auth',

  components: {
    ProductList,
    GeneralProductType,
    GeneralProduct
  },
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
