<template>
  <div class="container">
    <button @click="toggleForm">{{ textRegistration ? 'Sign Up' : 'Sign In' }}</button>
    <div v-if="isLogin">
      <login-form></login-form>
    </div>
    <div v-else>
      <registration-form></registration-form>
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
      textRegistration: true,
    }
  },
  methods: {
    toggleForm() {
      this.isLogin = !this.isLogin;
      this.textRegistration = !this.textRegistration;
    }
  }
}

</script>
