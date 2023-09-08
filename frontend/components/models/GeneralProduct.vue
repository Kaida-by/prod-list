<template>
  <div>
    <div class="all_prod_types">
      <div v-for="general_product in general_products">
        <div>
          <nuxt-link :to="'/general-product/' + general_product.id">
            <p>{{ general_product.name }}</p>
          </nuxt-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "GeneralProduct",

  data() {
    return {
      page: 1,
      general_products: [],
      links: {}
    }
  },
  methods: {
    async fetchData() {
      await this.$axios.get('/general-products/get')
          .then((res) => {
            this.general_products = res.data.data.data
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