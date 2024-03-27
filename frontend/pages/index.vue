<template>
  <div class="container">
    <div class="form-authorization">
      <div class="form-auth-tabs">
        <div v-bind:class="isActiveAuth ? 'active' : ''" @click="authorizationForm">Авторизация</div>
        <div v-bind:class="isActiveRegistration ? 'active' : ''" @click="registrationForm">Регистрация</div>
      </div>
      <div class="form-auth-tabs-container">
        <div v-if="isLogin">
          <login-form></login-form>
        </div>
        <div v-else>
          <registration-form></registration-form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import RegistrationForm from "../components/auth/RegistrationForm";
import LoginForm from "../components/auth/LoginForm";

export default {
  name: 'index',
  auth: 'guest',
  components: {
    RegistrationForm,
    LoginForm
  },

  data() {
    return {
      isLogin: true,
      isActiveAuth: true,
      isActiveRegistration: false,
    }
  },
  methods: {
    authorizationForm() {
      this.isLogin = true;
      this.isActiveAuth = true;
      this.isActiveRegistration = false;
    },
    registrationForm() {
      this.isLogin = false;
      this.isActiveAuth = false;
      this.isActiveRegistration = true;
    }
  }
}

</script>

<style>
  .form-auth-tabs {
    display: flex;
    justify-content: space-between;
  }

  .form-auth-tabs div {
    width: 50%;
    background-color: #191B1A;
    color: #A5A5A5;
    font-size: 18px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    padding: 12px 0 20px 0;
    text-align: center;
    cursor: pointer;
  }

  .form-auth-tabs div.active {
    color: #fff;
    background-color: #303030;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
  }

  .el-form-item  input,
  .el-form-item  input:-webkit-autofill,
  .el-form-item  input:-webkit-autofill:hover,
  .el-form-item  input:-webkit-autofill:focus {
    background-color: #303030;
    color: #fff;
    border-color: #555;
  }
  .form-authorization {
    margin-top: 35px;
  }
</style>
