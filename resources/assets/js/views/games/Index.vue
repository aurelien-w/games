<template>
    <div class="columns is-multiline is-mobile">
        <!-- HEADING -->
        <div class="column is-3">
            <span class="heading">Joueur A</span>
        </div>
        <div class="column is-2">
            <span class="heading">Points A</span>
        </div>
        <div class="column is-2 has-text-centered">
            <span class="heading">Score</span>
        </div>
        <div class="column is-2 has-text-right">
            <span class="heading">Points B</span>
        </div>
        <div class="column is-3 has-text-right">
            <span class="heading">Joueur B</span>
        </div>
        <!-- DATA -->
        <div class="column is-12" v-for="game in games.all()" :key="game.id">
            <div class="box">
                <div class="columns is-center-aligned is-mobile">
                    <div class="column is-3">
                        <p>{{ game.player_a.name }}</p>
                    </div>
                    <div class="column is-2">
                        <p v-html="sign(game.rank_a)"></p>
                    </div>
                    <div class="column is-1">
                        <p>{{ game.score_a }}</p>
                    </div>
                    <div class="column is-1 has-text-right">
                        <p>{{ game.score_b }}</p>
                    </div>
                    <div class="column is-2 has-text-right">
                        <p v-html="sign(game.rank_b)"></p>
                    </div>
                    <div class="column is-3 has-text-right">
                        <p>{{ game.player_b.name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vuex from 'vuex'

    export default {
        name: 'GamesIndex',
        computed: {
            ...Vuex.mapGetters(['games'])
        },
        methods: {
            ...Vuex.mapActions(['fetchGames']),

            /**
             *
             * @param value
             * @returns {string}
             */
            sign (value) {
                value = '' + value
                let status = 'has-text-success'

                if (value.startsWith('-')) {
                    status = 'has-text-danger'
                }

                return `<span class="${status} has-text-weight-bold">${value}</span>`
            }
        },
        created () {
            this.toggleLoading()
            this.fetchGames()
                .then(this.toggleLoading)
        }
    }
</script>