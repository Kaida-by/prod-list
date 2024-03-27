<template>
  <div class="container mx-auto align-middle flex w-100 pl-create">
    <div class="h-full flex flex-col items-center justify-center w-full">
      <div class="w-full rounded-lg prod-list-form">
        <h1 class="text-center w-full pb-5 text-2xl">Создать список</h1>

        <ProductListForm
            :form="form"
            :err="err"
            :generalTypeProducts="general_type_products"
            :generalProducts="general_products"
            :typeCounts="type_counts"
            :colors="colors"
            :isCheckedIndex="isCheckedIndex"
            @create="create"
            @addInputProduct="addInputProduct"
            @removeInputProduct="removeInputProduct"
            @addInputTypeProduct="addInputTypeProduct"
            @removeInputTypeProduct="removeInputTypeProduct"
            @changeProductType="changeProductType"
            @handleColorClick="handleColorClick"
        />
<!--        <el-form :model="form" status-icon ref="form" class="flex flex-col justify-center items-center">-->
<!--          <div class="form_pl">-->
<!--            <el-form-item prop="name" class="w-full">-->
<!--              <div class="form_pl_inp">-->
<!--                <span>Имя списка</span>-->
<!--                <el-input placeholder="Введите имя " type="name" v-model="form.name"></el-input>-->
<!--                <span class="is_invalid" v-if="err.name"> {{ err.name[0] }}</span>-->
<!--              </div>-->
<!--            </el-form-item>-->
<!--            <div class="title_color">Цвет списка</div>-->
<!--            <ColorSelector-->
<!--              :selectedColor="form.color"-->
<!--              :isCheckedIndex="isCheckedIndex"-->
<!--              :handleColorClick="handleColorClick"-->
<!--              :colors="colors"-->
<!--            />-->
<!--          </div>-->
<!--&lt;!&ndash;-&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&ndash;&gt;-->
<!--          <div class="categories">-->
<!--            <div class="categories_in">-->
<!--              <div v-for="(productType, indx) in form.typeProducts" :key="indx" class="all_prod_types w-100 pt-1 pb-1">-->
<!--                <div class="form_tp">-->
<!--                  <div class="from_tp_in w-full">-->
<!--                    <el-select-->
<!--                        v-model="productType.name"-->
<!--                        filterable-->
<!--                        allow-create-->
<!--                        default-first-option-->
<!--                        :reserve-keyword="false"-->
<!--                        placeholder="Выберите категорию"-->
<!--                        no-data-text="No data"-->
<!--                        class="w-full"-->
<!--                        @change="changeProductType(productType)"-->
<!--                    >-->
<!--                      <el-option-->
<!--                          v-for="general_type_product in general_type_products"-->
<!--                          :key="general_type_product.id"-->
<!--                          :label="general_type_product.name"-->
<!--                          :value="general_type_product.name"-->
<!--                      />-->
<!--                    </el-select>-->
<!--                  </div>-->
<!--                </div>-->

<!--                &lt;!&ndash;-&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&ndash;&gt;-->
<!--                <div class="all_prods">-->
<!--                  <span>Select Your Products: </span>-->
<!--                  <div class="container mx-auto align-middle flex w-full">-->
<!--                    <div class="sm:mx-auto h-full flex flex-col items-center justify-center w-full">-->
<!--                      <div v-for="(product, index) in productType.products" :key="index"-->
<!--                           class="bg-white w-full rounded-lg pt-1 pb-1">-->
<!--                        <div class="form_tp">-->
<!--                          <div class="from_tp_in w-10/12">-->
<!--                            <el-select-->
<!--                                v-model="product.name"-->
<!--                                filterable-->
<!--                                allow-create-->
<!--                                default-first-option-->
<!--                                :reserve-keyword="false"-->
<!--                                placeholder="Name Your Products"-->
<!--                                no-data-text="No data"-->
<!--                                class="w-full"-->
<!--                            >-->
<!--                              <el-option-->
<!--                                  v-for="general_product in general_products"-->
<!--                                  :key="general_product.id"-->
<!--                                  :label="general_product.name"-->
<!--                                  :value="general_product.name"-->
<!--                              />-->
<!--                            </el-select>-->
<!--                          </div>-->
<!--                        </div>-->

