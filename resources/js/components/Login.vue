<template>
    <div>
        <button @click="login">Entrar</button>
    </div>
</template>
<script>
export default {
  name: 'login-shortcut',
  methods: {
    login () {
      this.$getGapiClient()
        .then(gapi => {
            console.log(gapi);
        })
    }
  }

}

</script>