import $axios from '../../core/api.js'
const state = () => ({
    form: {
        name: "",
        lokasi: "",
        stok: "",
        satuan: "",
    },
})

const mutations = {
    CLEAR_FORM(state, payload) {
        state.form = {
            name: "",
            lokasi: "",
            stok: "",
            satuan: "",
        }
    },
    SET_FORM(state, payload) {
        state.form = {
            name: payload.name,
            lokasi: payload.lokasi,
            stok: payload.stok,
            satuan: payload.satuan,
        }
    },
}

const actions = {
    index({ }, payload) {
        return new Promise((resolve) => {
            $axios.get(`/barang?page=${payload.page}&sortBy=${payload.sortBy}&sortDesc=${payload.sortDesc}&itemsPerPage=${payload.itemsPerPage}`)
                .then((response) => {
                    resolve(response.data.response)
                })
                .catch((error) => {
                    resolve(error.response.data);
                })
        })
    },
    store({ commit, state }) {
        return new Promise((resolve) => {
            $axios.post(`/barang`, state.form)
                .then((response) => {
                    commit("CLEAR_FORM")
                    resolve(response)
                })
                .catch((error) => {
                    resolve(error.response.data);
                })
        })
    },
    edit({ commit }, payload) {
        return new Promise((resolve) => {
            $axios.get(`/barang/${payload}/edit`)
                .then((response) => {
                    const form = {
                        name: response.data.response.name,
                        lokasi: response.data.response.lokasi,
                        stok: response.data.response.stok,
                        satuan: response.data.response.satuan,
                    }
                    commit("SET_FORM", form)
                    resolve(response.data.response)
                })
                .catch((error) => {
                    // resolve(error.response.data);
                    console.log(error);
                })
        })
    },
    update({ commit, state },payload) {
        return new Promise((resolve) => {
            $axios.patch(`/barang/${payload}`, state.form)
                .then((response) => {
                    commit("CLEAR_FORM")
                    resolve(response)
                })
                .catch((error) => {
                    resolve(error.response.data);
                })
        })
    },
    delete({  },payload) {
        return new Promise((resolve) => {
            $axios.delete(`/barang/${payload}`)
                .then((response) => {
                    resolve(response)
                })
                .catch((error) => {
                    resolve(error.response);
                })
        })
    },
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
