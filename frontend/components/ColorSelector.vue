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

<style scoped>

</style>