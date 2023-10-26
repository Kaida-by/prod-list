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
                <el-button type="danger" @click="removeInputTypeProduct(indx, productType.id)">X</el-button>
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
                  <el-button type="danger" @click="removeInputProduct(indx, product.id, index)">X</el-button>
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
</style>