<template>

    <section id="app">
        <router-view></router-view>
    </section>

</template>

<script>
export default {
      name: 'app',
          data () {
            return {
                msg: 'Welcome to Your Vue.js App'
            }
      }
}
</script>

<style lang="scss">

* {
    box-sizing: border-box;
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

#app {
    padding: 0px;
    margin: 0px;
}

html, body {
    width: 100%;
    height: 100%;
    padding: 0px;
    margin: 0px;
}

#header {
    overflow: hidden;
    height: 50px;
    max-height: 50px;
    width: 100%;
    background: black;
    .navigation {
        padding: 0px;
        margin: 0px;
        color: white;
        list-style-type: none;
        display: flex;
        align-items: center;
        height: inherit;
        > * {
            padding: 0px 20px 0px 20px;
        }
    }
}
</style>