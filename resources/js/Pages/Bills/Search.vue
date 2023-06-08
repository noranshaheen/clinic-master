<template>
  <app-layout>
    <div class="py-4">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="card-title flex flex-col lg:flex-row justify-between p-3">
          <div class="flex items-center ms-0 mb-4 border-b border-gray-200">
            <!-- <jet-button @click="tab_idx = 1" :disabled="tab_idx == 1" :isRounded="false">
              {{ __("Expenses Search") }}
            </jet-button>
            <jet-button @click="tab_idx = 2" :disabled="tab_idx == 2" :isRounded="false">
              {{ __("Income Search") }}
            </jet-button> -->
          </div>
        </div>
        <!--First Tab-->
        <div class="bg-white shadow-xl sm:rounded-lg px-4 pb-4 pt-4">
          <div>
            <div class="grid lg:grid-cols-2 gap-4 sm:grid-cols-1 h-1/2 overflow">
              <div>
                <jet-label :value="__('Clinic')" />
                <multiselect v-model="form.clinic" label="name" :options="clinics" placeholder="Select branch" />
              </div>
              <div>
                <jet-label :value="__('Doctor')" />
                <multiselect v-model="form.doctor" label="name" :options="doctors" placeholder="Select customer" />
              </div>
              <TextField v-model="form.startDate" itemType="date" :itemLabel="__('Start Date')" />
              <TextField v-model="form.endDate" itemType="date" :itemLabel="__('End Date')" />
            </div>
            <div class="flex items-center justify-start mt-4">
              <jet-button @click="onSearchExpenses()">
                {{ __("Expenses") }}
              </jet-button>
              <jet-button @click="onSearchIncomes()">
                {{ __("Incomes") }}
              </jet-button>
            </div>


            <!-- <jet-secondary-button class="ms-2" @click="onApprove()">
              {{ __("Approve Selected") }}
            </jet-secondary-button>

            <jet-secondary-button class="ms-2" @click="onDelete()">
              {{ __("Delete Selected") }}
            </jet-secondary-button>

            <jet-secondary-button class="ms-2" @click="onApproveAll()">
              {{ __("Approve All") }}
            </jet-secondary-button>

            <jet-secondary-button class="ms-2" @click="onDeleteAll()">
              {{ __("Delete All") }}
            </jet-secondary-button>
            <jet-secondary-button class="ms-2" @click="onFixDate()">
              {{ __("Fix Date") }}
            </jet-secondary-button> -->
            <!--
            <jet-secondary-button class="ms-2" @click="onDelay(1)">
              {{ __("Delay Selected 1 Day") }}
            </jet-secondary-button>
            <jet-secondary-button class="ms-2" @click="onDelay(2)">
              {{ __("Delay Selected 2 Day") }}
            </jet-secondary-button>
            <jet-secondary-button class="ms-2" @click="onDelay(3)">
              {{ __("Delay Selected 3 Day") }}
            </jet-secondary-button>
            -->
          </div>
        </div>
      </div>
    </div>
    <div class="mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="result my-5 overflow-x-auto w-full" v-if="expenses.length > 0">
          <table class="w-11/12 mx-auto max-w-4xl lg:max-w-full">
            <thead class="text-center bg-gray-300">
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Date") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("ُExpenses Amount") }}
              </th>
            </thead>
            <tbody class="text-center border border-[#d4d4d4]">
              <tr class="border border-[#d4d4d4]" v-for="row in expenses" :key="row.id">
                <td class="p-2 border border-[#d4d4d4]">
                  {{ new Date(row.date).toLocaleDateString() }}
                </td>
                <td class="p-2 border border-[#d4d4d4]">
                  {{ row.totalAmount }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-else>
          <p class="text-center text-red-600 my-5">
            <i class="fa fa-exclamation-circle mr-1"></i>
            {{ __("No Records Were Found") }}
          </p>
        </div>
      </div>
    </div>
    <!-- income -->
    <div class="mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="result my-5 overflow-x-auto w-full" v-if="incomes.length > 0">
          <table class="w-11/12 mx-auto max-w-4xl lg:max-w-full">
            <thead class="text-center bg-gray-300">
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Date") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Incomes Amount") }}
              </th>
            </thead>
            <tbody class="text-center border border-[#d4d4d4]">
              <tr class="border border-[#d4d4d4]" v-for="row in incomes" :key="row.id">
                <td class="p-2 border border-[#d4d4d4]">
                  {{ new Date(row.dateTimeIssued).toLocaleDateString() }}
                </td>
                <td class="p-2 border border-[#d4d4d4]">
                  {{ getTotalLineIncome(row) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-else>
          <p class="text-center text-red-600 my-5">
            <i class="fa fa-exclamation-circle mr-1"></i>
            {{ __("No Records Were Found") }}
          </p>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import TextField from "@/UI/TextField.vue";
import Multiselect from "@suadelabs/vue3-multiselect";
import DialogInvoiceLine from "@/Pages/Invoices/EditLine.vue";
import axios from "axios";
import swal from "sweetalert";

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
      tab_idx: 1,
      clinics: [],
      doctors: [],
      // selected_status: null,
      expenses: [],
      incomes: [],
      mateched_clinics: [],
      form: {
        clinic: "",
        doctor: "",
        startDate: new Date().toISOString().slice(0, 10),
        endDate: new Date().toISOString().slice(0, 10),
      },
    };
  },
  methods: {
    onSearchExpenses: function () {
      axios
        .post(route("bills.expenses.searchData"), this.form)
        .then((response) => {
          this.expenses = response.data;
          console.log(response.data);
        })
        .catch((error) => { });
    },
    onSearchIncomes: function () {
      axios
        .post(route("bills.income.searchData"), this.form)
        .then((response) => {
          this.incomes = response.data;
          console.log(response.data);
        })
        .catch((error) => { });
    },
    getTotalLineIncome(line) {
      var total = Number(line.appointment.payment.detection_fees);
      line.prescription_items.forEach(element => {
        if (element.service_fees !== null) {
          total += Number(element.service_fees);
          // console.log(el.service_fees);
        }
      });
      return total;
    },
    // checkAll() {
    //   this.$nextTick(() => {
    //     this.data.forEach((row) => {
    //       row.selected = true;
    //     });
    //   });
    // },
    // onApprove() {
    //   var temp = this.data.filter((row) => row.selected);
    //   if (temp.length == 0) {
    //     swal(this.__("Please select at least one invoice!"), {
    //       icon: "error",
    //     });
    //     return;
    //   }
    //   swal({
    //     title: this.__("Are you sure?"),
    //     text: this.__("Once approved it will be sent to ETA"),
    //     icon: "warning",
    //     buttons: true,
    //     dangerMode: true,
    //   }).then((willApprove) => {
    //     if (willApprove) {
    //       axios
    //         .post(route("eta.invoices.approve"), {
    //           Id: this.data
    //             .filter((row) => row.selected)
    //             .map((row) => row.InvID),
    //         })
    //         .then((response) => {
    //           swal(this.__("Invoices has been approved!"), {
    //             icon: "success",
    //           }).then(() => {
    //             this.onSearch();
    //           });
    //         })
    //         .catch((error) => {
    //           swal(error.response.data, {
    //             icon: "error",
    //           });
    //         });
    //     }
    //   });
    // },
    // onDelay(p_days) {
    //   var temp = this.data.filter((row) => row.selected);
    //   if (temp.length == 0) {
    //     swal(this.__("Please select at least one invoice!"), {
    //       icon: "error",
    //     });
    //     return;
    //   }
    //   swal({
    //     title: this.__("Are you sure?"),
    //     text: this.__("Once clicked ok  the selected invoices will be delayed"),
    //     icon: "warning",
    //     buttons: true,
    //     dangerMode: true,
    //   }).then((willApprove) => {
    //     if (willApprove) {
    //       axios
    //         .post(route("eta.invoices.delay"), {
    //           Id: this.data
    //             .filter((row) => row.selected)
    //             .map((row) => row.InvID),
    //           days: p_days,
    //         })
    //         .then((response) => {
    //           swal(this.__("Invoices has been delayed!"), {
    //             icon: "success",
    //           }).then(() => {
    //             this.onSearch();
    //           });
    //         })
    //         .catch((error) => {
    //           swal(error.response.data, {
    //             icon: "error",
    //           });
    //         });
    //     }
    //   });
    // },
    // onDelete() {
    //   var temp = this.data.filter((row) => row.selected);
    //   if (temp.length == 0) {
    //     swal(this.__("Please select at least one invoice!"), {
    //       icon: "error",
    //     });
    //     return;
    //   }
    //   swal({
    //     title: this.__("Are you sure?"),
    //     text: this.__("Once clicked ok  the selected invoices will be deleted"),
    //     icon: "warning",
    //     buttons: true,
    //     dangerMode: true,
    //   }).then((willApprove) => {
    //     if (willApprove) {
    //       axios
    //         .post(route("eta.invoices.delete"), {
    //           Id: this.data
    //             .filter((row) => row.selected)
    //             .map((row) => row.InvID),
    //         })
    //         .then((response) => {
    //           swal(this.__("Invoices has been deleted!"), {
    //             icon: "success",
    //           }).then(() => {
    //             this.onSearch();
    //           });
    //         })
    //         .catch((error) => {
    //           swal(error.response.data, {
    //             icon: "error",
    //           });
    //         });
    //     }
    //   });
    // },
    // onApproveAll() {
    //   this.data.forEach((row) => {
    //     row.selected = true;
    //   });
    //   swal({
    //     title: this.__("Are you sure?"),
    //     text: this.__("Once approved it will be sent to ETA"),
    //     icon: "warning",
    //     buttons: true,
    //     dangerMode: true,
    //   }).then((willApprove) => {
    //     if (willApprove) {
    //       axios
    //         .post(route("eta.invoices.approve"), {
    //           Id: this.data
    //             .filter((row) => row.selected)
    //             .map((row) => row.InvID),
    //         })
    //         .then((response) => {
    //           swal(this.__("Invoices has been approved!"), {
    //             icon: "success",
    //           }).then(() => {
    //             this.onSearch();
    //           });
    //         })
    //         .catch((error) => {
    //           swal(error.response.data, {
    //             icon: "error",
    //           });
    //         });
    //     }
    //   });
    // },
    // onFixDate() {
    //   var temp = this.data.filter((row) => row.selected);
    //   if (temp.length == 0) {
    //     swal(this.__("Please select at least one invoice!"), {
    //       icon: "error",
    //     });
    //     return;
    //   }
    //   swal({
    //     title: this.__("Are you sure?"),
    //     text: this.__("Once clicked ok  the selected invoices' date will be set to current day"),
    //     icon: "warning",
    //     buttons: true,
    //     dangerMode: true,
    //   }).then((willApprove) => {
    //     if (willApprove) {
    //       axios
    //         .post(route("eta.invoices.fixDate"), {
    //           Id: this.data
    //             .filter((row) => row.selected)
    //             .map((row) => row.InvID),
    //         })
    //         .then((response) => {
    //           swal(this.__("Invoices' date has been fixed!"), {
    //             icon: "success",
    //           }).then(() => {
    //             this.onSearch();
    //           });
    //         })
    //         .catch((error) => {
    //           swal(error.response.data, {
    //             icon: "error",
    //           });
    //         });
    //     }
    //   });
    // },
    // onDeleteAll() {
    //   this.data.forEach((row) => {
    //     row.selected = true;
    //   });
    //   swal({
    //     title: this.__("Are you sure?"),
    //     text: this.__("Once clicked ok all invoices will be deleted"),
    //     icon: "warning",
    //     buttons: true,
    //     dangerMode: true,
    //   }).then((willApprove) => {
    //     if (willApprove) {
    //       axios
    //         .post(route("eta.invoices.delete"), {
    //           Id: this.data.filter((row) => row.selected).map((row) => row.InvID),
    //         })
    //         .then((response) => {
    //           swal(this.__("Invoices has been deleted!"), {
    //             icon: "success",
    //           }).then(() => {
    //             this.onSearch();
    //           });
    //         })
    //         .catch((error) => {
    //           swal(error.response.data, {
    //             icon: "error",
    //           });
    //         });
    //     }
    //   });
    // },
  },
  created: function created() {
    axios
      .get(route('doctor.all'))
      .then((response) => {
        var all = {
          "id": -1,
          "name": "All"
        };
        this.doctors = response.data;
        this.doctors.unshift(all);
      })
    axios
      .get(route('clinic.all'))
      .then((response) => {
        var all = {
          "id": -1,
          "name": "All"
        };
        this.clinics = response.data;
        this.clinics.unshift(all);
      })
  },
};
</script>

<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>