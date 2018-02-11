<template>
    <div class="box">
        <form method="POST" @submit.prevent="submit">
            <!-- PLAYER A -->
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label for="player_a" class="label">Joueur A</label>
                        <div class="control is-expanded has-icons-left">
                            <span class="icon is-left">
                                <i class="fal fa-user"></i>
                            </span>
                            <div class="select is-fullwidth" :class="{ 'is-danger': errors.has('player_a') }">
                                <select id="player_a" v-model="form.player_a">
                                    <option selected disabled>Joueur A</option>
                                    <option :value="player.id" v-for="player in playersA.all()">{{ player.name }}</option>
                                </select>
                            </div>
                        </div>
                        <ul class="help is-danger" v-show="errors.has('player_a')">
                            <li v-for="error in errors.get('player_a')">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="column is-narrow">
                    <div class="field">
                        <label for="score_a" class="label">Score A</label>
                        <div class="control has-icons-left">
                            <span class="icon is-left">
                                <i class="fas fa-futbol"></i>
                            </span>
                            <input type="number"
                                   id="score_a"
                                   class="input"
                                   :class="{ 'is-danger': errors.has('score_a') }"
                                   v-model="form.score_a">
                        </div>
                        <ul class="help is-danger" v-show="errors.has('score_a')">
                            <li v-for="error in errors.get('score_a')">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- PLAYER B -->
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label for="player_b" class="label">Joueur B</label>
                        <div class="control is-expanded has-icons-left">
                            <span class="icon is-left">
                                <i class="fal fa-user"></i>
                            </span>
                            <div class="select is-fullwidth" :class="{ 'is-danger': errors.has('player_b') }">
                                <select id="player_b" name="player_b" v-model="form.player_b">
                                    <option selected disabled>Joueur B</option>
                                    <option :value="player.id" v-for="player in playersB.all()">{{ player.name }}</option>
                                </select>
                            </div>
                        </div>
                        <ul class="help is-danger" v-show="errors.has('player_b')">
                            <li v-for="error in errors.get('player_b')">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="column is-narrow">
                    <div class="field">
                        <label for="score_a" class="label">Score B</label>
                        <div class="control has-icons-left">
                            <span class="icon is-left">
                                <i class="fas fa-futbol"></i>
                            </span>
                            <input type="number"
                                   id="score_b"
                                   class="input"
                                   :class="{ 'is-danger': errors.has('score_b') }"
                                   v-model="form.score_b">
                        </div>
                        <ul class="help is-danger" v-show="errors.has('score_b')">
                            <li v-for="error in errors.get('score_b')">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- BUTTONS -->
            <div class="level is-mobile">
                <div class="level-left">
                    <button type="button" class="button is-danger is-outlined is-size-7-touch" @click.prevent="close">
                        <span class="icon">
                            <i class="fal fa-times"></i>
                        </span>
                        <span>Annuler</span>
                    </button>
                </div>
                <div class="level-right">
                    <button type="submit"
                            class="button is-success is-outlined is-size-7-touch"
                            :class="{ 'is-loading' : loading }"
                            :disabled="!submittable">
                        <span>Sauvegarder</span>
                        <span class="icon">
                            <i class="fal fa-check"></i>
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import Vuex from 'vuex'
    import collect from 'collect.js'

    export default {
        name: 'GamesCreate',
        data () {
            return {
                form: {
                    player_a: null,
                    player_b: null,
                    score_a: null,
                    score_b: null
                },
                errors: collect({})
            }
        },
        computed: {
            ...Vuex.mapGetters(['players']),

            /**
             * Collection of available A players
             * @returns {*}
             */
            playersA () {
                if (this.form.player_b === null) return this.players

                return this.players.except(
                    this.players.first(player => player.id === this.form.player_b)
                )
            },

            /**
             * Collection of available B players
             * @returns {*}
             */
            playersB () {
                if (this.form.player_a === null) return this.players

                return this.players.except(
                    this.players.first(player => player.id === this.form.player_a)
                )
            },

            /**
             * Determines if the form is submittable
             * @returns {boolean | *}
             */
            submittable () {
                return this.errors.isEmpty() && !this.loading
            }
        },
        methods: {
            ...Vuex.mapActions(['fetchPlayers', 'storeGame']),

            /**
             * Rests the form
             */
            reset () {
                this.form = {
                    player_a: null,
                    player_b: null,
                    score_a: null,
                    score_b: null
                }

                this.errors = collect({})
            },

            /**
             * Close event emitter
             * @param event
             */
            close (event = null) {
                this.reset()
                this.$emit('close', event)
            },

            /**
             * Handles form submission
             * @param event
             */
            submit (event) {
                if (!this.submittable) return

                this.toggleLoading()
                this.storeGame(this.form)
                    .then(
                        () => this.close(event)
                    )
                    .catch(({ response }) => {
                        flash(response.data.message)
                        this.errors = collect(response.data.errors)
                    })
                    .then(this.toggleLoading)
            }
        },
        created () {
            this.toggleLoading()
            this.fetchPlayers()
                .then(this.toggleLoading)
        }
    }
</script>