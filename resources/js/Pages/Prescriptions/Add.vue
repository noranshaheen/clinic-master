<template>
  <app-layout>
    <jet-validation-errors class="mb-4 mt-4" />
    <div class="py-4">
      <!-- <dialog-invoice-line :invoice="invoice" v-model="currentItem" ref="dlg1" @update:model-value="onClose" /> -->
      <div class="mx-auto sm:px-6 lg:px-8">
        <div
          class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 pb-4 pt-0"
        >
          <div class="grid grid-cols-4 gap-4 sm:grid-cols-1 mt-4">
            <div class="col-span-2">
              <jet-label value="Patient" />
              <!-- <select v-model="form.patient">
                <option
                  v-for="patient in patients"
                  :key="patient.id"
                  :value="patient.id"
                >
                  {{ patient.id+" "+ patient.name }}
                </option>
              </select> -->
              <multiselect
                v-model="form.patient"
                label="id"
                :options="patients"
                placeholder="Select Patient"
                searchable="true"
                :custom-label="nameWithId"
                track-by="id"
              />
            </div>

            <div class="col-span-2">
              <TextField
                v-model="form.dateTimeIssued"
                itemType="datetime-local"
                itemLabel="Date Issued"
              />
            </div>

            <div class="col-span-4">
              <div
                v-for="(invLine, idx1) in form.prescriptionLines"
                :key="idx1"
                class="grid grid-cols-10 gap-4"
              >
                <div class="col-span-2">
                  <jet-label value="Medicine" />
                  <!-- <select v-model="invLine.drug">
                  <option v-for="drug in drugs" :key="drug.id" :value="drug.id">
                    {{ drug.name }}
                  </option>
                </select> -->
                  <multiselect
                    v-model="invLine.drug"
                    label="name"
                    :options="drugs"
                    placeholder="Select Medicine"
                    searchable="true"
                  />
                </div>

                <div class="col-span-2">
                  <jet-label value="Dose" />
                  <select
                    v-model="invLine.dose"
                    class="mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm"
                  >
                    <option value="1">{{ "One Time" }}</option>
                    <option value="2">{{ "Two Times" }}</option>
                    <option value="3">{{ "Three Time" }}</option>
                  </select>
                </div>

                <div class="col-span-2">
                  <jet-label value="Time" />
                  <select
                    v-model="invLine.time"
                    class="mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm"
                  >
                    <option value="day">{{ "A Day" }}</option>
                    <option value="week">{{ "A Week" }}</option>
                  </select>
                </div>

                <div class="col-span-3">
                  <TextField
                    v-model="invLine.notes"
                    itemType="text"
                    itemLabel="Notes"
                  />
                </div>

                <div class="col-span-1">
                  <jet-danger-button @click="DeleteItem(idx1)" class="mt-4">
                    {{ __("Delete") }}
                  </jet-danger-button>
                </div>
              </div>
            </div>
          </div>

          <div class="flex items-center justify-end mt-4">
            <jet-button class="ms-2" @click="AddItem()">
              {{ __("Add Another Drug") }}
            </jet-button>
          </div>

          <div class="flex items-center justify-start mt-20">
            <jet-secondary-button @click="onCancel()">
              {{ __("Cancel") }}
            </jet-secondary-button>

            <jet-button class="ms-2" @click="onSave()">
              {{ __("Save") }}
            </jet-button>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>

