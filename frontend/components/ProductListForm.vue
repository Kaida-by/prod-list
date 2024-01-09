<template>
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
      <ColorSelector
          :selectedColor="form.color"
          :isCheckedIndex="isCheckedIndex"
          :colors="colors"
          @handleColorClick="handleColorClick"
          @update:selectedColor="updateSelectedColor"
      />
    </div>

    <div class="categories">
      <div class="categories_in">
        <CategorySelector
            v-if="productType.showNewCategorySelector"
            v-for="(productType, indx) in form.typeProducts"
            :indx="indx"
            :productType="productType"
            :generalTypeProducts="generalTypeProducts"
            :generalProducts="generalProducts"
            :typeCounts="typeCounts"
            @changeProductType="changeProductType"
            @addInputProduct="addInputProduct"
            @removeInputProduct="removeInputProduct"
            @addInputTypeProduct="addInputTypeProduct"
            @removeInputTypeProduct="removeInputTypeProduct"
        />
      </div>
      <div class="addMoreCategory" @click="addInputTypeProduct">
        <span>Добавить категорию</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
          <circle cx="14.5" cy="14.5" r="14.5" fill="white"/>
        </svg>
      </div>
    </div>

    <el-form-item class="mb-0 text-center w-3/5 btn-save">
      <el-button type="success" @click="create('form')" class="px-6 w-full">
        Сохранить
      </el-button>
    </el-form-item>
  </el-form>
</template>

<script>
import CategorySelector from "./CategorySelector";
import ColorSelector from '~/components/ColorSelector.vue';

export default {
  name: "ProductListForm",
  components: {
    CategorySelector,
    ColorSelector,
  },
  props: [
    'form',
    'err',
    'indx',
    'generalTypeProducts',
    'generalProducts',
    'typeCounts',
    'colors',
    'isCheckedIndex',
    'typeProducts'
  ],
  methods: {
    changeProductType(productType) {
      this.$emit('changeProductType', productType);
    },
    addInputProduct(typeProductIndex) {
      this.$emit('addInputProduct', typeProductIndex);
    },
    removeInputProduct(typeProductIndex, productIndex) {
      this.$emit('removeInputProduct', typeProductIndex, productIndex);
    },
    addInputTypeProduct() {
      this.$emit('addInputTypeProduct');
    },
    removeInputTypeProduct(index) {
      this.$emit('removeInputTypeProduct', index)
    },
    create() {
      this.$emit('create')
    },
    handleColorClick(index) {
      this.$emit('handleColorClick', index)
    },
    updateSelectedColor(value) {
      this.$emit('updateSelectedColor', value)
    }
  }
}
</script>

<style>
.title_color {
  color: #A5A5A5;
  font-size: 15px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
  margin-top: 15px;
  padding: 0 17px;
}
.addMoreCategory {
  display: flex;
  justify-content: space-between;
  padding: 15px 21px;
  background-color: #D9D9D959;
  width: 100%;
  border-radius: 5px;
  align-items: center;
  cursor: pointer;
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
</style>
