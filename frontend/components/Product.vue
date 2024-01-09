<template>
  <div class="w-full rounded-lg pt-1 pb-1 single-prod" :class="{ 'added-class': product.showClass }">
    <div class="form_tp">
      <div class="from_tp_in">
        <el-select
            v-model="product.name"
            filterable
            allow-create
            default-first-option
            :reserve-keyword="false"
            placeholder="Выберите продукт"
            no-data-text="Ничего :("
            class="w-full"
            @change="updateProductColor()"
        >
          <el-option
              v-for="general_product in generalProducts"
              :key="general_product.id"
              :label="general_product.name"
              :value="general_product.name"
          />
        </el-select>
        <div class="product-options" @click="openProductOptions">
          <span>.</span>
          <span>.</span>
          <span>.</span>
          <div class="product-options-window" v-show="showProductOptionsWindow"  @click.stop>
            <span @click="removeInputProduct(typeProductKey, productKey)">
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 24 24">
                <path d="M 10 2 L 9 3 L 3 3 L 3 5 L 21 5 L 21 3 L 15 3 L 14 2 L 10 2 z M 4.3652344 7 L 6.0683594 22 L 17.931641 22 L 19.634766 7 L 4.3652344 7 z"></path>
              </svg>
            </span>
            <span @click="updateInputProduct(typeProductKey, productKey)">
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 24 24">
                <path d="M 18.414062 2 C 18.158062 2 17.902031 2.0979687 17.707031 2.2929688 L 15.707031 4.2929688 L 14.292969 5.7070312 L 3 17 L 3 21 L 7 21 L 21.707031 6.2929688 C 22.098031 5.9019687 22.098031 5.2689063 21.707031 4.8789062 L 19.121094 2.2929688 C 18.926094 2.0979687 18.670063 2 18.414062 2 z M 18.414062 4.4140625 L 19.585938 5.5859375 L 18.292969 6.8789062 L 17.121094 5.7070312 L 18.414062 4.4140625 z M 15.707031 7.1210938 L 16.878906 8.2929688 L 6.171875 19 L 5 19 L 5 17.828125 L 15.707031 7.1210938 z"></path>
              </svg>
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="count_gen">
      <div class="count_c">
        <el-input-number v-model="product.count" :min="1" :max="999999"/>
      </div>
      <div class="type_count">
        <el-select
            v-model="product.type_count_id"
            placeholder="Select"
            class="w-full"
        >
          <el-option
              v-for="type_count in typeCounts"
              :key="type_count.name"
              :label="type_count.name"
              :value="type_count.id"
          />
        </el-select>
      </div>
    </div>

    <div class="pl_btn_bl gutter">
      <div class="removeProduct" @click="removeInputProduct(typeProductKey, productKey)">Удалить</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Product",
  props: [
    'product',
    'generalProducts',
    'typeCounts',
    'typeProductKey',
    'productKey'
  ],
  data() {
    return {
      showProductOptionsWindow: false,
    }
  },
  methods: {
    removeInputProduct(TypeProductIndex, productIndex) {
      this.$emit('removeInputProduct', TypeProductIndex, productIndex);
    },
    updateInputProduct(TypeProductIndex, productIndex) {
      if (!this.product.showClass) {
        return;
      }

      this.product.showClass = false;
    },
    updateProductColor() {
      const generalProduct = this.generalProducts.find(product => product.name === this.product.name);
      if (generalProduct) {
        this.product.color = generalProduct.color;
        this.product.type_count_id = 1;
      }
    },
    openProductOptions() {
      this.showProductOptionsWindow = !this.showProductOptionsWindow;
    },
    handleGlobalClick(event) {
      if (this.showProductOptionsWindow && !this.$el.contains(event.target)) {
        this.showProductOptionsWindow = false;
      }
    },
  },
  mounted() {
    document.addEventListener('click', this.handleGlobalClick);
  },
  destroyed() {
    document.removeEventListener('click', this.handleGlobalClick);
  },
}
</script>

<style>
.single-prod {
  background-color: #404040;
  border-radius: 5px;
  padding: 15px;
  margin-bottom: 5px;
}
.single-prod:last-child {
  margin-bottom: 0;
}
.el-input-number {
  margin: 15px 0;
  width: 100%!important;
  position: relative;
}
.el-input-number > .el-input-number__decrease,
.el-input-number > .el-input-number__increase {
  background-color: #404040;
  height: 53px;
  width: 54px;
  border-bottom: 1px solid #505050!important;
  display: flex;
}
.el-input-number > .el-input-number__decrease > i,
.el-input-number > .el-input-number__increase > i {
  margin: auto;
}
.el-input-number__decrease {
  border-right: 1px solid #505050!important;
}
.el-input-number__increase {
  border-left: 1px solid #505050!important;
}
.el-input--suffix .el-input__inner {
  padding-right: 18px;
  color: #A5A5A5;
  font-size: 15px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
  height: auto;
}
.el-input-number .el-input__inner {
  height: auto;
  padding: 6px;
  background-color: #404040;
}
.el-input--suffix .el-input__inner {
  background-color: #404040;
}
.el-input__inner:hover {
  border-color: #505050!important;
}
.el-input-number__decrease:hover:not(.is-disabled)~.el-input .el-input__inner:not(.is-disabled),
.el-input-number__increase:hover:not(.is-disabled)~.el-input .el-input__inner:not(.is-disabled) {
  border-color: #505050!important;
}
.removeProduct {
  display: flex;
  justify-content: center;
  padding: 15px 21px;
  background-color: #555555;
  width: 100%;
  align-items: center;
  border-radius: 5px;
  border: none;
  margin-top: 15px;
  cursor: pointer;
}
.removeProduct span {
  color: #FFF;
  font-size: 15px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
}
.removeProduct.disabled {
  opacity: 0.5;
  pointer-events: none;
}
.count_gen,
.pl_btn_bl.gutter {
  display: block;
}
.single-prod.added-class .count_gen,
.single-prod.added-class .pl_btn_bl.gutter {
  display: none;
}
.single-prod.added-class .form_tp .el-input__inner {
  border: none;
  padding: 0;
}
.product-options {
  display: flex;
  flex-direction: column;
  position: relative;
  width: 33px;
  height: 42px;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  margin-top: -19px;
}

.product-options span {
  height: 7px;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 30px;
  color: #555555;
}
.product-options-window {
  display: flex;
  position: absolute;
  top: 9px;
  right: 0;
  width: max-content;
  height: auto;
  background-color: #404040;
  column-gap: 10px;
  padding: 10px;
  z-index: 1;
}
.product-options-window span {
  font-size: 16px;
  width: 24px;
  height: 24px;
  color: #fff;
}
.product-options-window span svg path {
  fill: #A5A5A5;
}
.single-prod.added-class .from_tp_in .el-select.w-full {
  display: flex;
  align-items: center;
}
.product-options {
  display: none;
}
.single-prod.added-class .form_tp .el-input__suffix {
  display: none;
}
.single-prod.added-class .product-options {
  display: flex;
}
.single-prod.added-class .from_tp_in {
  display: flex;
}
</style>