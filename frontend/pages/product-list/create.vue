<template>
  <div class="container">
    <p>Create</p>
    <form @submit.prevent="create">
      <label for="name">Name: </label>
      <input type="text" v-model="form.name" name="name">
      <span class="is_invalid" v-if="err.name"> {{ err.name[0] }}</span>
      <input type="submit" value="Create">
    </form>
  </div>
</template>

<script>
export default {
  name: "create",
  middleware: 'auth',
  data() {
    return {
      form: {
        name: '',
        user_id: this.$auth.user.id,
      },
      err: {},
    }
  },
  methods: {
    async create() {
      try {
        await this.$axios.post('/product-list/create', this.form, {})

        this.$router.push({name: 'index'});
      } catch (err) {
        this.err = err.response.data.errors
        return;
      }
    }
  }
}
</script>

<style scoped>

</style>