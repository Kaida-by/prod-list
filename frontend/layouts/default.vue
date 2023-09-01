<template>
  <div>
    <top-nav></top-nav>
    <Nuxt/>
  </div>
</template>

<script>

import TopNav from "./partials/TopNav";

export default {
  name: "default",
  components: {
    TopNav
  }
}
</script>

<style scoped>

</style>