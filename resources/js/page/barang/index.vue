<template>
  <v-container>
    <section>
      <v-breadcrumbs :items="breadcrumbs">
        <template v-slot:item="{ item }">
          <v-breadcrumbs-item :href="item.href" :disabled="item.disabled">
            {{ item.text.toUpperCase() }}
          </v-breadcrumbs-item>
        </template>
      </v-breadcrumbs>
    </section>

    <section>
      <v-card>
        <v-tabs-items v-model="tabappbar">
          <v-tab-item value="master">
            <master-barang></master-barang>
            <p>master-barang</p>
          </v-tab-item>
          <v-tab-item value="permintaan">
            <permintaan-barang></permintaan-barang>
          </v-tab-item>
        </v-tabs-items>
      </v-card>
    </section>
  </v-container>
</template>
<script>
import { mapState } from "vuex";
import MasterBarang from "./master-barang/data.vue";
import PermintaanBarang from "./permintaan-barang/data.vue";
export default {
  created() {
    this.$store.commit("SET_ROOTURL", this.$route.name, { root: true });
  },
  data() {
    return {
      breadcrumbs: [
        {
          text: "Dashboard",
          disabled: false,
          href: "/",
        },
        {
          text: "Management Barang",
          disabled: true,
          href: "/config",
        },
      ],
    };
  },
  components:{
    MasterBarang,
    PermintaanBarang,
  },
  computed: {
    ...mapState(["tabappbar"]),
    tabappbar: {
      get: function () {
        return this.$store.state.tabappbar;
      },
      set: function (value) {
        this.$store.commit("SET_TABAPPBAR", value, { root: true });
      },
    },
  },
};
</script>