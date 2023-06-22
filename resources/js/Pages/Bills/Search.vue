<template>
  <app-layout>
    <div class="py-4">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg px-4 pb-4 pt-4">
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
            <jet-button @click="onCheckBalance()">
              {{ __("Consumable Items Balance") }}
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
    <div class="mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="result my-5 overflow-x-auto w-full" v-if="expenses.length > 0">
          <table class="w-11/12 mx-auto max-w-4xl lg:max-w-full">
            <thead class="text-center bg-gray-300">
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Bill Number") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Date") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Clinic") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Doctor") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Expenses Amount") }}
              </th>
            </thead>
            <tbody class="text-center border border-[#d4d4d4]">
              <tr class="border border-[#d4d4d4]" v-for="(row, idx) in expenses" :key="row.id">
                <td class="p-2 border border-[#d4d4d4]">
                  {{ row.id }}
                </td>
                <td class="p-2 border border-[#d4d4d4]">
                  {{ new Date(row.date).toLocaleDateString() }}
                </td>
                <td class="p-2 border border-[#d4d4d4]">
                  {{ row.clinic.name }}
                </td>
                <td class="p-2 border border-[#d4d4d4]">
                  {{ row.doctor.name }}
                </td>
                <td class="p-2 border border-[#d4d4d4]">
                  {{ row.totalAmount }}
                </td>
              </tr>
              <tr class="border border-[#d4d4d4]">
                <td class="p-2 border font-bold border-[#d4d4d4]" colspan="4">
                  {{ __("Total") }}
                </td>
                <td class="p-2 border font-bold border-[#d4d4d4]">
                  {{ totalExpenses() }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- <div v-else>
          <p class="text-center text-red-600 my-5">
            <i class="fa fa-exclamation-circle mr-1"></i>
            {{ __("No Records Were Found") }}
          </p>
        </div> -->
        <div class="result my-5 overflow-x-auto w-full" v-else-if="incomes.length > 0">
          <table class="w-11/12 mx-auto max-w-4xl lg:max-w-full">
            <thead class="text-center bg-gray-300">
              <th class="bg-[#f8f9fa] border border-[#d4d4d4]">
                {{ __("Prescription Number") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Date") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Clinic") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Doctor") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Incomes Amount") }}
              </th>
            </thead>
            <tbody class="text-center border border-[#d4d4d4]">
              <tr class="border border-[#d4d4d4]" v-for="row in incomes" :key="row.id">
                <td class="border border-[#d4d4d4]">
                  {{ row.id }}
                </td>
                <td class="p-2 border border-[#d4d4d4]">
                  {{ new Date(row.dateTimeIssued).toLocaleDateString() }}
                </td>
                <td class="border border-[#d4d4d4]">
                  {{ row.clinic.name }}
                </td>
                <td class="border border-[#d4d4d4]">
                  {{ row.doctor.name }}
                </td>
                <td class="p-2 border border-[#d4d4d4]">
                  {{ getTotalLineIncome(row) }}
                </td>
              </tr>
              <tr>
                <td class="p-2 border font-bold border-[#d4d4d4]" colspan="4">{{ __("Total") }}</td>
                <td class="p-2 border font-bold border-[#d4d4d4]">{{ totalIncomes() }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="result my-5 overflow-x-auto w-full" v-else-if="items.length > 0">
          <table class="w-11/12 mx-auto max-w-4xl lg:max-w-full">
            <thead class="text-center bg-gray-300">
              <!-- <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Clinic") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Doctor") }}
              </th> -->
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Item") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Beginning Balance") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Ending Balance") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Consumed Quantity") }}
              </th>
              <!-- <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Details") }}
              </th> -->
            </thead>
            <tbody class="text-center border border-[#d4d4d4]">
              <tr class="border border-[#d4d4d4]" v-for="row in items" :key="row.id">
                <!-- <td class="border border-[#d4d4d4]">
                  {{ row.bill_details.bill. }}
                </td>
                <td class="border border-[#d4d4d4]">
                  {{ row.spendings.doctor_id }}
                </td> -->
                <td v-if="row.hidden == 0" class="border border-[#d4d4d4]">
                  {{ row.name }}
                </td>
                <td v-if="row.hidden == 0" class="p-2 border border-[#d4d4d4]">
                  {{ beginBalance(row) }}
                </td>
                <td v-if="row.hidden == 0" class="border border-[#d4d4d4]">
                  {{ "-" }}
                  <!-- endBalance(row.spendings) -->
                </td>
                <td v-if="row.hidden == 0" class="border border-[#d4d4d4]">
                  {{ "-" }}
                  <!-- consumedQuantity(row.spendings) -->
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
      items: [],
      // consumed_items:[],
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
          this.incomes = []
          this.items = []
          this.expenses = response.data;
          console.log(response.data);
        })
        .catch((error) => { });
    },
    onSearchIncomes: function () {
      axios
        .post(route("bills.income.searchData"), this.form)
        .then((response) => {
          this.expenses = []
          this.items = []
          this.incomes = response.data;
          console.log(response.data);
        })
        .catch((error) => { });
    },
    onCheckBalance: function () {
      axios
        .post(route('bills.items.balance'), this.form)
        .then((response) => {
          this.expenses = []
          // this.purchased_items = response.data[0];
          // this.consumed_items = response.data[1];
          this.incomes = []
          this.items = response.data;
          console.log(response.data);
        })
    },
    getTotalLineIncome(line) {
      if (line.appointment.payment !== null) {
        var total = Number(line.appointment.payment.detection_fees);
        line.prescription_items.forEach(element => {
          if (element.service_fees !== null) {
            total += Number(element.service_fees);
            // console.log(el.service_fees);
          }
        });
        return total;
      } else {
        return "0"
      }
    },
    totalIncomes() {
      if (this.incomes.length > 0) {
        var total = 0;
        this.incomes.forEach((line) => {
          total += Number(this.getTotalLineIncome(line));
        })
        return total;
      }
    },
    totalExpenses() {
      if (this.expenses.length > 0) {
        var total = 0;
        this.expenses.forEach((line) => {
          total += Number(line.totalAmount)
        })
        return total;
      }
    },
    beginBalance(item) {
      var purchased_quantity = 0;
      var spended_quantity = 0

      if (item.bill_details.length > 0) {
        var temp1 = [];
        item.bill_details.forEach((el) => {
          var billDate = new Date(el.date).toLocaleDateString();
          var startDate = new Date(this.form.startDate).toLocaleDateString();
          if (billDate <= startDate) {
            temp1.push(el);
          }
        })
        console.log("temp1",temp1)
      }
      if (item.spendings.length > 0) {
        var temp2 = [];
        item.spendings.forEach((el) => {
          var spendingDate = new Date(el.date_isseud).toLocaleDateString();
          var startDate = new Date(this.form.startDate).toLocaleDateString();
          if (spendingDate <= startDate) {
            temp2.push(el);
          }
        })
        console.log("temp2",temp2)
      }


      // if (billDetails.length > 0) {
      //   // var temp = billDetails.filter((row) => {
      //   //   var datebill = new Date(row.date).toLocaleDateString();
      //   //   var startdate = new Date(this.form.startDate).toLocaleDateString();
      //   //   return datebill <= startdate;
      //   // });
      //   var temp = [];
      //   billDetails.forEach((el) => {
      //     if (el.bill !== null) {
      //       console.log(el.bill);
      //       var billDate = new Date(el.date).toLocaleDateString();
      //       var startdate = new Date(this.form.startDate).toLocaleDateString();
      //       if (billDate <= startdate) {
      //         temp.push(el);
      //       }
      //     }
      //   })
      //   var startQuantity = 0;
      //   temp.forEach((el) => {
      //     startQuantity += Number(el.quantity)
      //   })
      //   console.log("temp",temp);
      //   console.log("start Quantity", startQuantity);
      //   // console.log(new Date(this.form.startDate).toLocaleDateString(),new Date(billDetails[0].date).toLocaleDateString());
      // }

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