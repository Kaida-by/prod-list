<template>
  <div>
    <div class="all_prod_types">
      <div v-for="product in products">
        <div>
          <nuxt-link :to="'/product/' + product.id">
            <p>{{ product.name }}</p>
            <p>{{ product.user_id }}</p>
            <p>{{ product.product_list_id }}</p>
          </nuxt-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Product",

  data() {
    return {
      page: 1,
      products: [],
      links: {}
    }
  },
  methods: {
    async fetchData() {
      await this.$axios.get('/products/get')
          .then((res) => {
            this.products = res.data.data.data
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