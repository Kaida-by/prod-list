<template>
  <div class="container mx-auto align-middle flex w-100">
    <div class="sm:mx-auto h-full flex flex-col items-center justify-center form_in">
      <div class="w-full rounded-lg">
        <el-form :model="form" status-icon ref="form" class="flex flex-col justify-center items-center">
          <el-form-item prop="name">
            <label for="name">Введите ваше имя</label>
            <el-input placeholder="Имя" type="text" v-model="form.name"></el-input>
            <span class="is_invalid" v-if="err.name"> {{ err.name[0] }}</span>
          </el-form-item>

          <el-form-item prop="phone">
            <label for="phone">Введите ваш телефон</label>
            <el-input placeholder="Телефон" type="phone" v-model="form.phone"></el-input>
            <span class="is_invalid" v-if="err.phone"> {{ err.phone[0] }}</span>
          </el-form-item>

          <el-form-item prop="password">
            <label for="password">Установите ваш пароль</label>
            <el-input placeholder="Пароль" type="password" v-model="form.password"></el-input>
            <span class="is_invalid" v-if="err.password"> {{ err.password[0] }}</span>
          </el-form-item>

          <el-form-item class="mb-0 text-center btn_bot">
            <el-button @click="register('form')" class="px-6 w-full">
              Зарегистрироваться
            </el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "RegistrationForm",

  data() {
    return {
      form: {
        name: '',
        phone: '',
        password: '',
      },
      err: {},
    }
  },
  methods: {
    async register() {
      try {
        await this.$axios.post('/auth/register', this.form)
      } catch (err) {
        this.err = err.response.data.errors
        return;
      }

      await this.$auth.login({data: this.form});
    }
  }
}
</script>

<style scoped>
  .container {
    margin: 0 auto;
    background-color: #303030;
  }
  .is_invalid {
    color: red;
  }

  .el-form-item {
    width: 100%;
    margin-bottom: 0;
  }

  .form_in {
    padding: 25px 16px;
  }

  .btn_bot {
    margin-top: 22px;
  }

  .el-form-item label {
    color: #A5A5A5;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
  }

  .btn_bot button {
    background-color: #00A023;
    border: none;
    color: #fff;
    font-size: 15px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
  }
</style>
