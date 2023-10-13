<template>
  <div class="container">
    <div class="">
      <div class="">
        <h1 class="">{{ form.name }}</h1>
        <el-form :model="form" status-icon ref="form">
          <!--------------------------------------------------------------------------------------------------------------------->
          <div v-for="(productType, indx) in form.typeProducts" :key="indx">
            <div>{{ productType.name }}</div>
            <!--------------------------------------------------------------------------------------------------------------------->
            <div class="all_prods">
              <div v-for="(product, index) in productType.products" :key="index">
                <div class="prod_name">{{ product.name }}</div>
                <div class="prod_count">
                  <span>{{ product.count }}</span> - <span>{{ getProductTypeName(product.type_count_id) }}</span>
                </div>
                <div class="prod_comment">
                  {{ product.comment }}
                </div>
                <el-button type="danger" @click="removeInputProduct(indx, product.id, index)">
                  - p
                </el-button>
              </div>
            </div>
            <!--------------------------------------------------------------------------------------------------------------------->
            <div class="pl_btn_bl gutter">
              <el-button type="danger" @click="removeInputTypeProduct(indx, productType.id)">
                - tp
              </el-button>
            </div>
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

</style>