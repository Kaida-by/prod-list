<template>
  <div class="container mx-auto align-middle flex w-100">
    <div class="sm:mx-auto w-2/5 h-full flex flex-col items-center justify-center">
      <div class="bg-white w-full rounded-lg pt-12 pb-7">
        <h1 class="text-center w-full pb-5 text-2xl">Sign In</h1>
        <el-form :model="form" status-icon ref="form" class="flex flex-col justify-center items-center">
          <el-form-item prop="phone" class="w-3/5">
            <el-input placeholder="Phone" type="phone" v-model="form.phone"></el-input>
            <span class="is_invalid" v-if="err.phone"> {{ err.phone[0] }}</span>
          </el-form-item>
          <el-form-item prop="password" class="w-3/5">
            <el-input placeholder="Password" type="password" v-model="form.password"></el-input>
            <span class="is_invalid" v-if="err.password"> {{ err.password[0] }}</span>
          </el-form-item>
          <el-form-item class="mb-0 text-center w-3/5">
            <el-button type="primary" @click="login('form')" class="px-6 w-full">
              Login
            </el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "LoginForm",

  data() {
    return {
      form: {
        phone: '',
        password: '',
      },
      err: {},
    }
  },
  methods: {
    async login() {
      try {
        await this.$auth.login({data: this.form});
      } catch (err) {
        this.err = err.response.data.errors
        return;
      }
    }
  }
}
</script>

<style scoped>
  .container {
    margin: 5% auto 0 auto;
  }
  .is_invalid {
    color: red;
  }
</style>