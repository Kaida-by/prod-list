<template>
  <div>
    <div class="all_prod_lists">
      <div v-for="prod_list in prod_lists">
        <div>
          <nuxt-link :to="'/product-list/' + prod_list.id">
            <p>{{ prod_list.name }}; id - {{ prod_list.id }}</p>
          </nuxt-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductList",
  data() {
    return {
      page: 1,
      prod_lists: [],
      links: {}
    }
  },
  methods: {
    async fetchData() {
      await this.$axios.get('product-lists/get')
          .then((res) => {
            this.prod_lists = res.data.data.data
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