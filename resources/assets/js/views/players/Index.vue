<template>
    <div class="columns is-multiline">
        <!-- HEADING -->
        <div class="column is-2">
            <span class="heading">Position</span>
        </div>
        <div class="column is-3">
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
        <div class="column is-2 is-offset-1">
            <span class="heading">Points</span>
        </div>
        <!-- DATA -->
        <div class="column is-12" v-for="(player, i) in players.all()" :key="player.id">
            <div class="box">
                <div class="columns is-center-aligned">
                    <!-- TROPHY -->
                    <div class="column is-2">
                        <p>
                                    <span class="icon is-large" :class="trophy(i)">
                                        <i class="fas fa-trophy-alt fa-2x"></i>
                                    </span>
                            <span class="is-size-5">{{ i + 1 }}</span>
                        </p>
                    </div>
                    <!-- NAME -->
                    <div class="column is-3">
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
                    <div class="column is-2 is-offset-1">
                        <p class="has-text-centered">{{ player.rank }}</p>
                    </div>
                    <div class="column is-1">
                        <a class="icon is-large has-text-grey-light">
                            <i class="fa fa-list-ul"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import collect from 'collect.js'

    export default {
        name: 'PlayersIndex',
        data () {
            return {
                players: collect()
            }
        },
        methods: {
            /**
             * Fetches the players
             */
            fetchPlayers () {
                window.axios.get('players')
                    .then(
                        response => this.players = collect(response.data)
                    )
                    .catch(console.error)
            },
            /**
             * Determines the trophy color
             * @param position
             * @returns {string}
             */
            trophy (position) {
                if (position === 0) return 'has-text-gold'
                if (position === 1) return 'has-text-silver'
                if (position === 2) return 'has-text-bronze'

                return 'has-text-grey-lighter'
            }
        },
        created () {
            this.fetchPlayers()
        }
    }
</script>