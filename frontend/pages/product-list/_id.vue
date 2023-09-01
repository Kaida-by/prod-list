<template>
  <div class="container">
    <div class="prod_list">
      <form @submit.prevent="update">
        <label for="name">Name: </label>
        <input type="text" v-model="form.name">
        <span class="is_invalid" v-if="err.name"> {{ err.name[0] }}</span>
        <input type="submit" value="Update">
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: '',
        user_id: this.$auth.user.id
      },
      err: {}
    }
  },
  methods: {
    async fetchData() {
      try {
        const response = await this.$axios.get(`/product-list/${this.$route.params.id}`)
        const prod_list = response.data.data

        this.form = Object.assign({}, this.form, prod_list)
      } catch (error) {
        console.log(error)
      }
    },
    async update() {
      try {
        await this.$axios.patch('/product-list/update/' + this.$route.params.id, this.form, {})

        this.$router.push({name: 'index'});
      } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
          this.err = error.response.data.errors
        } else {
          console.log(error)
        }
      }
    }
  },
  mounted () {
    this.fetchData()
  }
}
</script>

<style scoped>

</style>