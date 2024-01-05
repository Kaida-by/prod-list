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
    addInputProduct(indx) {
      this.$emit('addInputProduct', indx);
    },
    removeInputProduct(indx, productId, index) {
      this.$emit('removeInputProduct', indx, productId, index);
    },
  },
}
</script>

<style scoped>
.single-prod {
  background-color: #404040;
  border-radius: 5px;
  padding: 15px;
  margin-bottom: 5px;
}
.single-prod:last-child {
  margin-bottom: 0;
}
</style>