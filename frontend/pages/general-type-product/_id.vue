<template>
  <div class="container">
    <div class="sm:mx-auto w-2/5 h-full flex flex-col items-center justify-center">
      <div class="bg-white w-full rounded-lg pt-12 pb-7">
        <h1 class="text-center w-full pb-5 text-2xl">Update General Type Product!</h1>
        <el-form :model="form" status-icon ref="form" class="flex flex-col justify-center items-center">
          <el-form-item prop="name" class="w-3/5">
            <el-input placeholder="Name" type="name" v-model="form.name"></el-input>
            <span class="is_invalid" v-if="err.name"> {{ err.name[0] }}</span>
            <color-picker start-color="#ffffff" :width="240" :height="240" v-model="form.color" :style="{background: form.color}"></color-picker>
          </el-form-item>
          <el-form-item class="mb-0 text-center w-3/5">
            <el-button type="primary" @click="update('form')" class="px-6 w-full">
              Update!
            </el-button>
            <el-button type="danger" @click="deleteTypeProd('form')" class="px-6 w-full">
              Delete!
            </el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
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
    async fetchData() {
      try {
        const response = await this.$axios.get(`/general-type-product/${this.$route.params.id}`)
        const type_product = response.data.data

        this.form = Object.assign({}, this.form, type_product)
      } catch (error) {
        console.log(error)
      }
    },
    async update() {
      try {
        await this.$axios.patch('/general-type-product/update/' + this.$route.params.id, this.form, {})
        this.$router.push({name: 'index'});
      } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
          this.err = error.response.data.errors
        } else {
          console.log(error)
        }
      }
    },
    async deleteTypeProd() {
      if (confirm("Do you really want to delete this General Type Product?")) {
        try {
          this.$axios.delete('/general-type-product/delete/' + this.$route.params.id).then(response => {
            this.$router.push({name: 'index'});
          });
        } catch(e) {
          return;
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