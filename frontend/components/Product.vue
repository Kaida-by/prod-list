<template>
  <div class="w-full rounded-lg pt-1 pb-1 single-prod">
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
      <!-- ... Остальной код для кнопок или других элементов продукта ... -->
    </div>
  </div>
</template>

<script>
export default {
  name: "Product",
  props: [
    'product',
    'generalProducts',
    'typeCounts'
  ],
  methods: {
    removeInputProduct(indx, productId, index) {
      this.$emit('removeInputProduct', indx, productId, index);
    },
    updateProductColor() {
      const generalProduct = this.generalProducts.find(product => product.name === this.product.name);
      if (generalProduct) {
        this.product.color = generalProduct.color;
        this.product.type_count_id = 1;
      }
    }
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

</style>