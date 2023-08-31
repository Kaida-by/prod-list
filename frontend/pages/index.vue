<template>
  <div class="container">
    <nuxt-link to="/auth/login">Sigh In</nuxt-link>
    <nuxt-link to="/auth/register">Sign Up</nuxt-link>
  </div>
</template>

<script>

export default {
  name: 'index',
  auth: 'guest',
}

</script>
