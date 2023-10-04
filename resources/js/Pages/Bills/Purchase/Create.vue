<template>
    <app-layout>
        <NewItemDialog ref="dlg1" />
        <!-- <AddLineDialog ref="dlg2" @save="onAddLine" /> -->
        <!-- <EditLineDialog :item=item :idx=idx ref="dlg3" @save="onEditLine" /> -->

        <div class="lg:py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <jet-validation-errors class="mb-4" />
                <h2 class="py-3 px-1">{{ __("Add Bill") }}</h2>
                <div class="bg-white shadow-xl sm:rounded-lg px-4 pb-4 pt-0">
                    <div class="grid lg:grid-cols-2 gap-4 sm:grid-cols-1 h-1/2">
                        <!-- date -->
                        <div class="">
                            <TextField v-model="form.date" itemType="date" :itemLabel="__('Date')" />
                        </div>
                        <!-- clinic -->
                        <div class="">
                            <jet-label :value="__('Clinic')" />
                            <select v-model="form.clinic_id
                            " class="mt-1 w-full border-slate-300 rounded-md"
                                @change="getWarehouses(form.clinic_id)">
                                <option v-for="clinic in clinics" :value="clinic.id" :key="clinic.id">
                                    {{ clinic.name }}
                                </option>
                            </select>
                        </div>
                        <!-- warehouse -->
                        <div class="">
                            <jet-label :value="__('Warehouses')" />
                            <select v-model="form.warehouse" class="mt-1 w-full border-slate-300 
                            rounded-md">
                                <option v-for="warehouse in warehouses" :value="warehouse" :key="warehouse.id">
                                    {{ warehouse.name }}
                                </option>
                            </select>
                        </div>
                        <!-- stock -->
                        <div class="">
                            <jet-label :value="__('Stock')" />
                            <select v-model="form.stock" class="mt-1 w-full border-slate-300 
                            rounded-md">
                                <option v-for="stock in form.warehouse.stocks" :value="stock" :key="stock.id">
                                    {{ stock.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="w-full">
                            <div class="result my-5 w-full">
                                <!-- mobile screen -->
                                <table class="w-full mx-auto md:hidden max-w-4xl lg:max-w-full">
                                    <thead class="text-center bg-gray-300">
                                        <th class="bg-[#f8f9fa] p-1 border border-[#eceeef] w-3/12">
                                            {{ __('Item') }}
                                            <button @click="addNewItemDialog()" class="cursor-pointer ml-4">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </th>
                                        <th class="bg-[#f8f9fa] p-1 border border-[#eceeef]">{{ __('Quantity') }}</th>
                                        <th class="bg-[#f8f9fa] p-1 border border-[#eceeef]">{{ __('Total') }}</th>
                                        <th class="bg-[#f8f9fa] p-1 border border-[#eceeef]">{{ __('Action') }}</th>
                                    </thead>
                                    <tbody class="text-center border border-[#eceeef] w-5/12">
                                        <tr v-for="(billLine, idx) in form.billLines" class="border border-[#eceeef]">
                                            <td class="p-1 border border-[#eceeef]">
                                                <p>{{ billLine.item.name }}</p>
                                            </td>
                                            <td class="p-1 border border-[#eceeef]">
                                                <p>{{ billLine.quantity }}</p>
                                            </td>
                                            <td class="p-1 border border-[#eceeef]">
                                                <p>{{ billLine.total }}</p>
                                            </td>
                                            <td class="p-1 border border-[#eceeef]">
                                                <div>
                                                    <jet-secondary-button class="ms-2" @click="editLineDialog(idx)">
                                                        <i class="fa fa-edit"></i>
                                                    </jet-secondary-button>
                                                    <jet-danger-button class="ms-2" @click="deleteLine(idx)">
                                                        <i class="fa fa-trash"></i>
                                                    </jet-danger-button>
                                                </div>

                                            </td>
                                        </tr>
                                    </tbody>

                                </table>

                                <!-- medium screen -->
                                <table class="mx-auto hidden md:block w-full">
                                    <thead class="w-full text-center bg-gray-300">
                                        <th class="bg-[#f8f9fa] p-1 border border-[#eceeef] w-3/12">
                                            {{ __('Item') }}
                                            <button @click="addNewItemDialog()" class="cursor-pointer ml-4">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </th>
                                        <th class="bg-[#f8f9fa] p-1 border border-[#eceeef] w-3/12">{{ __('Unit') }}</th>
                                        <th class="bg-[#f8f9fa] p-1 border border-[#eceeef]">{{ __('Unit Price')}}</th>
                                        <th class="bg-[#f8f9fa] p-1 border border-[#eceeef]">{{ __('Quantity') }}</th>
                                        <th class="bg-[#f8f9fa] p-1 border border-[#eceeef]">{{ __('Total Price') }}</th>
                                        <th class="bg-[#f8f9fa] p-1 border border-[#eceeef]">{{ __('Action') }}</th>
                                    </thead>
                                    <tbody class="w-full text-center border border-[#eceeef]">
                                        <tr v-for="(billLine, idx) in form.billLines" class="border border-[#eceeef]">
                                            <td class="p-1 border border-[#eceeef]">
                                                <multiselect v-model="billLine.item" label="name" :options="items"
                                                    placeholder="Select Item" :searchable="true" />
                                            </td>
                                            <td class="p-1 border border-[#eceeef]">
                                                <multiselect v-model="billLine.unit" :options="units" label="desc_en"
                                                    placeholder="unit" :searchable="true" />
                                            </td>
                                            <td class="p-1 border border-[#eceeef]">
                                                <TextField v-model="billLine.unitPrice" itemType="number" />
                                            </td>
                                            <td class="p-1 border border-[#eceeef]">
                                                <TextField v-model="billLine.quantity" itemType="number" />
                                            </td>
                                            <td class="p-1 border border-[#eceeef]">
                                                <TextField v-model="billLine.total" itemType="number" />
                                            </td>
                                            <td class="p-1 border border-[#eceeef]">
                                                <jet-danger-button class="ms-2" @click="deleteLine(idx)">
                                                    {{ __("Delete") }}
                                                </jet-danger-button>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>

                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <!-- mobile screen -->
                                <jet-button class="ms-2 md:hidden" @click="addNewILineDialog()">
                                    {{ __("Add") }}
                                </jet-button>
                                <!-- medium screen -->
                                <jet-button class="ms-2 hidden md:inline-block" @click="AddItem()">
                                    {{ __("Add") }}
                                </jet-button>
                            </div>
                            <h3 class="capitalize py-2 text-gray-600 text-lg font-bold">
                                {{ __('Invoice Total') + " :" }}
                                <span>
                                    {{ totalAmount() }}
                                </span>
                            </h3>
                        </div>
                        <div class="flex items-center justify-end mt-20">
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
import axios from 'axios';
import NewItemDialog from "@/Pages/Items/Edit.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
// import AddLineDialog from "./AddLine.vue";
// import EditLineDialog from "./EditLine.vue";

export default {
    components: {
        AppLayout,
        NewItemDialog,
        JetLabel,
        JetButton,
        JetSecondaryButton,
        JetDangerButton,
        DialogInvoiceLine,
        TextField,
        Multiselect,
        JetValidationErrors
        // AddLineDialog,
        // EditLineDialog
    },
    props: {
    },
    data() {
        return {
            item: "",
            idx: "",
            doctors: [],
            clinics: [],
            items: [],
            units: [],
            warehouses:[],
            errors: [],
            form: this.$inertia.form({
                billLines: [],
                doctor: "",
                clinic_id: "",
                date: "",
                warehouse: "",
                stock: "",
                billTotalAmount: 0
            }),
        };
    },
    methods: {
        getWarehouses(clinic_id) {
            axios
                .get(route('inventory.all', clinic_id))
                .then((response) => {
                    // console.log(response.data);
                    this.warehouses = response.data;
                })
        },
        AddItem: function () {
            // console.log("add new item")
            this.form.billLines.push({
                item: "",
                unit: "",
                unitPrice: "",
                quantity: 0,
                total: 0
            });
        },
        addNewItemDialog() {
            this.$refs.dlg1.ShowDialog();
        },
        addNewILineDialog() {
            this.$nextTick(() => {
                this.$refs.dlg2.ShowDialog();
            })
        },
        editLineDialog(idx) {
            this.item = JSON.parse(JSON.stringify(this.form.billLines[idx]));
            // this.item = this.form.billLines[idx];
            this.idx = idx;
            // console.log(this.idx);
            this.$nextTick(() => {
                this.$refs.dlg3.ShowDialog();
            })
        },
        onAddLine(item) {
            this.form.billLines.push({
                item: item.item,
                unit: item.unit,
                unitPrice: item.unitPrice,
                quantity: item.quantity,
                total: item.total
            });
        },
        onEditLine(item, idx) {
            this.form.billLines[idx] = item;
            // this.form.billLines.splice(idx, 1,item);
            console.log(this.form.billLines);
            // console.log(idx);
        },
        deleteLine: function (idx) {
            this.form.billLines.splice(idx, 1);
        },

        onCancel: function () {
            window.location.reload();
        },
        totalAmount() {
            var total = 0;
            if (this.form.billLines.length != 0) {
                this.form.billLines.forEach(line => {
                    total += Number(line.total);
                });
                this.form.billTotalAmount = total;
                return total;
            }
        },
        onSave: function () {
            axios
                .post(route("bills.purchase.store"), this.form)
                .then((response) => {
                    this.processing = false;
                    this.$nextTick(() => this.$emit("dataUpdated"));
                    this.form.reset();
                    this.form.processing = false;
                    this.tab_idx = 1;
                })
                .catch((error) => {
                    this.form.processing = false;
                    this.$page.props.errors = error.response.data.errors;
                    // this.errors = error.response.data.errors; //.password[0];
                    //this.$refs.password.focus()
                });
        },
    },
    created: function created() {
        axios
            .get(route('doctor.all'))
            .then((response) => {
                this.doctors = response.data;
            })
        axios
            .get(route('clinic.all'))
            .then((response) => {
                this.clinics = response.data;
            })
        axios
            .get((route('items.index')))
            .then((response) => {
                var tmp = response.data;
                this.items = tmp.filter((item) => item.storable == 1);
                // console.log(this.items);
            })
        axios
            .get("/json/UnitTypes.json")
            .then((response) => {
                this.units = response.data;
            })
            .catch((error) => { });

    },
};
</script>
