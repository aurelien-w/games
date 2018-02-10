import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import collect from 'collect.js'

Vue.use(Vuex)

window.axios = axios.create({
    baseURL: window.location.origin + '/api/',
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
})

const modules = {}

const state = {
    players: collect(),
    games: collect()
}

const mutations = {
    /**
     * Updates the players state
     * @param state - Store statte
     * @param entities - Player entities
     * @returns {*}
     */
    FETCH_PLAYERS: (state, entities) => state.players = collect(entities),

    /**
     * Updates the games state
     * @param state - Store state
     * @param entities - Game entities
     * @returns {*}
     */
    FETCH_GAMES: (state, entities) => state.games = collect(entities)
}

const actions = {
    /**
     * Fetches the players from the API
     * @param store - Store state
     */
    fetchPlayers (store) {
        window.axios.get('players')
            .then(
                response => store.commit('FETCH_PLAYERS', response.data)
            )
            .catch(console.error)
    },
    /**
     * Fetches the games from the API
     * @param store - Store state
     */
    fetchGames (store) {
        window.axios.get('games')
            .then(
                response => store.commit('FETCH_GAMES', response.data)
            )
            .catch(console.error)
    }
}

const getters = {
    /**
     * Player state getter
     * @param state - Store state
     * @returns {"collect.js".Collection<any> | *}
     */
    players (state) {
        return state.players
    },

    /**
     * Game state getter
     * @param state - Store state
     * @returns {"collect.js".Collection<any> | *}
     */
    games (state) {
        return state.games
    }
}

export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',
    modules,
    state,
    mutations,
    actions,
    getters
})