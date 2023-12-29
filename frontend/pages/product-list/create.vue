<template>
  <div class="container mx-auto align-middle flex w-100 pl-create">
    <div class="h-full flex flex-col items-center justify-center w-full">
      <div class="w-full rounded-lg prod-list-form">
        <h1 class="text-center w-full pb-5 text-2xl">Создать список</h1>
        <el-form :model="form" status-icon ref="form" class="flex flex-col justify-center items-center">
          <div class="form_pl">
            <el-form-item prop="name" class="w-full">
              <div class="form_pl_inp">
                <span>Имя списка</span>
                <el-input placeholder="Введите имя " type="name" v-model="form.name"></el-input>
                <span class="is_invalid" v-if="err.name"> {{ err.name[0] }}</span>
              </div>
            </el-form-item>
            <div class="title_color">Цвет списка</div>
            <div class="custom_colors">
              <el-radio-group
                class="label_custom_group"
                v-model="form.color"
                size="large"
              >
                <carousel
                    :per-page="7"
                    :navigationEnabled="true"
                    :paginationEnabled="false"
                >
                  <slide v-for="(color, index) in colors">
                    <span
                      class="custom_colors_span"
                      :style="{color: color.color, borderColor: color.color}"
                      :class="{ 'is-checked': isCheckedIndex === index }"
                      @click="handleColorClick(index)"
                    >
                      <el-radio
                        class="label_custom swiper-slide"
                        :label="color.color"
                      />
                    </span>
                  </slide>
                </carousel>
              </el-radio-group>
            </div>
          </div>
<!--------------------------------------------------------------------------------------------------------------------->
          <div class="categories">
            <div class="categories_in">
              <div v-for="(productType, indx) in form.typeProducts" :key="indx" class="all_prod_types w-100 pt-1 pb-1">
                <div class="form_tp">
                  <div class="from_tp_in w-full">
                    <el-select
                        v-model="productType.name"
                        filterable
                        allow-create
                        default-first-option
                        :reserve-keyword="false"
                        placeholder="Выберите категорию"
                        no-data-text="No data"
                        class="w-full"
                        @change="changeProductType(productType)"
                    >
                      <el-option
                          v-for="general_type_product in general_type_products"
                          :key="general_type_product.name"
                          :label="general_type_product.name"
                          :value="general_type_product.name"
                      />
                    </el-select>
                  </div>
                </div>

                <!--------------------------------------------------------------------------------------------------------------------->
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
<!--                                  :key="general_product.name"-->
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
                <div class="pl_btn_bl gutter">
<!--                  <el-button type="danger" @click="removeInputTypeProduct(indx, productType.id)" class="px-6">-->
<!--                    - tp-->
<!--                  </el-button>-->
                </div>
              </div>
            </div>
            <div class="addMoreCategory" @click="addInputTypeProduct()">
              <span>Добавить категорию</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
                <circle cx="14.5" cy="14.5" r="14.5" fill="white"/>
              </svg>
            </div>
          </div>
<!--------------------------------------------------------------------------------------------------------------------->
          <el-form-item class="mb-0 text-center w-3/5 btn-save">
            <el-button type="success" @click="create('form')" class="px-6 w-full">
              Сохранить
            </el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
  </div>
</template>

<script>
import loginForm from "../../components/auth/LoginForm";

