<template>
  <div>
    <div class="all_prod_types">
      <div v-for="type_product in type_products">
        <div>
          <nuxt-link :to="'/type-product/' + type_product.id">
            <p>{{ type_product.name }}</p>
            <p>{{ type_product.user_id }}</p>
            <p>{{ type_product.product_list_id }}</p>
          </nuxt-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductType",

  data() {
    return {
      page: 1,
      type_products: [],
      links: {}
    }
  },
  methods: {
    async fetchData() {
      await this.$axios.get('/type-products/get')
          .then((res) => {
            this.type_products = res.data.data.data
          })
          .catch(err => console.log(err))
    }
  },
  mounted() {
    this.fetchData()
  }
}
</script>

<style scoped>

</style>