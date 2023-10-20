<template>
  <div>
    <div class="all_prod_types">
      <div v-for="general_type_product in general_type_products">
        <div>
          <nuxt-link :to="'/general-type-product/' + general_type_product.id">
            <p>{{ general_type_product.name }}</p>
          </nuxt-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "GeneralProductType",

  data() {
    return {
      page: 1,
      general_type_products: [],
      links: {}
    }
  },
  methods: {
    async fetchData() {
      await this.$axios.get('/general-type-products/get')
          .then((res) => {
            this.general_type_products = res.data.data.data
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