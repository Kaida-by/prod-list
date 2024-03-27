<template>
  <div class="custom_colors">
    <el-radio-group
        class="label_custom_group"
        :value="selectedColor"
        size="large"
        @input="updateSelectedColor"
    >
      <carousel
          :per-page="7"
          :navigationEnabled="true"
          :paginationEnabled="false"
          :scroll-per-page="false"
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
</template>

<script>
export default {
  name: "ColorSelector",
  props: ['selectedColor', 'isCheckedIndex', 'colors'],
  methods: {
    handleColorClick(index) {
      this.$emit('handleColorClick', index)
    },
    updateSelectedColor(value) {
      this.$emit('update:selectedColor', value)
    }
  }
}
</script>

<style>
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
</style>
