<template>
  <div class="container mx-auto align-middle flex w-100">
    <div class="sm:mx-auto w-2/5 h-full flex flex-col items-center justify-center">
      <div class="bg-white w-full rounded-lg pt-12 pb-7">
        <h1 class="text-center w-full pb-5 text-2xl">Create Product!</h1>
        <el-form :model="form" status-icon ref="form" class="flex flex-col justify-center items-center">
          <el-form-item prop="name">
            <el-select
                v-model="form.name"
                filterable
                allow-create
                default-first-option
                :reserve-keyword="false"
                placeholder="Name"
                style="width: 240px"
                no-data-text="No data"
            >
              <el-option
                  v-for="general_product in general_products"
                  :key="general_product.name"
                  :label="general_product.name"
                  :value="general_product.name"
              />
            </el-select>
<!--            <el-input placeholder="Name" type="name" v-model="form.name"></el-input>-->
            <span class="is_invalid" v-if="err.name"> {{ err.name[0] }}</span>
          </el-form-item>
          <p>Your Product Types:</p>
          <el-select
              v-model="form.type_product_id"
              placeholder="Select"
              style="width: 240px"
          >
            <el-option
                v-for="type_product in type_products"
                :key="type_product.name"
                :label="type_product.name"
                :value="type_product.id"
            />
          </el-select>
          <p>Count: </p>
          <el-input-number v-model="form.count" :min="1" :max="999999999" />
          <p>Your Type Counts:</p>
          <el-select
              v-model="form.type_count_id"
              placeholder="Select"
              style="width: 240px"
          >
            <el-option
                v-for="type_count in type_counts"
                :key="type_count.name"
                :label="type_count.name"
                :value="type_count.id"
            />
          </el-select>
          <el-input
              v-model="form.comment"
              :rows="2"
              type="textarea"
              placeholder="Comment"
          ></el-input>
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
        count: '',
        type_count_id: '',
        type_product_id: '',
        user_id: this.$auth.user.id,
        comment: '',
      },
      err: {},
      type_products: [],
      type_counts: [],
      general_products: []
    }
  },
  methods: {
    async create() {
      try {
        await this.$axios.post('/product/create', this.form, {})

        this.$router.push({name: 'index'});
      } catch (err) {
        this.err = err.response.data.errors
        return;
      }
    },
    async fetchTypeProducts() {
      try {
        await this.$axios.get('type-products/get')
            .then((res) => {
              this.type_products = res.data.data.data
            })
            .catch(err => console.log(err))
      } catch (e) {
        console.log(e)
        return
      }
    },
    async fetchTypeCounts() {
      try {
        await this.$axios.get('type-counts/get')
            .then((res) => {
              this.type_counts = res.data.data
            })
            .catch(err => console.log(err))
      } catch (e) {
        console.log(e)
        return
      }
    },
    async fetchGeneralProducts() {
      await this.$axios.get('/general-products/get')
          .then((res) => {
            this.general_products = res.data.data.data
          })
          .catch(err => console.log(err))
    }
  },
  mounted() {
    this.fetchTypeProducts()
    this.fetchTypeCounts()
    this.fetchGeneralProducts()
  }
}
</script>

<style scoped>

</style>