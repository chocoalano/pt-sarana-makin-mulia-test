import $axios from '../../core/api.js'
const state = () => ({
    form: {
        user_id: "",
        user_name: "",
        user_roles: "",
        tanggal_permintaan: "",
        data: []
    },
    formedit: {
        user_id: "",
        barang_id: "",
        qty: "",
        status: "",
        tanggal_permintaan: "",
        keterangan: "",
    },
})

const mutations = {
    CLEAR_FORM(state, payload) {
        state.form = {
            user_id: "",
            data: []
        }
    },
    SET_FORM(state, payload) {
        state.form = {
            user_id: payload.user_id,
            data: payload.data
        }
    },
    CLEAR_FORM_EDIT(state, payload) {
        state.formedit = {
            user_id: "",
            barang_id: "",
            qty: "",
            status: "",
            tanggal_permintaan: "",
            keterangan: "",
        }
    },
    SET_FORM_EDIT(state, payload) {
        state.formedit = {
            user_id: payload.user_id,
            barang_id: payload.barang_id,
            qty: payload.qty,
            status: payload.status,
            tanggal_permintaan: payload.tanggal_permintaan,
            keterangan: payload.keterangan,
        }
    },
}

const actions = {
    index({ }, payload) {
        return new Promise((resolve) => {
            let url = `/permintaan-barang?search=&sortBy=${payload.sortBy}&sortDesc=${payload.sortDesc}&perpage=${payload.itemsPerPage}&page=${payload.page}`
            $axios.get(url)
                .then((response) => {
                    resolve(response.data.response)
                })
                .catch((error) => {
                    resolve(error.response.data);
                })
        })
    },
    create({ state }) {
        return new Promise((resolve) => {
            $axios.get(`/permintaan-barang/create`)
                .then((response) => {
                    resolve(response.data)
                })
                .catch((error) => {
                    resolve(error.response.data);
                })
        })
    },
    store({ commit, state }) {
        return new Promise((resolve) => {
            $axios.post(`/permintaan-barang`, state.form)
                .then((response) => {
                    commit("CLEAR_FORM")
                    resolve(response)
                })
                .catch((error) => {
                    resolve(error.response);
                })
        })
    },
    edit({ commit }, payload) {
        return new Promise((resolve) => {
            $axios.get(`/permintaan-barang/${payload}/edit`)
                .then((response) => {
                    console.log(response.data.response.user_id);
                    const form = {
                        user_id:response.data.response.user_id,
                        barang_id:response.data.response.barang_id,
                        qty:response.data.response.qty,
                        status:response.data.response.status,
                        tanggal_permintaan:response.data.response.tanggal_permintaan,
                        keterangan:response.data.response.keterangan,
                    }
                    commit("SET_FORM_EDIT", form)
                    resolve(response.data.response)
                })
                .catch((error) => {
                    // resolve(error.response.data);
                    console.log(error);
                })
        })
    },
    update({ commit, state }, payload) {
        return new Promise((resolve) => {
            $axios.patch(`/permintaan-barang/${payload}`, state.formedit)
                .then((response) => {
                    commit("CLEAR_FORM")
                    resolve(response)
                })
                .catch((error) => {
                    resolve(error.response);
                })
        })
    },
    delete({ }, payload) {
        return new Promise((resolve) => {
            $axios.delete(`/permintaan-barang/${payload}`)
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
