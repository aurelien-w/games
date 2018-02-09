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
                                    <li class="is-active">
                                        <a href="#">
                                        <span class="icon">
                                            <i class="fal fa-trophy-alt"></i>
                                        </span>
                                            <span>Classement</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                        <span class="icon">
                                            <i class="fal fa-gamepad"></i>
                                        </span>
                                            <span>Matchs</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- NEW MATCH -->
                        <div class="level-right is-hidden-mobile">
                            <nav class="tabs is-medium">
                                <ul>
                                    <li>
                                        <a href="#">
                                        <span class="icon">
                                            <i class="far fa-plus"></i>
                                        </span>
                                            <span>Ajouter un match</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <div class="columns is-multiline">
                    <!-- HEADING -->
                    <div class="column is-12">
                        <div class="columns">
                            <div class="column is-2">
                                <span class="heading">Position</span>
                            </div>
                            <div class="column is-2">
                                <span class="heading">Nom</span>
                            </div>
                            <div class="column is-1">
                                <span class="heading">Victoire</span>
                            </div>
                            <div class="column is-1">
                                <span class="heading">Nul</span>
                            </div>
                            <div class="column is-1">
                                <span class="heading">Défaite</span>
                            </div>
                            <div class="column is-3 is-offset-1">
                                <span class="heading">Points</span>
                            </div>
                        </div>
                    </div>
                    <!-- DATA -->
                    <div class="column is-12" v-for="(player, i) in players" :key="player.id">
                        <div class="box">
                            <div class="columns">
                                <!-- TROPHY -->
                                <div class="column is-2">
                                    <span class="icon is-large" :class="{
                                        'has-text-gold': i === 0,
                                        'has-text-silver': i === 1,
                                        'has-text-bronze': i === 2,
                                        'has-text-grey-lighter': i >= 3
                                    }">
                                        <i class="fas fa-trophy-alt fa-2x"></i>
                                    </span>
                                </div>
                                <!-- NAME -->
                                <div class="column is-2">
                                    <p>{{ player.name }}</p>
                                </div>
                                <div class="column is-1">
                                    <p class="has-text-centered">0</p>
                                </div>
                                <div class="column is-1">
                                    <p class="has-text-centered">0</p>
                                </div>
                                <div class="column is-1">
                                    <p class="has-text-centered">0</p>
                                </div>
                                <div class="column is-3 is-offset-1">
                                    <p class="has-text-centered">0</p>
                                </div>
                                <div class="column is-1">
                                    <span class="icon is-large has-text-grey-light">
                                        <i class="fa fa-list-ul"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: 'App',
        data () {
            return {
                players: [],
                games: []
            }
        },
        created () {
            this.players = window.data.players
            this.games = window.data.games
        }
    }
</script>