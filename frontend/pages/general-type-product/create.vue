<template>
  <div class="container mx-auto align-middle flex w-100">
    <div class="sm:mx-auto w-2/5 h-full flex flex-col items-center justify-center">
      <div class="bg-white w-full rounded-lg pt-12 pb-7">
        <h1 class="text-center w-full pb-5 text-2xl">Create General Type</h1>
        <el-form :model="form" status-icon ref="form" class="flex flex-col justify-center items-center">
          <el-form-item prop="name" class="w-3/5">
            <el-input placeholder="Name" type="name" v-model="form.name"></el-input>
            <span class="is_invalid" v-if="err.name"> {{ err.name[0] }}</span>
            <color-picker start-color="#ffffff" :width="240" :height="240" v-model="form.color" :style="{background: form.color}"></color-picker>
          </el-form-item>
          <el-form-item class="mb-0 text-center w-3/5">
            <el-button type="primary" @click="create('form')" class="px-6 w-full">
              Create!
            </el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
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
        color: '',
        user_id: this.$auth.user.id,
      },
      err: {},
    }
  },
  methods: {
    async create() {
      try {
        await this.$axios.post('/general-type-product/create', this.form, {})

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