<!--                        <p>Count: </p>-->
<!--                        <div class="count_gen">-->
<!--                          <div class="count_c">-->
<!--                            <el-input-number v-model="product.count" :min="1" :max="999999999" />-->
<!--                          </div>-->
<!--                          <div class="type_count">-->
<!--                            <el-select-->
<!--                                v-model="product.type_count_id"-->
<!--                                placeholder="Select"-->
<!--                                class="w-full"-->
<!--                            >-->
<!--                              <el-option-->
<!--                                  v-for="type_count in type_counts"-->
<!--                                  :key="type_count.name"-->
<!--                                  :label="type_count.name"-->
<!--                                  :value="type_count.id"-->
<!--                              />-->
<!--                            </el-select>-->
<!--                          </div>-->
<!--                        </div>-->
<!--                        <div class="comm">-->
<!--                          <template>-->
<!--                            <el-input-->
<!--                                v-model="product.comment"-->
<!--                                :rows="2"-->
<!--                                type="textarea"-->
<!--                                placeholder="Comment"-->
<!--                            />-->
<!--                          </template>-->
<!--                        </div>-->

<!--                        <div class="pl_btn_bl gutter">-->
<!--                          <el-button type="primary" @click="addInputProduct(indx)" class="px-6">-->
<!--                            + p-->
<!--                          </el-button>-->
<!--                          <el-button type="danger" @click="removeInputProduct(indx, product.id, index)" class="px-6">-->
<!--                            - p-->
<!--                          </el-button>-->
<!--                        </div>-->
<!--                      </div>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                </div>-->
                <!--------------------------------------------------------------------------------------------------------------------->
<!--                <div class="pl_btn_bl gutter">-->
<!--                  <el-button type="danger" @click="removeInputTypeProduct(indx, productType.id)" class="px-6">-->
<!--                    - tp-->
<!--                  </el-button>-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->
<!--            <div class="addMoreCategory" @click="addInputTypeProduct()">-->
<!--              <span>Добавить категорию</span>-->
<!--              <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">-->
<!--                <circle cx="14.5" cy="14.5" r="14.5" fill="white"/>-->
<!--              </svg>-->
<!--            </div>-->
<!--          </div>-->
<!--&lt;!&ndash;-&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&ndash;&gt;-->
<!--          <el-form-item class="mb-0 text-center w-3/5 btn-save">-->
<!--            <el-button type="success" @click="create('form')" class="px-6 w-full">-->
<!--              Сохранить-->
<!--            </el-button>-->
<!--          </el-form-item>-->
<!--        </el-form>-->
      </div>
    </div>
  </div>
</template>

<script>
import ProductListForm from "../../components/ProductListForm";

export default {
  name: "create",
  middleware: 'auth',

  components: {
    ProductListForm
  },

  data() {
    return {
      form: {
        name: '',
        color: '',
        user_id: this.$auth.user.id,
        typeProducts: [],
      },
      err: {},
      general_type_products: [],
      basic_type_products: [],
      general_products: [],
      basic_products: [],
      type_counts: [],
      showDropdownPL: false,
      isCheckedIndex: null,
      showNewCategorySelector: false,
      colors: [
        { id: 1, color: '#006eff' },
        { id: 2, color: '#ff5858' },
        { id: 3, color: '#fff46e' },
        { id: 4, color: '#6eff94' },
        { id: 5, color: '#ff99e9' },
        { id: 6, color: '#d899ff' },
        { id: 7, color: '#9f99ff' },
        { id: 8, color: '#99fffa' },
      ],
    }
  },
  methods: {
    async create() {
      console.log(this.form);
      //TODO...skip empty data
      try {
        await this.$axios.post('/product-list/generate', this.form, {})

        this.$router.push({name: 'index'});
      } catch (err) {
        this.err = err.response.data.errors
        return;
      }
    },
    async fetchGeneralTypeProducts() {
      // await this.$axios.get('/general-type-products/get')
      //     .then((res) => {
      //       this.general_type_products = res.data.data.data
      //     })
      //     .catch(err => console.log(err))
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
        color: '',
        comment: '',
        showDropdown: false,
      });
    },
    async removeInputProduct(typeProductIndex, productIndex) {
      if (productIndex === undefined) {
        this.form.typeProducts[typeProductIndex].products.splice(0, 1);
      } else {
        this.form.typeProducts[typeProductIndex].products.splice(productIndex, 1);
      }
    },
    async addInputTypeProduct() {
      this.form.typeProducts.push({
        name: '',
        products: [],
      });
      this.form.typeProducts[this.form.typeProducts.length - 1].showNewCategorySelector = true;

      const categoriesIn = document.querySelector('.categories_in');
      categoriesIn.classList.add('clicked')
    },
    async removeInputTypeProduct(index) {
      this.form.typeProducts.splice(index, 1);
    },
    async changeProductType(productType) {
      const generalTypeProduct = this.general_type_products.find(
          (product) => product.name === productType.name
      );
      if (generalTypeProduct) {
        productType.color = await generalTypeProduct.color;
      }

      // if (productType.name) {
      //   await this.$axios.get('/general-products-by-name/get/' + productType.name)
      //       .then((res) => {
      //         this.general_products = res.data.data
      //       })
      //       .catch(err => console.log(err))
      // } else {
      //   await this.$axios.get('/general-products/get/')
      //       .then((res) => {
      //         this.general_products = res.data.data.data
      //       })
      //       .catch(err => console.log(err))
      // }
    },
    async changeDefaultProductColor(product) {
      const generalProduct = this.general_products.find(
          (pr) => pr.name === product.name
      );
      if (generalProduct) {
        product.color = await generalProduct.color;
      }
    },
    toggleDropdownPL() {
      this.showDropdownPL = !this.showDropdownPL;
    },
    toggleDropdownTP(index) {
      this.form.typeProducts[index].showDropdown = !this.form.typeProducts[index].showDropdown;
    },
    toggleDropdownP(indexTP, index) {
      this.form.typeProducts[indexTP].products[index].showDropdown = !this.form.typeProducts[indexTP].products[index].showDropdown;
    },
    async fetchBasicTypeProducts() {
      await this.$axios.get('/general-type-products/get')
        .then((res) => {
          this.general_type_products = res.data.data.data
        })
        .catch(err => console.log(err))
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
    handleColorClick(index) {
      if (this.isCheckedIndex !== null) {
        this.$set(
          this.colors[this.isCheckedIndex],
          'isChecked',
          false
        );
      }

      this.$set(this.colors[index], 'isChecked', true);
      this.isCheckedIndex = index;
      this.form.color = this.colors[index].color;
    },
    updateSelectedColor(value) {
      this.form.color = value;
    }
  },
  mounted() {
    this.fetchGeneralTypeProducts()
    this.fetchTypeCounts()
    this.fetchBasicTypeProducts()
    this.fetchBasicProducts()
  },
}
</script>

