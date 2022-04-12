import Vue from 'vue'
import Vuex from 'vuex'

// store module
import auth from '../store/auth'
import config from '../store/config/index'
import users from '../store/config/users'
import roles from '../store/config/roles'
import permission from '../store/config/permission'
import barang from '../store/barang/index'
import masterBarang from '../store/barang/masterBarang'
import permintaanBarang from '../store/barang/permintaanBarang'
// store module
Vue.use(Vuex)
const store = new Vuex.Store({
    modules: {
        auth,
        config,
        users,
        roles,
        permission,
        barang,
        masterBarang,
        permintaanBarang,
    },
    state: {
        token: localStorage.getItem('token'),
        baseUrl: process.env.NODE_ENV ==
            'production' ?
            window.location.protocol + '//' + window.location.hostname :
            window.location.protocol + '//' + window.location.hostname + ':8000/',
        errors: [],
        itemsmenu: [
            { text: "Dashboard", icon: "mdi-apps", to: "/", child:false, childitems:[] },
            { text: "Configuration", icon: "mdi-cogs", to: "/config", child:false, childitems:[] },
            { text: "Management Barang", icon: "mdi-car-shift-pattern", to: "/barang", child:false, childitems:[] },
        ],
        rooturl:'',
        tabappbar:null,
    },
    getters: {
        isAuth: state => {
            return state.token != "null" && state.token != null
        }
    },
    mutations: {
        SET_ISAUTH(state, payload) {
            state.isAuth = payload
        },
        SET_ERRORS(state, payload) {
            state.errors = payload
        },
        CLEAR_ERRORS(state) {
            state.errors = []
        },
        SET_TOKEN(state, payload) {
            state.token = payload
        },
        SET_ROOTURL(state, payload) {
            state.rooturl = payload
        },
        SET_TABAPPBAR(state, payload) {
            state.tabappbar = payload
        },
    }
})
export default store