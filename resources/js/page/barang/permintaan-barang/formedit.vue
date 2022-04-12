<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6" sm="12">
        <v-select
          :items="users"
          dense
          label="NIK Peminta"
          v-model="formedit.user_id"
          :item-text="(users) => users.nik + ' - ' + users.name"
          item-value="id"
        ></v-select>
      </v-col>
      <v-col cols="12" md="6" sm="12">
        <v-select
          :items="barang"
          dense
          label="Barang"
          :item-text="(barang) => barang.kode + ' - ' + barang.name"
          item-value="id"
          v-model="formedit.barang_id"
        ></v-select>
      </v-col>
      <v-col cols="12" md="4" sm="12">
        <v-text-field v-model="formedit.qty" label="Stok"></v-text-field>
      </v-col>
      <v-col cols="12" md="4" sm="12">
        <v-radio-group v-model="formedit.status" row>
          <v-radio label="Terprnuhi" value="terpenuhi"></v-radio>
          <v-radio label="Tidak Terprnuhi" value="tidak terpenuhi"></v-radio>
        </v-radio-group>
      </v-col>
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
              v-model="formedit.tanggal_permintaan"
              label="Tanggal Permintaan"
              prepend-inner-icon="mdi-calendar"
              readonly
              dense
              v-bind="attrs"
              v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker
            v-model="formedit.tanggal_permintaan"
            @input="menu2 = false"
          ></v-date-picker>
        </v-menu>
      </v-col>
      <v-col cols="12" md="12" sm="12">
        <v-textarea
          v-model="formedit.keterangan"
          name="input-7-1"
          filled
          label="Keterangan"
          auto-grow
        ></v-textarea>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { mapState, mapActions } from "vuex";
export default {
  created() {
    this.create().then((res) => {
      this.users = res.user;
      this.barang = res.barang;
    });
  },
  data: () => ({
    users: [],
    barang: [],
    menu2: false,
  }),
  computed: {
    ...mapState("permintaanBarang", {
      formedit: (state) => state.formedit,
    }),
    form: {
      get: function () {
        return this.$store.state.permintaanBarang.formedit;
      },
      set: function (value) {
        this.$store.commit("permintaanBarang/SET_FORM_EDIT", value);
      },
    },
  },
  methods: {
    ...mapActions("permintaanBarang", ["create"]),
  },
};
</script>