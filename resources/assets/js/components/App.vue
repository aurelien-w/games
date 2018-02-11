<template>
    <div id="app" class="wrapper">
        <section class="hero is-primary is-bold">
            <!-- TITLE -->
            <div class="hero-body">
                <div class="container">
                    <h1 class="title is-size-1-desktop">{{ name }}</h1>
                    <h2 class="subtitle is-size-3-desktop">{{ title }}</h2>
                    <p class="has-text-centered" v-show="$route.name !== 'games.create'">
                        <button class="button is-primary is-rounded is-inverted is-size-5-desktop" @click="gameCreateModal = true">
                            <span class="icon">
                                <i class="fas fa-futbol"></i>
                            </span>
                            <span class="has-text-grey-dark">Ajouter un match</span>
                        </button>
                    </p>
                </div>
            </div>
            <div class="hero-foot">
                <div class="container">
                    <div class="level">
                        <!-- NAV -->
                        <div class="level-left">
                            <nav class="tabs is-size-5-desktop is-centered">
                                <ul>
                                    <li :class="{ 'is-active': $route.name === 'players.index' }">
                                        <router-link :to="{ name: 'players.index' }">
                                            <span class="icon">
                                                <i class="fal fa-trophy-alt"></i>
                                            </span>
                                            <span>Classement</span>
                                        </router-link>
                                    </li>
                                    <li  :class="{ 'is-active': $route.name === 'games.index' }">
                                        <router-link :to="{ name: 'games.index' }">
                                            <span class="icon">
                                                <i class="fal fa-gamepad"></i>
                                            </span>
                                            <span>Matchs</span>
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
        <!-- MODAL -->
        <modal v-show="gameCreateModal" @close="gameCreateModal = false" :dismissable="false">
            <games-create @close="gameCreateModal = false"></games-create>
        </modal>
        <!-- FLASH -->
        <flash channel="flash"></flash>
    </div>
</template>

<script>
    import GamesCreate from '../views/games/Create'

    export default {
        name: 'App',
        components: { GamesCreate },
        data () {
            return {
                name: 'FIFA',
                gameCreateModal: false
            }
        },
        computed: {
            title () {
                if (this.$route.meta.hasOwnProperty('title')) {
                    return this.$route.meta.title
                }

                return 'Classement général'
            }
        }
    }
</script>