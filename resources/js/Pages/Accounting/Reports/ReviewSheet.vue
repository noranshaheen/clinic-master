<template>
    <app-layout>
        <div class="w-full flex justify-center">
            <div class="grid grid-cols-3 divide-x divide-y w-1/2 bg-white p-4 striped">
                <div class="p-2 bg-gray-400">{{ __('Description') }}</div>
                <div class="p-2 bg-gray-400">{{ __('Debit Amount') }}</div>
                <div class="p-2 bg-gray-400">{{ __('Credit Amount') }}</div>
                <template v-for="(item,key,idx) in items" :key="item.id">
                    <div class="p-2" :class="idx%2 == 1 ? 'dark-row' : ''">{{ item.name }}({{item.id}})</div>
                    <div class="p-2" :class="idx%2 == 1 ? 'dark-row' : ''">{{ item.debit_amount }}</div>
                    <div class="p-2" :class="idx%2 == 1 ? 'dark-row' : ''">{{ item.credit_amount }}</div>
                </template>
                <div class="p-2 bg-gray-400">{{ __('Total') }}</div>
                <div class="p-2 bg-gray-400">{{ total_debit }}</div>
                <div class="p-2 bg-gray-400">{{ total_credit }}</div>
                <div class="p-2 bg-gray-200">{{ __('Net Profit') }}</div>
                <div class="p-2 bg-green-50 col-span-2 flex justify-center">{{ net_profit.toFixed(2) }}</div>
            </div>
        </div>

    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
export default {
    components: {
        AppLayout,
    },
    props: {
        items: Array,
        total_credit: Number,
        total_debit: Number,
        net_profit: Number,
    },
};
</script>

<style>
.dark-row {
    @apply bg-gray-100
  }
</style>
