<template>
    <div class="columns is-multiline is-mobile">
        <!-- HEADING -->
        <div class="column is-3-mobile is-2-tablet">
            <span class="heading">Position</span>
        </div>
        <div class="column is-4-mobile is-3-tablet">
            <span class="heading">Nom</span>
        </div>
        <div class="column is-1 is-hidden-mobile">
            <span class="heading">Victoire</span>
        </div>
        <div class="column is-1 is-hidden-mobile">
            <span class="heading">Nul</span>
        </div>
        <div class="column is-1 is-hidden-mobile">
            <span class="heading">Défaite</span>
        </div>
        <div class="column is-3-mobile is-2-tablet is-offset-1-tablet">
            <span class="heading">Points</span>
        </div>
        <!-- DATA -->
        <div class="column is-12" v-for="(player, i) in players.all()" :key="player.id">
            <div class="box">
                <div class="columns is-center-aligned is-mobile">
                    <!-- TROPHY -->
                    <div class="column is-2-mobile is-2-tablet has-text-centered">
                        <p class="icon is-size-7-touch" v-if="i <= 2" :class="trophy(i)">
                            <i class="fas fa-trophy-alt fa-2x"></i>
                        </p>
                        <p class="is-size-3" v-else>{{ i + 1 }}</p>
                    </div>
                    <!-- NAME -->
                    <div class="column is-5-mobile is-3-tablet">
                        <p>{{ player.name }}</p>
                    </div>
                    <div class="column is-1 is-hidden-mobile">
                        <p class="has-text-centered">0</p>
                    </div>
                    <div class="column is-1 is-hidden-mobile">
                        <p class="has-text-centered">0</p>
                    </div>
                    <div class="column is-1 is-hidden-mobile">
                        <p class="has-text-centered">0</p>
                    </div>
                    <div class="column is-3-mobile is-2-tablet is-offset-1-tablet">
                        <p class="has-text-centered">{{ player.rank }}</p>
                    </div>
                    <div class="column is-2">
                        <a class="icon has-text-grey-light">
                            <i class="fa fa-list-ul"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vuex from 'vuex'

    export default {
        name: 'PlayersIndex',
        computed: {
            ...Vuex.mapGetters(['players']),
        },
        methods: {
            ...Vuex.mapActions(['fetchPlayers']),

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
            this.toggleLoading()
            this.fetchPlayers()
                .then(this.toggleLoading)
        }
    }
</script>