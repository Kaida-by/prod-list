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
      </div>
      <div v-if="isCategorySelected(productType)">
        <div :class="{'product_cl': showProductClass}">
          <div class="all_prods">
            <Product
              v-for="(product, index) in productType.products"
              :key="index"
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
  ],
  methods: {
    addInputProduct(typeProductIndex) {
      if (this.productType.products.length > 0 && this.productType.products[0].name === '') {
        return;
      }
      this.$emit('addInputProduct', typeProductIndex);
      this.showProductClass = true;
    },
    removeInputProduct(typeProductIndex, productId, productIndex) {
      this.$emit('removeInputProduct', typeProductIndex, productId, productIndex);
    },
    changeProductType(productType) {
      this.$emit('changeProductType', productType)
    }
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
/*.product_cl {*/
/*  background-color: #404040;*/
/*  border-radius: 5px;*/
/*  padding: 15px;*/
/*}*/
</style>