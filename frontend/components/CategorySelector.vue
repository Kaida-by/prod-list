<template>
  <div class="all_prod_types w-100 pt-1 pb-1">
    <div class="form_tp">
      <div class="from_tp_in w-full" :class="{'selected-category': isCategorySelected(productType)}">
        <el-select
          v-model="productType.name"
          filterable
          allow-create
          default-first-option
          :reserve-keyword="false"
          placeholder="Выберите категорию"
          no-data-text="Ничего :("
          class="w-full"
          :disabled="isCategorySelected(productType)"
          @change="changeProductType(productType)"
        >
          <el-option
            v-for="general_type_product in generalTypeProducts"
            :key="general_type_product.id"
            :label="general_type_product.name"
            :value="general_type_product.name"
          />
        </el-select>
        <div v-if="isCategorySelected(productType)" class="category-options" @click="openCategoryOptions">
          <span>.</span>
          <span>.</span>
          <span>.</span>
          <div class="options-window" v-show="showOptionsWindow"  @click.stop>
            <span @click="removeInputTypeProduct(indx, productType.id)">
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 24 24">
                <path d="M 10 2 L 9 3 L 3 3 L 3 5 L 21 5 L 21 3 L 15 3 L 14 2 L 10 2 z M 4.3652344 7 L 6.0683594 22 L 17.931641 22 L 19.634766 7 L 4.3652344 7 z"></path>
              </svg>
            </span>
          </div>
        </div>
      </div>
      <div v-if="isCategorySelected(productType)">
        <div :class="{'product_cl': showProductClass}">
          <div class="all_prods">
            <Product
              v-for="(product, index) in productType.products"
              :typeProductKey="indx"
              :productKey="index"
              :product="product"
              :generalProducts="generalProducts"
              :typeCounts="typeCounts"
              @addInputProduct="addInputProduct"
              @removeInputProduct="removeInputProduct"
            />
          </div>
        </div>
        <div class="addMoreProduct" :class="{ 'disabled': isAddProductButtonDisabled }" @click="addInputProduct(indx)">
          <span>Добавить продукт</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
            <circle cx="14.5" cy="14.5" r="14.5" fill="white"/>
          </svg>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Product from "./Product";

export default {
  name: "CategorySelector",
  data() {
    return {
      showProductClass: false,
      showOptionsWindow: false,
    }
  },
  components: {
    Product
  },
  props: [
    'productType',
    'generalProducts',
    'generalTypeProducts',
    'typeCounts',
    'indx',
    'typeProductKey',
    'productKey'
  ],
  methods: {
    addInputProduct(typeProductIndex) {
      if (this.productType.products.length > 0 && this.productType.products[0].name === '') {
        return;
      }
      this.productType.products.forEach((product, index) => {
        if (index !== this.productType.products.length - 2) {
          this.$set(this.productType.products, index, { ...product, showClass: true });
        }
      });
      this.$emit('addInputProduct', typeProductIndex);
      this.showProductClass = true;
    },
    removeInputProduct(typeProductIndex, productIndex) {
      this.$emit('removeInputProduct', typeProductIndex, productIndex);
    },
    changeProductType(productType) {
      this.$emit('changeProductType', productType)
    },
    removeInputTypeProduct(index) {
      this.$emit('removeInputTypeProduct', index);
      this.showOptionsWindow = false;
    },
    openCategoryOptions() {
      this.showOptionsWindow = !this.showOptionsWindow;
    },
    handleGlobalClick(event) {
      if (this.showOptionsWindow && !this.$el.contains(event.target)) {
        this.showOptionsWindow = false;
      }
    },
  },
  mounted() {
    document.addEventListener('click', this.handleGlobalClick);
  },
  destroyed() {
    document.removeEventListener('click', this.handleGlobalClick);
  },
  computed: {
    isCategorySelected() {
      return (productType) => {
        return productType.name !== '';
      };
    },
    isAddProductButtonDisabled() {
      return this.productType.products.some(product => product.name === '');
    },
  },
}
</script>

<style scoped>
.all_prod_types {
  margin-bottom: 15px;
}
.addMoreProduct {
  display: flex;
  justify-content: space-between;
  padding: 15px 21px;
  background-color: transparent;
  width: 100%;
  align-items: center;
  border-radius: 5px;
  border: 1px solid #00D359;
  margin-top: 15px;
  cursor: pointer;
}
.addMoreProduct span {
  color: #FFF;
  font-size: 15px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
}
.addMoreProduct.disabled {
  opacity: 0.5;
  pointer-events: none;
}
.selected-category {
  display: flex;
}
.category-options {
  display: flex;
  flex-direction: column;
  position: relative;
  width: 33px;
  height: 42px;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.category-options span {
  height: 7px;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 30px;
  color: #555555;
}
.options-window {
  position: absolute;
  top: 9px;
  right: 6px;
  width: max-content;
  height: inherit;
  background-color: #303030;
  display: flex;
  align-items: center;
}
.options-window span {
  font-size: 16px;
  width: 24px;
  height: 24px;
  color: #fff;
}
.options-window span svg path {
  fill: #A5A5A5;
}
/*.product_cl {*/
/*  background-color: #404040;*/
/*  border-radius: 5px;*/
/*  padding: 15px;*/
/*}*/
</style>
