<template>
  <div class="container mx-auto align-middle flex w-100">
    <div class="sm:mx-auto w-2/5 h-full flex flex-col items-center justify-center">
      <div class="bg-white w-full rounded-lg pt-12 pb-7">
        <h1 class="text-center w-full pb-5 text-2xl">Update Your Product List</h1>
        <el-form :model="form" status-icon ref="form" class="flex flex-col justify-center items-center">
          <el-form-item prop="name" class="w-3/5">
            <el-input placeholder="Name" type="name" v-model="form.name"></el-input>
            <span class="is_invalid" v-if="err.name"> {{ err.name[0] }}</span>
          </el-form-item>
          <!--------------------------------------------------------------------------------------------------------------------->
          <span>Update Your type products</span>
          <div v-for="(productType, indx) in form.typeProducts" :key="indx" class="all_prod_types w-3/5">
            <el-select
                v-model="productType.name"
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
            <!--------------------------------------------------------------------------------------------------------------------->
            <div class="all_prods">
              <span>Update Your Products: </span>
              <div class="container mx-auto align-middle flex w-full">
                <div class="sm:mx-auto h-full flex flex-col items-center justify-center w-full">
                  <div v-for="(product, index) in productType.products" :key="index"
                       class="bg-white w-full rounded-lg pt-1 pb-1">
                    <el-select
                        v-model="product.name"
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
                    <p>Count: </p>
                    <el-input-number v-model="product.count" :min="1" :max="999999999" />
                    <p>Your Type Counts:</p>
                    <el-select
                        v-model="product.type_count_id"
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
                    <template>
                      <el-input
                          v-model="product.comment.text"
                          :rows="2"
                          type="textarea"
                          placeholder="Comment"
                      />
                    </template>
                    <div class="pl_btn_bl gutter">
                      <el-button type="primary" @click="addInputProduct(indx)" class="px-6">
                        + p
                      </el-button>
                      <el-button type="danger" @click="removeInputProduct(indx, product.id, index)" class="px-6">
                        - p
                      </el-button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--------------------------------------------------------------------------------------------------------------------->
            <div class="pl_btn_bl gutter">
              <el-button type="primary" @click="addInputTypeProduct" class="px-6">
                + tp
              </el-button>
              <el-button type="danger" @click="removeInputTypeProduct(indx, productType.id)" class="px-6">
                - tp
              </el-button>
            </div>
          </div>
          <!--------------------------------------------------------------------------------------------------------------------->
          <el-form-item class="mb-0 text-center w-3/5">
            <el-button type="success" @click="update('form')" class="px-6 w-full">
              Update!
            </el-button>
            <el-button type="danger" @click="deleteProdList('form')" class="px-6 w-full">
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
        user_id: this.$auth.user.id,
        typeProducts: [{
          name: '',
          products: [
            {
              name: '',
              count: '',
              type_count_id: '',
              comment_id: '',
              comment: {
                text: '',
              },
            }
          ],
        }],
      },
      err: {},
      general_type_products: [],
      general_products: [],
      type_counts: []
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
    async fetchGeneralTypeProducts() {
      await this.$axios.get('/general-type-products/get')
          .then((res) => {
            this.general_type_products = res.data.data.data
          })
          .catch(err => console.log(err))
    },
    async fetchGeneralProduct() {
      await this.$axios.get('/general-products/get')
          .then((res) => {
            this.general_products = res.data.data.data
          })
          .catch(err => console.log(err))
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
    async addInputProduct(typeProductIndex) {
      this.form.typeProducts[typeProductIndex].products.push({
        name: '',
        count: '',
        type_count_id: '',
        comment_id: '',
      });
    },
    async removeInputProduct(typeProductIndex, productId, productIndex) {
      await this.deleteProductFromProdList(productId);
      this.form.typeProducts[typeProductIndex].products.splice(productIndex, 1);
    },
    async addInputTypeProduct() {
      this.form.typeProducts.push({
        name: '',
        products: [
          {
            name: '',
            count: '',
            type_count_id: '',
            comment_id: '',
          }
        ],
      });
    },
    async removeInputTypeProduct(index, indexTypeProduct) {
      await this.deleteTypeProductFromProdList(indexTypeProduct);
      this.form.typeProducts.splice(index, 1);
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
    },
    async deleteProdList() {
      if (confirm("Do you really want to delete this Product List?")) {
        try {
          this.$axios.delete('/product-list/delete/' + this.$route.params.id).then(response => {
            this.$router.push({name: 'index'});
          });
        } catch(e) {
          return;
        }
      }
    },
    async deleteTypeProductFromProdList(index) {
      try {
        this.$axios.delete('/product-list/delete-type-product/' + index).then(response => {
        });
      } catch(e) {
        return;
      }
    },
    async deleteProductFromProdList(index) {
      try {
        this.$axios.delete('/product-list/delete-product/' + index).then(response => {
        });
      } catch(e) {
        return;
      }
    },
  },
  mounted () {
    this.fetchData()
    this.fetchGeneralTypeProducts()
    this.fetchGeneralProduct()
    this.fetchTypeCounts()
  }
}
</script>

<style scoped>

</style>