<template>
  <div
    v-if="$store.state.search.table.length > 0"
    class="card-body"
    style="overflow: hidden"
  >
    <div class="table-responsive" style="width: 100%">
      <v-table class="table table-striped mb-1">
        <thead>
          <tr>
            <th>&nbsp;</th>
            <th v-for="(header, index) in getHeader" :key="index">
              <strong>{{ header }}</strong>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(tr, i) in $store.state.search.table" :key="i">
            <td>
              <div
                class="btn btn-warning btn-round btn-sm m-0 btn-fab"
                @click="editItem(tr)"
              >
                <i class="fa fa-pencil" />
              </div>
            </td>
            <td v-for="(td, ii) in getTr(tr)" :key="ii" v-html="td"></td>
          </tr>
        </tbody>
      </v-table>
    </div>
  </div>
  <div v-else class="col-md-12">
    <h3 class="text-center border py-2">{{ $t("nothing_found") }}</h3>
  </div>
</template>

<script>
export default {
  name: "BaseGrid",
  props: {
    target: {
      type: String,
      description: "Link to redirect when edit btn is clicked",
    },
  },
  computed: {
    getHeader: function () {
      if (this.$store.state.search.table[0]) {
        return Object.keys(this.$store.state.search.table[0]);
      }
      return [];
    },
  },
  methods: {
    editItem(tr) {
      this.$helper.redirect(this.target + "/" + tr.id);
    },
    getTr(row) {
      let td = [];
      for (let r in row) {
        td.push(this.getTd(row[r]));
      }
      return td;
    },
    getTd: function (data) {
      if (data === true) {
        data = "<i class='fa fa-check' style='color: green;'></i>";
      } else if (data === false) {
        data = "<i class='fa fa-times' style='color: red;'></i>";
      }
      return data;
    },
  },
};
</script>
