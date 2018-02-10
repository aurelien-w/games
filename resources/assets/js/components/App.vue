<template>
    <div id="app" class="wrapper">
        <section class="hero is-primary is-bold">
            <!-- TITLE -->
            <div class="hero-body">
                <div class="container">
                    <h1 class="title is-1">
                        FIFA
                    </h1>
                    <h2 class="subtitle is-3">
                        Classement général
                    </h2>
                </div>
            </div>
            <div class="hero-foot">
                <div class="container">
                    <div class="level">
                        <!-- NAV -->
                        <div class="level-left">
                            <nav class="tabs is-medium">
                                <ul>
                                    <li :class="{ 'is-active': $route.name === 'players.index' }">
                                        <router-link to="/">
                                            <span class="icon">
                                                <i class="fal fa-trophy-alt"></i>
                                            </span>
                                            <span>Classement</span>
                                        </router-link>
                                    </li>
                                    <li  :class="{ 'is-active': $route.name === 'games.index' }">
                                        <router-link to="/games">
                                            <span class="icon">
                                                <i class="fal fa-gamepad"></i>
                                            </span>
                                            <span>Matchs</span>
                                        </router-link>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- NEW MATCH -->
                        <div class="level-right is-hidden-mobile">
                            <nav class="tabs is-medium">
                                <ul>
                                    <li :class="{ 'is-active': $route.name === 'games.create' }">
                                        <router-link to="games/create">
                                            <span class="icon">
                                                <i class="far fa-plus"></i>
                                            </span>
                                            <span>Ajouter un match</span>
                                        </router-link>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <transition>
            <keep-alive>
                <router-view></router-view>
            </keep-alive>
        </transition>
    </div>
</template>

<script>
    export default {
        name: 'App'
    }
</script>