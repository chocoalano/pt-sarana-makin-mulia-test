<template>
  <v-container>
    <v-text-field
      v-model="form.name"
      label="Nama Barang"
    ></v-text-field>
    <v-text-field
      v-model="form.lokasi"
      label="Lokasi"
    ></v-text-field>
    <v-text-field
      v-model="form.stok"
      label="Stok"
    ></v-text-field>
    <v-radio-group
      v-model="form.satuan"
      label="Satuan"
      row
    >
      <v-radio
        label="Pak"
        value="pak"
      ></v-radio>
      <v-radio
        label="PCS"
        value="pcs"
      ></v-radio>
    </v-radio-group>
  </v-container>
</template>
<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState("masterBarang", {
      form: (state) => state.form,
    }),
    form: {
      get: function () {
        return this.$store.state.masterBarang.form;
      },
      set: function (value) {
        this.$store.commit("masterBarang/SET_FORM", value);
      },
    },
  },
};
</script>