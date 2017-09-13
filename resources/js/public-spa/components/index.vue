<template>

    <div>
        <header id="header">
            <ul class="navigation">
                <router-link to="/" tag="li">Dashboard</router-link>
                <router-link :to="{ name: 'user.list' }" tag="li">Users</router-link>
                <router-link :to="{ name: 'user.create' }" tag="li">Add user</router-link>
            </ul>
        </header>
        <router-view></router-view>
    </div>

</template>

<script>
    export default {
        data() {
            return {}
        }
    }
</script>

<style lang="scss">

</style>
