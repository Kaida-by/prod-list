<template>
  <div class="container mx-auto align-middle flex w-full">
    <div class="sm:mx-auto h-full flex flex-col items-center justify-center w-full">
      <div class="bg-white w-full rounded-lg pt-1 pb-1">
        <el-form :model="form" status-icon ref="form" class="flex flex-col justify-center items-center w-full">
          <el-form-item prop="name" class="w-full">
            <el-select
                v-model="form.name"
                filterable
                allow-create
                default-first-option
                :reserve-keyword="false"
                placeholder="Name"
                no-data-text="No data"
                class="w-full"
            >
              <el-option
                  v-for="general_product in general_products"
                  :key="general_product.name"
                  :label="general_product.name"
                  :value="general_product.name"
              />
            </el-select>
            <span class="is_invalid" v-if="err.name"> {{ err.name[0] }}</span>
          </el-form-item>
          <p>Count: </p>
          <el-input-number v-model="form.count" :min="1" :max="999999999" />
          <p>Your Type Counts:</p>
          <el-select
              v-model="form.type_count_id"
              placeholder="Select"
              class="w-full"
          >
            <el-option
                v-for="type_count in type_counts"
                :key="type_count.name"
                :label="type_count.name"
                :value="type_count.id"
            />
          </el-select>
          <el-form-item class="mb-0 text-center w-full">
            <el-button type="primary" @click="create('form')" class="px-6 w-full">
              +
            </el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Product",
  middleware: 'auth',

  data() {
    return {
      form: {
        name: '',
        count: '',
        type_count_id: '',
        comment_id: '',
        type_product_id: '',
        user_id: this.$auth.user.id,
      },
      err: {},
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
    this.fetchTypeCounts()
    this.fetchGeneralProducts()
  }
}
</script>

<style scoped>

</style>