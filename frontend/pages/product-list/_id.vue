<template>
  <div class="container mx-auto align-middle flex w-100">
    <div class="sm:mx-auto w-2/5 h-full flex flex-col items-center justify-center">
      <div class="bg-white w-full rounded-lg pt-12 pb-7">
        <h1 class="text-center w-full pb-5 text-2xl">Update Your Product List</h1>
        <el-form :model="form" status-icon ref="form" class="flex flex-col justify-center items-center">
          <div class="form_pl">
            <el-form-item prop="name" class="w-10/12">
              <div class="form_pl_inp">
                <el-input placeholder="Name Product List" type="name" v-model="form.name"></el-input>
                <span class="is_invalid" v-if="err.name"> {{ err.name[0] }}</span>
              </div>
            </el-form-item>
          </div>
          <!--------------------------------------------------------------------------------------------------------------------->
          <div class="all_types">
            <span>Update Your type products</span>
            <div v-for="(productType, indx) in form.typeProducts" :key="indx" class="all_prod_types w-100 pt-1 pb-1">
              <div class="form_tp">
                <div class="from_tp_in w-10/12">
                  <el-select
                      v-model="productType.name"
                      filterable
                      allow-create
                      default-first-option
                      :reserve-keyword="false"
                      placeholder="Name Your type products"
                      no-data-text="No data"
                      class="w-full"
                      @change="changeDefaultProductTypeColor(productType)"
                  >
                    <el-option
                        v-for="general_type_product in general_type_products"
                        :key="general_type_product.name"
                        :label="general_type_product.name"
                        :value="general_type_product.name"
                    />
                  </el-select>
                </div>
                <div class="form_tp_clr">
                  <div class="clr_btn" @click="toggleDropdownTP(indx)" :style="{background: productType.color}" ref="dropdownTP"></div>
                  <div class="plt_clr" v-if="productType.showDropdown">
                    <div v-if="productType.color">
                      <color-picker
                          :width="240"
                          :height="240"
                          :start-color="productType.color"
                          v-model="productType.color"
                          :style="{background: productType.color, borderRadius: '50%'}"
                      >
                      </color-picker>
                    </div>
                    <div v-else>
                      <color-picker
                          :width="240"
                          :height="240"
                          start-color="#ffffff"
                          v-model="productType.color"
                          :style="{background: productType.color, borderRadius: '50%'}"
                      >
                      </color-picker>
                    </div>
                  </div>
                </div>
              </div>