<style>
  .pl-create {
    margin-top: 35px;
  }
  .prod-list-form {
    background-color: #303030;
  }
  h1.text-center {
    font-size: 18px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
    padding: 30px 0 35px 0;
    text-align: center;
  }
  .el-radio__input {
    display: none;
  }
  .el-radio__label {
    font-size: 0;
    width: 21px;
    height: 21px;
    display: flex;
    margin: 0 auto;
  }
  .form_pl_inp {
    padding: 17px 17px 0 17px;
  }
  .form_pl_inp span {
    color: #A5A5A5;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    padding-bottom: 7px;
  }
  .form_pl_inp .el-input input {
    background-color: #303030;
    border: 1px solid #555;
    color: #A5A5A5;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    position: relative;
    padding: 18px 21px;
    height: auto;
  }
  .categories {
    width: 100%;
    padding: 0 16px;
  }

  .categories_in {
    /*display: none;*/
  }

  .categories_in.clicked {
    display: flex;
    flex-direction: column;
  }
  .btn-save {
    padding: 15px;
    width: 100%;
  }
  .all_prod_types {
    border-radius: 5px;
    border: 1px solid #555;
    padding: 15px;
  }
  .el-input__inner {
    background-color: #303030;
    border-color: #555;
    padding: 18px 21px;
    font-size: 15px;
    color: #A5A5A5;
  }
  .el-input.is-disabled .el-input__inner {
    background-color: #303030;
    padding: 18px 21px 18px 0;
    font-size: 15px;
    color: #A5A5A5;
    border: none;
  }
  .el-input.is-disabled .el-input__suffix {
    display: none;
  }
  .el-range-editor.is-active,
  .el-range-editor.is-active:hover,
  .el-select .el-input.is-focus .el-input__inner {
    background-color: #303030;
    border-color: #555;
    color: #A5A5A5;
  }
  .el-select .el-input__inner:focus,
  .el-select .el-input.is-disabled .el-input__inner:hover {
    background-color: #303030;
    border-color: #555;
    color: #A5A5A5;
  }
  .el-select .el-input.is-disabled .el-input__inner:hover,
  .el-input.is-disabled .el-input__icon {
    cursor: default;
  }
  .el-select-dropdown {
    background-color: #303030;
    border-color: #555;
    color: #A5A5A5;
  }
  .el-select-dropdown__item.hover {
    background-color: #303030;
    border-color: #555;
    color: #b0afaf;
  }
</style>
