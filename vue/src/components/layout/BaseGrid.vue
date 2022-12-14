<template>
  <div>
    <v-row class="justify-content-between">
      <v-col
        cols="3"
        md="2"
      >
        <v-select
          v-model="internalLimit"
          label="Page limit"
          item-text="text"
          item-value="value"
          required
          :items="profiles"
          :rules="[(v) => !!v || 'Le type doit être renseignée']"
          @input="$emit('update:limit', $event)"
        />
      </v-col>
    </v-row>
    <v-table v-if="getCleanedMatrix.length">
      <slot name="thead">
        <thead>
          <tr>
            <th
              v-for="item in getHeader"
              :key="item"
            >
              {{ item }}
            </th>
          </tr>
        </thead>
      </slot>
      <slot name="tbody">
        <tbody>
          <tr
            v-for="(item, index) in getCleanedMatrix"
            :key="index"
          >
            <template v-for="(r, i) in item">
              <slot
                :item="item"
                :index="index"
                :element="item"
                :text="r"
                :name="i"
              >
                <td :key="i">
                  {{ r ? r : "-" }}
                </td>
              </slot>
            </template>
          </tr>
        </tbody>
      </slot>
    </v-table>
    <div v-else>
      <div class="subtitle-bread text-center mt-15">
        There's no item to list. You can modify the filter or the page.
      </div>
    </div>
    <v-row class="justify-center mt-0">
      <slot name="pagination">
        <div class="text-center mt-4">
          <v-pagination
            v-model="internalPage"
            active-color="secondary"
            :length="page + 6"
            :total-visible="7"
          />
        </div>
      </slot>
    </v-row>
  </div>
</template>

<script>
export default {
  name: "BaseGrid",
  props: {
    matrix: {
      type: Array,
      description: "Multidimensional array to be rendered",
    },
    // this order the columns in the table, you can switch with the given array
    header: {
      type: Object,
      description: "array to render as the header",
    },
    formatter: {
      type: Object,
      description:
        "array with column names to formatter in any type, like date, bools",
    },
    page: {
      description: "number of page used in search",
    },
    limit: {
      description: "limit of items per page",
    },
  },
  emits: ["update:page", "updateSearch", "update:limit"],
  data: () => ({
    profiles: [10, 50, 100, "all"],
  }),
  computed: {
    internalPage: {
      get() {
        return this.page;
      },
      set(e) {
        this.$emit("update:page", e);
        this.$emit("updateSearch");
      },
    },
    internalLimit: {
      get() {
        return this.limit;
      },
      set(e) {
        this.$emit("update:limit", e);
        this.$emit("updateSearch");
      },
    },
    getCleanedMatrix: function () {
      const array = [];
      const formatter = this.formatter;
      const header = this.header;
      for (const element of this.matrix) {
        const temp = {};
        for (var headerKey in header) {
          temp[headerKey] = element[headerKey];
        }
        // formatter
        for (var formatterKey in formatter) {
          temp[formatterKey] = this.doFormat(
            formatter[formatterKey],
            temp[formatterKey]
          );
        }
        array.push(temp);
      }
      return array;
    },
    getHeader: function () {
      if (this.header) {
        return this.header;
      }
      if (this.matrix.length) {
        return Object.keys(this.matrix[0]);
      }
      return 0;
    },
  },
  methods: {
    doFormat: function (type, value) {
      if (!value) {
        return value;
      }

      switch (type) {
      case "date":
        return this.formatDate(value);
      default:
        return value;
      }
    },
    formatDate(currentDate) {
      const timestamp = Date.parse(currentDate);
      const date = new Date(timestamp);
      let day = date.getDate();
      let month = date.getMonth() + 1;
      let hour = date.getHours();
      let min = date.getMinutes();

      day = (day < 10 ? "0" : "") + day;
      month = (month < 10 ? "0" : "") + month;
      hour = (hour < 10 ? "0" : "") + hour;
      min = (min < 10 ? "0" : "") + min;

      return (
        day + "/" + month + "/" + date.getFullYear() + " " + hour + ":" + min
      );
    },
  },
};
</script>