export default {
  name: "create",
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
      isCheckedIndex: null,
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
      try {
        await this.$axios.post('/product-list/generate', this.form, {})

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
      const categoriesIn = document.querySelector('.categories_in');
      categoriesIn.classList.add('clicked')
    },
    async removeInputTypeProduct(index, indexTypeProduct) {
      this.form.typeProducts.splice(index, 1);
    },
    async changeProductType(productType) {
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
    handleClickOutside(event) {
      const target = event.target;
      const dropdown = this.$refs.dropdown;

      if (dropdown && !dropdown.contains(target) && !target.classList.contains('farbtastic-overlay')) {
        this.showDropdownPL = false;
      }
    },
    handleClickTPOutside(event) {
      const targetTP = event.target;
      const dropdownTP = this.$refs.dropdownTP;

      for (let tpIndex = 0; tpIndex < dropdownTP.length; tpIndex++) {
        if (dropdownTP[tpIndex] && !dropdownTP[tpIndex].contains(targetTP) && !targetTP.classList.contains('farbtastic-overlay')) {
          for (let i = 0; i < this.form.typeProducts.length; i++) {
            this.form.typeProducts[i].showDropdown = false;
          }
        }
      }
    },
    handleClickPOutside(event) {
      const targetP = event.target;
      const dropdownP = this.$refs.dropdownP;

      for (let pIndex = 0; pIndex < dropdownP.length; pIndex++) {
        if (dropdownP[pIndex] && !dropdownP[pIndex].contains(targetP) && !targetP.classList.contains('farbtastic-overlay')) {
          for (let i = 0; i < this.form.typeProducts.length; i++) {
            for (let j = 0; j < this.form.typeProducts[i].products.length; j++) {
              this.form.typeProducts[i].products[j].showDropdown = false;
            }
          }
        }
      }
    },
    handleColorClick(index) {
      if (this.isCheckedIndex !== null) {
        // Убираем класс у предыдущего выбранного элемента
        this.$set(
          this.colors[this.isCheckedIndex],
          'isChecked',
          false
        );
      }

      // Добавляем класс текущему выбранному элементу
      this.$set(this.colors[index], 'isChecked', true);
      this.isCheckedIndex = index;
    },
    addOnceNewCategory() {
      const addBtn = document.querySelector('.addMoreCategory');
      const categoriesIn = document.querySelector('.categories_in');
      addBtn.classList.add('addMoreCategoryClicked')
      categoriesIn.classList.add('clicked')
    }
  },
  mounted() {
    this.fetchGeneralTypeProducts()
    // this.fetchGeneralProduct()
    this.fetchTypeCounts()
    this.fetchBasicTypeProducts()
    this.fetchBasicProducts()
    // window.addEventListener('click', this.handleClickOutside);
    // window.addEventListener('click', this.handleClickTPOutside);
    // window.addEventListener('click', this.handleClickPOutside);
  },
  // beforeDestroy() {
  //   window.removeEventListener('click', this.handleClickOutside);
  //   window.removeEventListener('click', this.handleClickTPOutside);
  //   window.removeEventListener('click', this.handleClickPOutside);
  // },
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
  .title_color {
    color: #A5A5A5;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    margin-top: 15px;
    padding: 0 17px;
  }
  .custom_colors {
    padding: 15px 48px;
    margin-bottom: 25px;
  }
  .label_custom_group {
    display: flex;
    width: 100%;
  }
  .label_custom {
    position: relative;
  }
  .custom_colors .custom_colors_span {
    display: flex;
    border: 1px solid;
    border-radius: 50%;
    width: 21px;
    height: 21px;
    margin: 0 auto;
  }
  .custom_colors .custom_colors_span.is-checked {
    border: 2px solid;
  }
  .VueCarousel-navigation-button {
    width: 29px;
    height: 29px;
    border-radius: 50%;
    opacity: 1;
    border: 1px solid #505050!important;
    font-size: 12px;
    margin-top: 20px;
    top: 0!important;
    color: #fff!important;
  }
  .VueCarousel-navigation-prev {
    padding: 0 2px 2px 0!important;
  }
  .VueCarousel-navigation-next {
    padding: 0 0 2px 2px!important;
  }
  .VueCarousel, .VueCarousel-wrapper {
    width: 100%;
  }
  .el-radio-button__inner {
    display: none;
  }
  .label_custom.is-active {
    border: 2px solid #000;
  }
  .VueCarousel-inner {
    margin-top: 10px;
    justify-content: space-between;
  }
  .VueCarousel-slide {
    position: relative;
  }
  .carousel {
    width: 200px;
  }
  .el-form-item {
    margin-bottom: 0;
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
  .categories {
    width: 100%;
    padding: 0 16px;
  }
  .addMoreCategory {
    display: flex;
    justify-content: space-between;
    padding: 15px 21px;
    background-color: #D9D9D959;
    width: 100%;
    border-radius: 5px;
    align-items: center;
  }
  .addMoreCategory span {
    color: #FFF;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
  }

  .addMoreCategory.addMoreCategoryClicked {
    display: none;
  }

  .categories_in {
    display: none;
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
    color: #A5A5A5;;
  }
  .el-range-editor.is-active, .el-range-editor.is-active:hover, .el-select .el-input.is-focus .el-input__inner {
    background-color: #303030;
    border-color: #555;
    color: #A5A5A5;
  }
  .el-select .el-input__inner:focus {
    background-color: #303030;
    border-color: #555;
    color: #A5A5A5;
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
