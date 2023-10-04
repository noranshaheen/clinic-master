<template>
  <app-layout>
    <div class="py-0">
        <div class="mx-auto sm:px-6 lg:px-8">
        <h2 class="py-3 px-1">{{ __("Items Balance") }}</h2>
        <div class="bg-white shadow-xl sm:rounded-lg px-4 pb-4 pt-4">
          <div class="grid lg:grid-cols-2 gap-4 sm:grid-cols-1 h-1/2 overflow">
            <!-- select clinic -->
            <div class="">
              <jet-label :value="__('Clinic')" />
              <select v-model="form.clinic
                " class="mt-1 w-full border-slate-300 rounded-md" @change="getWarehouses(form.clinic)">
                <option v-for="clinic in clinics" :value="clinic" :key="clinic.id">
                  {{ clinic.name }}
                </option>
              </select>
            </div>
            <!-- select inventory -->
            <div class="">
              <jet-label :value="__('Warehouses')" />
              <select v-model="form.warehouse" class="mt-1 w-full border-slate-300 
                            rounded-md">
                <option v-for="warehouse in warehouses" :value="warehouse" :key="warehouse.id">
                  {{ warehouse.name }}
                </option>
              </select>
            </div>
            <!-- determine date -->
            <TextField v-model="form.startDate" itemType="date" :itemLabel="__('Start Date')" />
            <TextField v-model="form.endDate" itemType="date" :itemLabel="__('End Date')" />
          </div>
          <!-- search button -->
          <div class="flex items-center justify-start mt-4 flex-wrap">
            <jet-button @click="onCheckBalance()">
              {{ __("Search") }}
            </jet-button>
            <jet-button @click="onExportInventoryBalance()">
              {{ __("Export") }}
            </jet-button>
          </div>
        </div>
      </div>
    </div>
    <div class="mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

        <div class="result my-5 overflow-x-auto w-full" v-if="Object.keys(items).length > 0">
          <table class="w-11/12 mx-auto max-w-4xl lg:max-w-full">
            <thead class="text-center bg-gray-300">
            
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Item") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Inbound") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                {{ __("Outbound") }}
              </th>
              <th class="bg-[#f8f9fa] p-3 border border-[#d4d4d4]">
                  {{ __("Quantity") }}
                </th>
            </thead>
            <tbody class="text-center border border-[#d4d4d4]">

              <tr class="border border-[#d4d4d4]" v-for="item in items">
                <td class="border border-[#d4d4d4]">
                  {{ item[0].item.name }}
                </td>
                <td class="p-2 border border-[#d4d4d4]">
                  {{getIns(item)}}
                </td>
                <td class="p-2 border border-[#d4d4d4]">
                  {{getOuts(item)}}
                </td>
                <td class="border border-[#d4d4d4]">
                  {{ getTotalBalance(item) }}
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
      items: [],
      groupedItems: {},
      warehouses: [],
      mateched_clinics: [],
      form: {
        clinic: "",
        warehouse: "",
        startDate: new Date().toISOString().slice(0, 10),
        endDate: new Date().toISOString().slice(0, 10),
      },
    };
  },
  methods: {
    getWarehouses(clinic) {
      axios
        .get(route('inventory.all', clinic.id))
        .then((response) => {
          // console.log(response.data);
          this.warehouses = response.data;
        })
    },
    getIns(item) {
      console.log(item)
      var quantity = 0;
      item.forEach((element) => {
        if(element.type == 'in')
        quantity += element.quantity;
      })
      return quantity;
    },
    getOuts(item) {
      var quantity = 0;
      item.forEach((element) => {
        if(element.type == 'out')
        quantity += element.quantity;
      })
      return quantity;
    },
    getTotalBalance(item) {
      var quantity = 0;
      item.forEach((element) => {
        quantity += element.quantity;
      })
      return quantity;
    },
    onCheckBalance: function () {
      axios
        .post(route('inventory.search.balance'), this.form)
        .then((response) => {
          this.items = response.data;
          console.log(response.data);
          
        })
    },
    onExportInventoryBalance() {
        axios({
                url: route("inventory.export.balance"),
                method: "POST",
                data: this.form,
                responseType: "blob",
            }).then((response) => {
                const url = window.URL.createObjectURL(
                    new Blob([response.data])
                );
                const link = document.createElement("a");
                link.href = url;
                link.setAttribute("download", "InventoryBalanceReport.xlsx");
                document.body.appendChild(link);
                link.click();
            });
    },
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
        this.clinics = response.data;
        // var all = {
        //   "id": -1,
        //   "name": "All"
        // };
        // this.clinics.unshift(all);
      })
  },
};
</script>
  
<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>