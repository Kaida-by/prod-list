<template>
  <div class="container">
    <div class="prod_list_container" :style="{background: form.color}">
      <div class="prod_list_general">
        <h1 class="">{{ form.name }}</h1>
        <el-form :model="form" status-icon ref="form" class="prod_list_form">
          <!--------------------------------------------------------------------------------------------------------------------->
          <div
              v-for="(productType, indx) in form.typeProducts"
              :key="indx"
              class="general_type"
              :style="{background: productType.color}">
            <div class="type_prod_block">
              <div class="prod_list_header">{{ productType.name }}</div>
              <div class="prod_list_btn gutter">
                <el-button @click="removeInputTypeProduct(indx, productType.id)">
                  <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 122.88 94.27" style="enable-background:new 0 0 122.88 94.27" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M12.04,27.72h9.43L44.56,1.86c2.05-2.3,5.61-2.5,7.9-0.45v0c2.3,2.05,2.5,5.61,0.45,7.91l-16.42,18.4h50.32 L70.39,9.32c-2.05-2.3-1.85-5.86,0.45-7.91h0c2.3-2.05,5.85-1.85,7.91,0.45l23.08,25.86l9.02,0l0.12,0l8.47,0 c1.9,0,3.45,1.55,3.45,3.45v9.73c0,1.9-1.55,3.45-3.45,3.45h-7.33l-3.77,47.53c-0.1,1.31-1.08,2.39-2.39,2.39H16.94 c-1.31,0-2.29-1.08-2.39-2.39l-3.77-47.53H3.45C1.55,44.35,0,42.8,0,40.9v-9.73c0-1.9,1.55-3.45,3.45-3.45l8.47,0L12.04,27.72 L12.04,27.72z M77.67,46.22h10.91v31.53l-10.91,0V46.22L77.67,46.22z M56.45,46.22h10.9v31.53l-10.9,0V46.22L56.45,46.22z M35.23,46.22h10.91v31.53l-10.91,0V46.22L35.23,46.22z"/></g></svg>
                </el-button>
              </div>
            </div>
            <!--------------------------------------------------------------------------------------------------------------------->
            <div class="all_prods">
              <div
                  v-for="(product, index) in productType.products"
                  :key="index"
                  class="prod"
                  :style="{background: product.color}">
                <div class="prod_f">
                  <div class="prod_name">Name: {{ product.name }}</div>
                  <div class="prod_count">
                    <span>Count: {{ product.count }}</span> - <span>{{ getProductTypeName(product.type_count_id) }}</span>
                  </div>
                  <div class="prod_comment" v-if="product.comment">
                    Comment: {{ product.comment }}
                  </div>
                </div>
                <div class="prod_s prod_list_btn">
                  <el-button @click="removeInputProduct(indx, product.id, index)">
                    <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 122.88 94.27" style="enable-background:new 0 0 122.88 94.27" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M12.04,27.72h9.43L44.56,1.86c2.05-2.3,5.61-2.5,7.9-0.45v0c2.3,2.05,2.5,5.61,0.45,7.91l-16.42,18.4h50.32 L70.39,9.32c-2.05-2.3-1.85-5.86,0.45-7.91h0c2.3-2.05,5.85-1.85,7.91,0.45l23.08,25.86l9.02,0l0.12,0l8.47,0 c1.9,0,3.45,1.55,3.45,3.45v9.73c0,1.9-1.55,3.45-3.45,3.45h-7.33l-3.77,47.53c-0.1,1.31-1.08,2.39-2.39,2.39H16.94 c-1.31,0-2.29-1.08-2.39-2.39l-3.77-47.53H3.45C1.55,44.35,0,42.8,0,40.9v-9.73c0-1.9,1.55-3.45,3.45-3.45l8.47,0L12.04,27.72 L12.04,27.72z M77.67,46.22h10.91v31.53l-10.91,0V46.22L77.67,46.22z M56.45,46.22h10.9v31.53l-10.9,0V46.22L56.45,46.22z M35.23,46.22h10.91v31.53l-10.91,0V46.22L35.23,46.22z"/></g></svg>
                  </el-button>
                </div>
              </div>
            </div>
            <!--------------------------------------------------------------------------------------------------------------------->
          </div>
          <!--------------------------------------------------------------------------------------------------------------------->
          <el-form-item>
            <el-button type="danger" @click="deleteProdList('form')">
              Delete!
            </el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
  </div>
</template>

<script>
import _id from "../../general-product/_id";
export default {
  components: {_id},
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
          products: [
            {
              name: '',
              count: '',
              color: '',
              type_count_id: '',
              comment: '',
            }
          ],
        }],
      },
      err: {},
      general_type_products: [],
      general_products: [],
      type_counts: [],
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
    async removeInputProduct(typeProductIndex, productId, productIndex) {
      await this.deleteProductFromProdList(productId);
      this.form.typeProducts[typeProductIndex].products.splice(productIndex, 1);
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
    deleteProdList() {
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
    deleteTypeProductFromProdList(index) {
      if (confirm("Do you really want to delete this Product Type?")) {
        try {
          this.$axios.delete('/product-list/delete-type-product/' + index).then(response => {
          });
        } catch (e) {
          return;
        }
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
  computed: {
    getProductTypeName() {
      return (type_count_id) => {
        const selectedTypeCount = this.type_counts.find(
            type_count => type_count.id === type_count_id
        );
        return selectedTypeCount ? selectedTypeCount.name : '';
      };
    }
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
  .prod_list_container {
    margin: 0 auto;
    max-width: 840px;
    width: 100%;
    padding: 24px;
    border-radius: 5px;
  }

  .prod_list_container h1 {
    text-align: center;
    width: 100%;
    font-size: 24px;
    font-weight: 600;
  }

  .prod_list_form {
    display: grid;
    row-gap: 10px;
  }

  .general_type div {
    width: 100%;
  }

  .type_prod_block {
    display: flex;
  }

  .type_prod_block .el-button {
    border-radius: 50%;
    padding: 5px;
    row-gap: 10px;
  }

  .general_type {
    padding: 10px;
    border-radius: 5px;
  }

  .all_prods {
    display: flex;
    flex-direction: column;
    padding-left: 24px;
    row-gap: 10px;
    margin-top: 10px;
  }

  .prod {
    display: flex;
    padding: 10px;
    border-radius: 5px;
  }

  .prod .el-button {
    border-radius: 50%;
    padding: 5px;
  }

  .prod .prod_s {
    display: flex;
    align-items: center;
  }

  .prod_list_container .prod_list_btn {
    width: fit-content;
  }

  .prod_s.prod_list_btn {
    align-items: flex-start;
  }

  .prod_comment {
    padding: 10px;
    background-color: #fff;
    margin-top: 10px;
    width: 90%;
    border-radius: 5px;
  }

  .el-button {
    background: #ef4444;
    border: 1px solid #ef4444;
  }

  .el-button svg {
    width: 17px;
    height: 17px;
    fill: #fff;
  }
</style>
