import{A as s}from"./AppLayout-bf2c4329.js";import n from"./charts-8556a955.js";import p from"./StatisticsTable-240d9092.js";import{_ as l}from"./_plugin-vue_export-helper-c27b6911.js";import{c,w as f,r as a,o as _,b as o}from"./app-5577a803.js";import"./Edit-3518c8d0.js";import"./ActionMessage-c078ab58.js";import"./ActionSection-503f6cc4.js";import"./SectionTitle-75c86d6b.js";import"./Button-caddf70d.js";import"./ConfirmationModal-747d8d1a.js";import"./Modal-5b92d53d.js";import"./DangerButton-0ca7bbd2.js";import"./DialogModal-08c723b0.js";import"./FormSection-f05163be.js";import"./Input-2cb00575.js";import"./Checkbox-0b804630.js";import"./InputError-1ce94fe9.js";import"./Label-715dcd10.js";import"./SecondaryButton-3445fa1d.js";import"./SectionBorder-30338fa4.js";import"./ValidationErrors-deb0d81a.js";/* empty css            */import"./Edit-0ce9ec78.js";import"./Edit-59e1cea4.js";import"./Edit-b100ce49.js";import"./Edit-a668fbc8.js";import"./Edit-8c1a7f79.js";import"./vue3-multiselect.umd.min-7dc826ba.js";import"./TextField-f2f734f3.js";import"./Reservation-3f4df2b7.js";import"./Edit-de74654e.js";import"./Edit-ca5432cf.js";import"./Edit-7a1531ea.js";/* empty css                                                                  */import"./Load-69126cbc.js";import"./Load-60ee8871.js";import"./Edit-06b7cecc.js";import"./Upload-74253f6c.js";import"./Upload-272d6997.js";import"./Settings-4793b3a5.js";import"./Settings-36898752.js";import"./Upload-4d2df8c2.js";import"./Request-20c79d13.js";import"./Add-e36b326b.js";import"./Load-13d24c7d.js";import"./Upload-28c6b9dc.js";import"./Load-3369b54b.js";import"./sweetalert.min-ea747d9b.js";import"./ItemsMap-6b0c7b7d.js";import"./Upload-bd0ab3e3.js";import"./ItemsMap-58f762b0.js";import"./RequestEx-34c826cd.js";const h={components:{AppLayout:s,charts:n,StatisticsTable:p},props:{statistics:Object,firstDayOfLastWeek:String,today:String,firstDayOfTheCurrentMonth:String,lastDayOfTheCurrentMonth:String,firstDayOfTheLastMonth:String,lastDayOfTheLastMonth:String,lastWeekData:Array,lastMonthData:Array,monthlyData:Array}};function y(r,d,t,u,D,M){const i=a("statistics-table"),m=a("charts"),e=a("app-layout");return _(),c(e,null,{default:f(()=>[o(i,{title:r.__("Last 7 days Invoices Statistics"),from:t.firstDayOfLastWeek,to:t.today,data:t.lastWeekData},null,8,["title","from","to","data"]),o(i,{title:r.__("Monthly Invoices Statistics"),from:t.firstDayOfTheCurrentMonth,to:t.lastDayOfTheCurrentMonth,data:t.monthlyData},null,8,["title","from","to","data"]),o(i,{title:r.__("Last Month Invoices Statistics"),from:t.firstDayOfTheLastMonth,to:t.lastDayOfTheLastMonth,data:t.lastMonthData},null,8,["title","from","to","data"]),o(m)]),_:1})}const Mt=l(h,[["render",y]]);export{Mt as default};
