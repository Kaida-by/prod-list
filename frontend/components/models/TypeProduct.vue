<template>
  <div class="container mx-auto align-middle flex w-full">
    <div class="sm:mx-auto w-full h-full flex flex-col items-center justify-center w-full">
      <div class="bg-white w-full rounded-lg pt-1 pb-1 w-full">
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
                  v-for="general_type_product in general_type_products"
                  :key="general_type_product.name"
                  :label="general_type_product.name"
                  :value="general_type_product.name"
              />
            </el-select>

            <span class="is_invalid" v-if="err.name"> {{ err.name[0] }}</span>
            <div class="all_prods">
              <span>Select Your Products: </span>
              <product></product>
            </div>

          </el-form-item>
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

import Product from "./Product";

export default {
  name: "TypeProduct",
  middleware: 'auth',
  components: {
    Product
  },

  data() {
    return {
      form: {
        name: '',
        user_id: this.$auth.user.id,
        product_list_id: '',
      },
      err: {},
      general_type_products: [],
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
    async fetchGeneralTypeProducts() {
      await this.$axios.get('/general-type-products/get')
          .then((res) => {
            this.general_type_products = res.data.data.data
          })
          .catch(err => console.log(err))
    }
  },
  mounted() {
    this.fetchGeneralTypeProducts()
  }
}
</script>

<style scoped>

</style>