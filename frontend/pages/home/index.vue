<template>
  <div class="container mx-auto align-middle flex w-100">
    <div class="header-sdk" v-if="$auth.loggedIn">
      <div class="py-2">
        Hello, {{ $auth.user.name }}
      </div>
      <el-button type="info" plain @click.prevent="logOut">logout</el-button>
    </div>
  </div>
</template>

<script>
export default {
  name: "home",
  middleware: 'auth',
  methods: {
    logOut() {
      this.$auth.logout();
    }
  }
}
</script>

<style scoped>

</style>
