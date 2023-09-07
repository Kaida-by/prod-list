<template>
  <div class="container mx-auto align-middle flex w-100">
    <div class="sm:mx-auto w-2/5 h-full flex flex-col items-center justify-center">
      <div class="bg-white w-full rounded-lg pt-12 pb-7">
        <h1 class="text-center w-full pb-5 text-2xl">Create Type Product!</h1>
        <el-form :model="form" status-icon ref="form" class="flex flex-col justify-center items-center">
          <el-form-item prop="name" class="w-3/5">
            <el-input placeholder="Name" type="name" v-model="form.name"></el-input>
            <span class="is_invalid" v-if="err.name"> {{ err.name[0] }}</span>
          </el-form-item>
          <p>Your Product Lists:</p>
          <el-select
              v-model="form.product_list_id"
              placeholder="Select"
              style="width: 240px"
          >
            <el-option
                v-for="prod_list in prod_lists"
                :key="prod_list.name"
                :label="prod_list.name"
                :value="prod_list.id"
            />
          </el-select>
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
        user_id: this.$auth.user.id,
        product_list_id: '',
      },
      err: {},
      prod_lists: [],
    }
  },
  methods: {
    async create() {
      try {
        await this.$axios.post('/type-product/create', this.form, {})

        this.$router.push({name: 'index'});
      } catch (err) {
        this.err = err.response.data.errors
        return;
      }
    },
    async fetchProdList() {
      try {
        await this.$axios.get('product-lists/get')
            .then((res) => {
              this.prod_lists = res.data.data.data
            })
            .catch(err => console.log(err))
      } catch (e) {
        console.log(e)
        return
      }
    }
  },
  mounted() {
    this.fetchProdList()
  }
}
</script>

<style scoped>

</style>