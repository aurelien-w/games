<template>
    <div class="columns is-multiline">
        <!-- HEADING -->
        <div class="column is-3">
            <span class="heading">Joueur A</span>
        </div>
        <div class="column is-2">
            <span class="heading">Points A</span>
        </div>
        <div class="column is-1">
            <span class="heading">Score A</span>
        </div>
        <div class="column is-1 has-text-right">
            <span class="heading">Score B</span>
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
                <div class="columns is-center-aligned">
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
    import collect from 'collect.js'

    export default {
        name: 'GamesIndex',
        data () {
            return {
                games: collect()
            }
        },
        methods: {
            /**
             * Fetches the games
             */
            fetchGames () {
                window.axios.get('games')
                    .then(
                        response => this.games = collect(response.data)
                    )
                    .catch(console.error)
            },
            sign (value) {
                value = '' + value
                let status = 'has-text-success'

                if (value.startsWith('-')) {
                    status = 'has-text-danger'
                }

                return `<span class="${status}">${value}</span>`
            }
        },
        created () {
            this.fetchGames()
        }
    }
</script>