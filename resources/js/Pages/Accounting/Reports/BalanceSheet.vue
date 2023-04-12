<template>
    <app-layout>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
export default {
    components: {
        AppLayout,
    },
    props: {
        statistics: Object,
        firstDayOfLastWeek: String,
        today: String,
        firstDayOfTheCurrentMonth: String,
        lastDayOfTheCurrentMonth: String,
        firstDayOfTheLastMonth: String,
        lastDayOfTheLastMonth: String,
        lastWeekData: Array,
        lastMonthData: Array,
        monthlyData: Array,
    },
};
</script>

<style>
.Valid {
    background-color: #0e9f6e;
}
.processing {
    background-color: #0e9f6e;
}
.Review {
    background-color: #0e6e9f;
}
.Canceled {
    background-color: #9f0e6e;
}
.Invalid {
    background-color: #f05252;
}
.rejected {
    background-color: #f05252;
}
</style>
