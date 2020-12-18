<template>
  <div id="app">
    <img alt="Vue logo" src="/images/bemo-logo.png" />
    <Page msg="BeMo KanBan" />
  </div>
</template>

<script>
import Page from "./components/Page.vue";

export default {
  name: "App",
  components: {
    Page
  }
};
</script>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
.loading {
    padding: 1rem;
}
.flex--center {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