<script>
import { computed, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import TextField from "@/UI/TextField.vue";
import Multiselect from "@suadelabs/vue3-multiselect";
import DialogInvoiceLine from "@/Pages/Invoices/EditLine.vue";
import axios from "axios";

export default {
  components: {
    AppLayout,
    JetLabel,
    JetButton,
    JetSecondaryButton,
    JetDangerButton,
    DialogInvoiceLine,
    TextField,
    Multiselect,
  },
  props: {},
  data() {
    return {
      // tab_idx: 1,
      //   clinics: [],
      //   doctors: [],
      patients: [],
      drugs: [],
      errors: [],
      form: this.$inertia.form({
        // doctor_id: "",
        patient: "",
        dateTimeIssued: new Date().toISOString().slice(0, 16),
        prescriptionLines: [],
      }),
    };
  },
  methods: {
    AddItem: function () {
      this.form.prescriptionLines.push({
        drug: "",
        dose: "",
        time: "",
        notes: "",
      });
      //   this.$nextTick(() => {
      //     this.$refs.dlg1.ShowDialog();
      //   });
    },
    nameWithId: function ({ id, name }) {
      return id + " - " + name;
    },
    DeleteItem: function (idx) {
      this.form.prescriptionLines.splice(idx, 1);
    },
    // EditItem: function (item, idx) {
    //   this.addingNewLine = false;
    //   if (!item.discount) item.discount = { amount: 0, rate: 0 };
    //   this.currentItem = item;
    //   this.currentItemIdx = idx;
    //   this.$nextTick(() => {
    //     this.$refs.dlg1.ShowDialog();
    //   });
    //   this.RecalculateTax();
    // },
    // onClose: function () {
    //   //            this.currentItem.description = this.currentItem.custom_desc;
    //   //            this.currentItem.description =
    //   //                this.$page.props.locale == "ar"
    //   //                    ? this.currentItem.item.descriptionSecondaryLang
    //   //                    : this.currentItem.item.descriptionPrimaryLang;

    //   this.currentItem.itemType = this.currentItem.item.codeTypeName;
    //   this.currentItem.itemCode = this.currentItem.item.itemCode;
    //   this.currentItem.unitType = this.currentItem.unit.code;
    //   this.currentItem.internalCode = this.currentItem.item.Id.toString();
    //   var temp = this.currentItem.unitValue;
    //   this.currentItem.unitValue = {};
    //   this.currentItem.unitValue.currencySold = temp.currencySold;
    //   this.currentItem.unitValue.currencyExchangeRate =
    //     temp.currencyExchangeRate;
    //   this.currentItem.unitValue.amountEGP = temp.amountEGP;
    //   this.currentItem.unitValue.amountSold = temp.amountSold;
    //   this.currentItem.taxableItems = this.currentItem.taxItems.map(function (
    //     taxitem
    //   ) {
    //     var obj = {};
    //     obj.taxType = taxitem.taxType.Code;
    //     obj.amount = taxitem.value;
    //     obj.subType = taxitem.taxSubtype.Code;
    //     obj.rate = taxitem.percentage;
    //     return obj;
    //   });
    //   //delete this.currentItem.item;
    //   if (this.addingNewLine) this.form.invoiceLines.push(this.currentItem);
    //   else this.form.invoiceLines[this.currentItemIdx] = this.currentItem;
    //   this.addingNewLine = false;
    //   this.RecalculateTax();
    // },
    onCancel: function () {
      window.history.back();
    },
    onSave: function () {
      axios
        .post(route("prescriptions.store"), this.form)
        .then((response) => {
          this.$store.dispatch("setSuccessFlashMessage", true);
          this.processing = false;
          this.form.reset();
          this.form.processing = false;
          setTimeout(() => {
            window.location.reload();
          }, 500);
        })
        .catch((error) => {
          this.form.processing = false;
          this.$page.props.errors = error.response.data.errors;
          this.errors = error.response.data.errors; //.password[0];
          //this.$refs.password.focus()
        });
    },
    // getTaxStr: function (taxitem) {
    //   if (taxitem.taxType.Code)
    //     return taxitem.taxType.Code + "(" + taxitem.taxSubtype.Code + ")";
    //   return taxitem.taxType + "(" + taxitem.subType + ")";
    // },
    // getDocumentTitle: function () {
    //   return this.form.documentType == "I"
    //     ? this.__("Invoice Summary")
    //     : this.form.documentType == "C"
    //     ? this.__("Credit Note Summary")
    //     : this.form.documentType == "D"
    //     ? this.__("Debit Note Summary")
    //     : this.__("Error!!");
    // },
    // nameWithId({ name, receiver_id, Id }) {
    //   return Id + " - " + receiver_id + " - " + name;
    // },
    // updateValues() {
    //   this.RecalculateTax();
    // },
  },
  created: function created() {
    this.AddItem();
    axios
      .get(route("patient.all"))
      .then((response) => {
        this.patients = response.data;
      })
      .catch((error) => {});
    axios
      .get(route("drug.all"))
      .then((response) => {
        this.drugs = response.data;
      })
      .catch((error) => {});
  },
};
</script>
