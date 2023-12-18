<template>
  <div class="first_page">
    <product-list></product-list>
  </div>
<!--    <el-button type="success" class="px-6">-->
<!--      <nuxt-link :to="'/product-list/create'">Create new Product List!</nuxt-link>-->
<!--    </el-button>-->

<!--    <div class="prodType">-->
<!--      <general-product-type></general-product-type>-->
<!--    </div>-->
<!--    <div class="prod">-->
<!--      <general-product></general-product>-->
<!--    </div>-->
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
  .first_page {
    width: 100%;
    display: flex;
    flex-direction: column;
  }
</style>
