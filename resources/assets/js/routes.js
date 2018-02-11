import Vue from 'vue'
import VueRouter from 'vue-router'

import PlayersLayout from './views/players/Layout'
import PlayersIndex from './views/players/Index'
import GamesLayout from './views/games/Layout'
import GamesIndex from './views/games/Index'
import GamesCreate from './views/games/Create'
import NotFound from './views/NotFound'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: PlayersLayout,
            children: [
                {
                    name: 'players.index',
                    path: '',
                    component: PlayersIndex,
                    meta: {
                        title: 'Classement des joueurs'
                    }
                }
            ]
        },
        {
            path: '/games',
            component: GamesLayout,
            children: [
                {
                    name: 'games.index',
                    path: '',
                    component: GamesIndex,
                    meta: {
                        title: 'Liste des matchs'
                    }
                },
                {
                    name: 'games.create',
                    path: 'create',
                    component: GamesCreate,
                    meta: {
                        title: 'Ajouter un match'
                    }
                }
            ]
        },
        {
            path: '*',
            component: NotFound,
            meta: {
                title: '404 Page Introuvable'
            }
        }
    ]
})

let title = document.querySelector('title').innerText
router.beforeEach((to, from, next) => {
    document.querySelector('title').innerText = `${to.meta.title} | ${title}`

    next()
})

export default router