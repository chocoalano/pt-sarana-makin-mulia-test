<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="4" sm="12">
        <v-select
          :items="users"
          outlined
          dense
          label="NIK Peminta"
          v-model="form.user_id"
          @change="setupUser(form.user_id)"
          :item-text="(users) => users.nik + ' - ' + users.name"
          item-value="id"
        ></v-select>
      </v-col>
      <v-col cols="12" md="4" sm="12">
        <v-text-field
          outlined
          dense
          disabled
          filled
          label="Nama"
          v-model="form.user_name"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="4" sm="12">
        <v-text-field
          outlined
          dense
          disabled
          filled
          label="Departemen"
          v-model="form.user_roles"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" md="4" sm="12">
        <v-menu
          v-model="menu2"
          :close-on-content-click="false"
          :nudge-right="40"
          transition="scale-transition"
          offset-y
          min-width="auto"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              v-model="form.tanggal_permintaan"
              label="Tanggal Permintaan"
              prepend-inner-icon="mdi-calendar"
              readonly
              outlined
              dense
              v-bind="attrs"
              v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker
            v-model="form.tanggal_permintaan"
            @input="menu2 = false"
          ></v-date-picker>
        </v-menu>
      </v-col>
    </v-row>
    <v-simple-table dense>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">No ID</th>
            <th class="text-center">Barang</th>
            <th class="text-center">Lokasi</th>
            <th class="text-center">Tersedia</th>
            <th class="text-center">Kuantiti</th>
            <th class="text-center">Satuan</th>
            <th class="text-center">Keterangan</th>
            <th class="text-center">Status</th>
            <th class="text-center">*</th>
          </tr>
        </thead>
        <tbody class="ma-2">
          <tr v-for="input in inputs" :key="input.id">
            <td>{{ parseInt(input.id) + 1 }}</td>
            <td>
              <v-select
                :items="barang"
                dense
                :item-text="(barang) => barang.kode + ' - ' + barang.name"
                item-value="id"
                :id="input.id"
                v-model="input.barang_id"
                @change="pickerBarang(input.barang_id, input.id)"
              ></v-select>
            </td>
            <td>
              <v-text-field
                dense
                disabled
                filled
                :id="input.id"
                v-model="input.lokasi"
              ></v-text-field>
            </td>
            <td>
              <v-text-field
                dense
                disabled
                type="number"
                filled
                :id="input.id"
                v-model="input.tersedia"
              ></v-text-field>
            </td>
            <td>
              <v-text-field
                dense
                :id="input.id"
                type="number"
                v-model="input.qty"
                @keyup="validasiQty(input.tersedia, input.qty, input.id)"
              ></v-text-field>
            </td>
            <td>
              <v-text-field
                dense
                disabled
                filled
                :id="input.id"
                v-model="input.satuan"
              ></v-text-field>
            </td>
            <td>
              <v-text-field
                dense
                :id="input.id"
                v-model="input.keterangan"
              ></v-text-field>
            </td>
            <td>
              <input type="hidden" :id="input.id" v-model="input.status" />
              <v-chip
                class="ma-1"
                :color="
                  input.status === 'terpenuhi' ? 'green' : 'pink darken-1'
                "
                text-color="white"
                v-if="input.status != ''"
              >
                {{ input.status }}
              </v-chip>
              <v-progress-circular
                indeterminate
                color="primary"
                v-else
              ></v-progress-circular>
            </td>
            <td>
              <v-btn icon @click="deleteInput(input.id)">
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="9" class="text-right">
              <v-btn
                color="primary"
                fab
                small
                dark
                class="mt-2"
                @click="addInput"
              >
                <v-icon>mdi-plus</v-icon>
              </v-btn>
            </th>
          </tr>
        </tfoot>
      </template>
    </v-simple-table>
  </v-container>
</template>
<script>
import { mapState, mapActions } from "vuex";
export default {
  data: () => ({
    users: [],
    barang: [],
    date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
      .toISOString()
      .substr(0, 10),
    menu2: false,

    inputs: [
      {
        id: "0",
        barang_id: "",
        lokasi: "",
        tersedia: "",
        qty: "",
        satuan: "",
        keterangan: "",
        status: "",
      },
    ],
  }),
  computed: {
    ...mapState("permintaanBarang", {
      form: (state) => state.form,
    }),
    form: {
      get: function () {
        return this.$store.state.permintaanBarang.form;
      },
      set: function (value) {
        this.$store.commit("permintaanBarang/SET_FORM", value);
      },
    },
  },
  created() {
    this.create().then((res) => {
      this.users = res.user;
      this.barang = res.barang;
    });
    this.form.data=this.inputs
  },
  watch:{
    inputs(nval, oldval){
      this.form.data=nval
    }
  },
  methods: {
    ...mapActions("permintaanBarang", ["create"]),
    addInput() {
      let idset = this.inputs.length - 1
      this.inputs.push({
        id: `${++idset}`,
        barang_id: "",
        lokasi: "",
        tersedia: "",
        qty: "",
        satuan: "",
        keterangan: "",
        status: "",
      });
    },
    deleteInput(e) {
      this.inputs.splice(this.inputs.indexOf(e), 1);
    },
    setupUser(e) {
      var fetch = this.users[e - 1];
      this.form.user_name = fetch.name;
      this.form.user_roles = fetch.departemen;
    },
    pickerBarang(idbarang, idarray) {
      let idrow=parseInt(idarray);
      var baranglist = this.barang;
      var matchedIndex = baranglist
        .map(function (obj) {
          return obj.id;
        })
        .indexOf(idbarang);
      var fetch = baranglist[matchedIndex];
      this.inputs[idrow].lokasi = fetch.lokasi;
      this.inputs[idrow].tersedia = fetch.stok;
      this.inputs[idrow].satuan = fetch.satuan;
    },
    validasiQty(stok, qty, id) {
      this.inputs[id].status = stok >= qty ? "terpenuhi" : "tidak terpenuhi";
    },
  },
};
</script>