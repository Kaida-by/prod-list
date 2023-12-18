<template>
  <div class="container">
    <div class="sm:mx-auto w-2/5 h-full flex flex-col items-center justify-center">
      <div class="bg-white w-full rounded-lg pt-12 pb-7">
        <h1 class="text-center w-full pb-5 text-2xl">Update General Product!</h1>
        <el-form :model="form" status-icon ref="form" class="flex flex-col justify-center items-center">
          <el-form-item prop="name" class="w-3/5">
            <el-input placeholder="Name" type="name" v-model="form.name"></el-input>
            <span class="is_invalid" v-if="err.name"> {{ err.name[0] }}</span>
          </el-form-item>

          <el-select
              v-model="form.type_product_id"
              filterable
              allow-create
              default-first-option
              :reserve-keyword="false"
              placeholder="Name Your type products"
              no-data-text="No data"
              class="w-3/5"
          >
            <el-option
                v-for="general_type_product in general_type_products"
                :key="general_type_product.name"
                :label="general_type_product.name"
                :value="general_type_product.id"
            />
          </el-select>

          <el-form-item class="mb-0 text-center w-3/5">
            <el-button type="primary" @click="update('form')" class="px-6 w-full">
              Update!
            </el-button>
            <el-button type="danger" @click="deleteGeneralProduct('form')" class="px-6 w-full">
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
        type_product_id: '',
        user_id: this.$auth.user.id,
      },
      err: {},
      general_type_products: [],
      basic_type_products: [],
    }
  },
  methods: {
    async fetchData() {
      try {
        const response = await this.$axios.get(`/general-product/${this.$route.params.id}`)
        const general_product = response.data.data

        this.form = Object.assign({}, this.form, general_product)
      } catch (error) {
        console.log(error)
      }
    },
    async update() {
      try {
        await this.$axios.patch('/general-product/update/' + this.$route.params.id, this.form, {})

        this.$router.push({name: 'index'});
      } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
          this.err = error.response.data.errors
        } else {
          console.log(error)
        }
      }
    },
    async deleteGeneralProduct() {
      if (confirm("Do you really want to delete this General Product?")) {
        try {
          this.$axios.delete('/general-product/delete/' + this.$route.params.id).then(response => {
            this.$router.push({name: 'index'});
          });
        } catch(e) {
          return;
        }
      }
    },
    async fetchGeneralTypeProducts() {
      await this.$axios.get('/general-type-products/get')
          .then((res) => {
            this.general_type_products = res.data.data.data
          })
          .catch(err => console.log(err))
    },
    async fetchBasicTypeProducts() {
      await this.$axios.get('/basic-type-products/get')
        .then((res) => {
          this.basic_type_products = res.data.data
          this.general_type_products = this.general_type_products.concat(this.basic_type_products)
        })
        .catch(err => console.log(err))
    },
  },
  mounted () {
    this.fetchData()
    this.fetchGeneralTypeProducts()
    this.fetchBasicTypeProducts()
  }
}
</script>

<style scoped>

</style>