<!--сделать нужно палитры {{$Q@$3}}-->
              <!--------------------------------------------------------------------------------------------------------------------->
              <div class="all_prods">
                <span>Update Your Products: </span>
                <div class="container mx-auto align-middle flex w-full">
                  <div class="sm:mx-auto h-full flex flex-col items-center justify-center w-full">
                    <div v-for="(product, index) in productType.products" :key="index"
                         class="bg-white w-full rounded-lg pt-1 pb-1">
                      <div class="form_tp">
                        <div class="from_tp_in w-10/12">
                          <el-select
                              v-model="product.name"
                              filterable
                              allow-create
                              default-first-option
                              :reserve-keyword="false"
                              placeholder="Name Your Products"
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
                        </div>
                      </div>

                      <p>Count: </p>
                      <div class="count_gen">
                        <div class="count_c">
                          <el-input-number v-model="product.count" :min="1" :max="999999999" />
                        </div>
                        <div class="type_count">
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
                        </div>
                      </div>
                      <div class="comm">
                        <template>
                          <el-input
                              v-model="product.comment"
                              :rows="2"
                              type="textarea"
                              placeholder="Comment"
                          />
                        </template>
                      </div>

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
        color: '',
        user_id: this.$auth.user.id,
        typeProducts: [{
          name: '',
          color: '',
          showDropdown: false,
          products: [
            {
              name: '',
              count: '',
              color: '',
              type_count_id: '',
              comment: '',
              showDropdown: false,
            }
          ],
        }],
      },
      err: {},
      general_type_products: [],
      basic_type_products: [],
      general_products: [],
      basic_products: [],
      type_counts: [],
      showDropdownPL: false,
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
        comment: '',
        showDropdown: false,
      });
    },
    async removeInputProduct(typeProductIndex, productId, productIndex) {
      await this.deleteProductFromProdList(productId);
      this.form.typeProducts[typeProductIndex].products.splice(productIndex, 1);
    },
    async addInputTypeProduct() {
      this.form.typeProducts.push({
        name: '',
        showDropdown: false,
        products: [
          {
            name: '',
            count: '',
            type_count_id: '',
            comment: '',
            showDropdown: false,
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
    async changeDefaultProductTypeColor(productType) {
      const generalTypeProduct = this.general_type_products.find(
          (product) => product.name === productType.name
      );
      if (generalTypeProduct) {
        productType.color = await generalTypeProduct.color;
      }

      if (productType.name) {
        await this.$axios.get('/general-products-by-name/get/' + productType.name)
          .then((res) => {
            this.general_products = res.data.data
          })
          .catch(err => console.log(err))
      } else {
        await this.$axios.get('/general-products/get/')
          .then((res) => {
            this.general_products = res.data.data.data
          })
          .catch(err => console.log(err))
      }
    },
    async changeDefaultProductColor(product) {
      const generalProduct = this.general_products.find(
          (pr) => pr.name === product.name
      );
      if (generalProduct) {
        product.color = await generalProduct.color;
      }
    },
    async fetchBasicTypeProducts() {
      await this.$axios.get('/basic-type-products/get')
        .then((res) => {
          this.basic_type_products = res.data.data
          this.general_type_products = this.general_type_products.concat(this.basic_type_products)
        })
        .catch(err => console.log(err))
    },
    async fetchBasicProducts() {
      await this.$axios.get('/basic-products/get')
        .then((res) => {
          this.basic_products = res.data.data
          this.general_products = this.general_products.concat(this.basic_products)
        })
        .catch(err => console.log(err))
    },
    toggleDropdownPL() {
      this.showDropdownPL = !this.showDropdownPL;
    },
    toggleDropdownTP(index) {
      this.form.typeProducts[index].showDropdown = !this.form.typeProducts[index].showDropdown;
      this.showDropdownPL = !this.showDropdownPL;
      this.showDropdownPL = !this.showDropdownPL;
    },
    toggleDropdownP(indexTP, index) {
      this.form.typeProducts[indexTP].products[index].showDropdown = !this.form.typeProducts[indexTP].products[index].showDropdown;
      this.showDropdownPL = !this.showDropdownPL;
      this.showDropdownPL = !this.showDropdownPL;
    },
  },
  mounted () {
    this.fetchData()
    this.fetchGeneralTypeProducts()
    this.fetchGeneralProduct()
    this.fetchTypeCounts()
    this.fetchBasicTypeProducts()
    this.fetchBasicProducts()
  }
}
</script>

<style scoped>
  .el-form-item {
    margin-bottom: 0;
  }

  .all_prods, .all_types {
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
  }

  .all_types {
    width: 60%;
  }

  .comm {
    margin-bottom: 20px;
  }

  .count_gen {
    display: flex;
    margin-bottom: 20px;
  }

  .form_pl {
    display: flex;
    justify-content: space-between;
    width: 60%;
    position: relative;
  }

  .form_tp {
    display: flex;
    justify-content: space-between;
    width: 100%;
    position: relative;
  }

  .form_pl_clr, .form_tp_clr {
    width: 15%;
  }

  .clr_btn {
    display: flex;
    height: 40px;
    width: 100%;
    border-radius: 4px;
    border: 1px solid #9ca3af;
  }

  .plt_clr {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translate(-50%, 40px);
    z-index: 9;
  }
</style>
