<template>
  <div class="container mx-auto align-middle flex w-100">
    <div class="sm:mx-auto w-2/5 h-full flex flex-col items-center justify-center">
      <div class="bg-white w-full rounded-lg pt-12 pb-7">
        <h1 class="text-center w-full pb-5 text-2xl">Registration</h1>
        <el-form :model="form" status-icon :rules="rules" ref="form" class="flex flex-col justify-center items-center">
          <el-form-item prop="name" class="w-3/5">
            <el-input placeholder="Name" type="text" v-model="form.name" :class="{ 'is-invalid': errors.name }"></el-input>
          </el-form-item>

          <el-form-item prop="phone" class="w-3/5">
            <el-input placeholder="Phone" type="phone" v-model="form.phone" :class="{ 'is-invalid': errors.name }"></el-input>
          </el-form-item>

          <el-form-item prop="password" class="w-3/5">
            <el-input placeholder="Password" type="password" v-model="form.password" :class="{ 'is-invalid': errors.name }"></el-input>
          </el-form-item>

          <el-form-item prop="password_confirmation" class="w-3/5">
            <el-input placeholder="Password Confirmation" type="password" v-model="form.password_confirmation" :class="{ 'is-invalid': errors.name }"></el-input>
          </el-form-item>

          <el-form-item class="mb-0 text-center w-3/5">
            <el-button type="primary" @click="register('form')" class="px-6 w-full">
              Register
            </el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'register',
  auth: 'guest',

  data() {
    return {
      form: {
        name: '',
        phone: '',
        password: '',
        password_confirmation: '',
      },
      error: this.$route.query.error,
      rules: {
        phone: [
          { required: true, message: 'Please input Activity phone', trigger: 'blur' },
        ],
        password: [
          { required: true, message: 'Please input Activity password', trigger: 'blur' },
          { min: 8, max: 20, message: 'Length must be longer than 8 characters', trigger: 'blur' }
        ],
      }
    }
  },
  methods: {
    async register() {
      try {
        await this.$axios.post('/auth/register', this.form);
      } catch(e) {
        return;
      }
      await this.$auth.login({data: this.form});
    }
  }
}
</script>

<style scoped>
.container {
  margin: 5% auto 0 auto;
}
.is-invalid .el-input__inner {
  border-color: red;
}
</style>
