<template>
  <div class="wrapper">
    <v-form ref="form">
      <v-row class="justify-center">
        <v-btn size="large" color="info" @click="addContact()">New</v-btn>
      </v-row>
      <v-row
        v-for="(item, index) in contacts"
        :key="index"
        :class="index % 2 !== 0 ? 'bg-surfaceLighten' : ''"
        class="py-4"
      >
        <v-col cols="2" class="d-flex justify-center align-center flex-column">
          <v-btn
            size="small"
            icon="fa fa-times"
            color="error"
            @click="deleteContact(index)"
          ></v-btn>
          <v-radio label="Primary" :value="index"></v-radio>
        </v-col>
        <v-col cols="10">
          <v-row>
            <v-col cols="4" sm="4">
              <v-text-field
                v-model="item.name"
                :rules="[(v) => !!v || 'Item is required']"
                label="Name"
                required
                density="compact"
              ></v-text-field>
            </v-col>
            <v-col cols="4" sm="4">
              <v-text-field
                v-model="item.email"
                :rules="emailRules"
                label="E-mail"
                density="compact"
              ></v-text-field>
            </v-col>
            <v-col cols="6" sm="3" v-if="false">
              <v-autocomplete
                v-model="item.ddi"
                :items="ddiList"
                :menu-props="{ maxHeight: 300 }"
                :rules="[(v) => !!v || 'Item is required']"
                label="Country"
                density="compact"
                autocomplete="nope"
                item-title="name"
                item-value="dial_code"
                :custom-filter="customFilter"
              >
                <template #selection="data">
                  {{ data.item.value }}
                </template>

                <template #item="{ props, item }">
                  <v-list-item
                    v-if="typeof item.raw !== 'object'"
                    v-bind="props"
                  ></v-list-item>
                  <v-list-item
                    v-else
                    v-bind="props"
                    :title="item.raw.dial_code + ' ' + item.raw.name"
                  ></v-list-item>
                </template>
              </v-autocomplete>
            </v-col>
            <v-col cols="4" sm="4">
              <v-text-field
                v-model="item.phone"
                :rules="[(v) => !!v || 'Item is required']"
                label="Phone"
                required
                density="compact"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-form>
  </div>
</template>

<script>
import { useContactStore } from "~/stores";

export default {
  name: "TheContactsAddList",
  setup: async function () {
    const contactStore = useContactStore();
    const contacts = contactStore.list;
    const ddiList = contactStore.ddiList;
    const deleteContact = contactStore.delete;
    const addContact = contactStore.createNewItem;
    return { contacts, deleteContact, addContact, ddiList };
  },
  data() {
    return {
      currentCountry: false,
      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) =>
          /^(([^<>()[\]\\.,;:\s@']+(\.[^<>()\\[\]\\.,;:\s@']+)*)|('.+'))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
            v
          ) || "E-mail must be valid",
      ],
    };
  },
  methods: {
    customFilter: function (item, queryText, itemText) {
      return (
        itemText.title
          .toLocaleLowerCase()
          .includes(queryText.toLocaleLowerCase()) ||
        itemText.value
          .toLocaleLowerCase()
          .includes(queryText.toLocaleLowerCase())
      );
    },
  },
};
</script>
