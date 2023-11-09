import{A as k}from"./AppLayout-336b7499.js";import{J as L}from"./Label-c6c7e0c2.js";import{J as w}from"./Button-fce1e67a.js";import{J as V}from"./SecondaryButton-fb7ef34d.js";import{J as E}from"./DangerButton-bf3f8f1f.js";import{T as B}from"./TextField-4dc08153.js";import{M as I}from"./vue3-multiselect.umd.min-89fe1e95.js";import T from"./EditLine-64c486c6.js";import{k as _,c as N,w as h,r as p,o as i,a as t,b as m,f,t as o,d as n,F as u,g,e as b}from"./app-98cccb0d.js";import"./sweetalert.min-9f604034.js";/* empty css                                                                  */import{_ as C}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-7ca2eef9.js";import"./ActionMessage-529841b6.js";import"./ActionSection-14bbef3c.js";import"./SectionTitle-f26ec90c.js";import"./ConfirmationModal-2d2586d4.js";import"./Modal-2ccc6cf7.js";import"./DialogModal-9cb7d35f.js";import"./FormSection-60b88c5f.js";import"./Input-9c9fd5b2.js";import"./Checkbox-7ff4e1d6.js";import"./InputError-48880b4d.js";import"./SectionBorder-a45d0249.js";import"./ValidationErrors-ce3c07bd.js";/* empty css            */import"./Edit-cfad98b4.js";import"./Edit-04381c68.js";import"./Edit-c883850a.js";import"./Edit-663be45d.js";import"./Edit-833659c9.js";import"./Edit-e905c401.js";import"./Edit-fb9e1a40.js";import"./Edit-8b049cff.js";import"./Edit-7210d6e2.js";import"./Edit-9520adfe.js";import"./Load-c81154ca.js";import"./Load-269b27e0.js";import"./Edit-470aa9e5.js";import"./Edit-ae0efa3b.js";import"./Upload-3f7847e9.js";import"./Upload-cab6aca1.js";import"./Upload-4bb109cf.js";import"./Upload-91640e3b.js";import"./Settings-281c0c2c.js";import"./Settings-3a181d36.js";import"./Upload-b3182070.js";import"./Request-264efc19.js";import"./Add-983c5f77.js";import"./Load-b9d12279.js";import"./Upload-0c9409a0.js";import"./Load-c588859c.js";import"./ItemsMap-ac429fa2.js";import"./Upload-69a7afe4.js";import"./ItemsMap-99c5c9fb.js";import"./RequestEx-4f93fb5e.js";const A={components:{AppLayout:k,JetLabel:L,JetButton:w,JetSecondaryButton:V,JetDangerButton:E,DialogInvoiceLine:T,TextField:B,Multiselect:I},props:{},data(){return{tab_idx:1,clinics:[],doctors:[],expenses:[],incomes:[],items:[],mateched_clinics:[],form:{clinic:"",doctor:"",startDate:new Date().toISOString().slice(0,10),endDate:new Date().toISOString().slice(0,10)}}},methods:{onSearchExpenses:function(){_.post(route("bills.expenses.searchData"),this.form).then(e=>{this.incomes=[],this.items=[],this.expenses=e.data,console.log(e.data)}).catch(e=>{})},onSearchIncomes:function(){_.post(route("bills.income.searchData"),this.form).then(e=>{this.expenses=[],this.items=[],this.incomes=e.data,console.log(e.data)}).catch(e=>{})},onCheckBalance:function(){_.post(route("bills.items.balance"),this.form).then(e=>{this.expenses=[],this.incomes=[],this.items=e.data,console.log(e.data)})},getTotalLineIncome(e){if(e.appointment.payment!==null){var r=Number(e.appointment.payment.detection_fees);e.prescription_items.forEach(a=>{a.service_fees!==null&&(r+=Number(a.service_fees))})}else{var r=0;e.prescription_items.forEach(c=>{c.service_fees!==null&&(r+=Number(c.service_fees))})}return r},totalIncomes(){if(this.incomes.length>0){var e=0;return this.incomes.forEach(r=>{e+=Number(this.getTotalLineIncome(r))}),e}},totalExpenses(){if(this.expenses.length>0){var e=0;return this.expenses.forEach(r=>{e+=Number(r.totalAmount)}),e}},beginBalance(e){if(e.bill_details.length>0){var r=[];e.bill_details.forEach(c=>{var d=new Date(c.date).toLocaleDateString(),l=new Date(this.form.startDate).toLocaleDateString();d<=l&&r.push(c)}),console.log("temp1",r)}if(e.spendings.length>0){var a=[];e.spendings.forEach(c=>{var d=new Date(c.date_isseud).toLocaleDateString(),l=new Date(this.form.startDate).toLocaleDateString();d<=l&&a.push(c)}),console.log("temp2",a)}}},created:function(){_.get(route("doctor.all")).then(r=>{var a={id:-1,name:"All"};this.doctors=r.data,this.doctors.unshift(a)}),_.get(route("clinic.all")).then(r=>{var a={id:-1,name:"All"};this.clinics=r.data,this.clinics.unshift(a)})}},J={class:"py-4"},F={class:"mx-auto sm:px-6 lg:px-8"},j={class:"bg-white shadow-xl sm:rounded-lg px-4 pb-4 pt-4"},U={class:"grid lg:grid-cols-2 gap-4 sm:grid-cols-1 h-1/2 overflow"},M={class:"flex items-center justify-start mt-4 flex-wrap"},O={class:"mx-auto sm:px-6 lg:px-8"},P={class:"bg-white overflow-hidden shadow-xl sm:rounded-lg"},Q={key:0,class:"result my-5 overflow-x-auto w-full"},R={class:"w-11/12 mx-auto max-w-4xl lg:max-w-full"},W={class:"text-center bg-gray-300"},q={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},z={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},G={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},H={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},K={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},X={class:"text-center border border-[#d4d4d4]"},Y={class:"p-2 border border-[#d4d4d4]"},Z={class:"p-2 border border-[#d4d4d4]"},$={class:"p-2 border border-[#d4d4d4]"},ee={class:"p-2 border border-[#d4d4d4]"},te={class:"p-2 border border-[#d4d4d4]"},oe={class:"border border-[#d4d4d4]"},se={class:"p-2 border font-bold border-[#d4d4d4]",colspan:"4"},re={class:"p-2 border font-bold border-[#d4d4d4]"},de={key:1,class:"result my-5 overflow-x-auto w-full"},ie={class:"w-11/12 mx-auto max-w-4xl lg:max-w-full"},ne={class:"text-center bg-gray-300"},ae={class:"bg-[#f8f9fa] border border-[#d4d4d4]"},le={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},ce={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},me={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},_e={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},pe={class:"text-center border border-[#d4d4d4]"},be={class:"border border-[#d4d4d4]"},he={class:"p-2 border border-[#d4d4d4]"},fe={class:"border border-[#d4d4d4]"},ue={class:"border border-[#d4d4d4]"},ge={class:"p-2 border border-[#d4d4d4]"},ve={class:"p-2 border font-bold border-[#d4d4d4]",colspan:"4"},xe={class:"p-2 border font-bold border-[#d4d4d4]"},De={key:2,class:"result my-5 overflow-x-auto w-full"},ye={class:"w-11/12 mx-auto max-w-4xl lg:max-w-full"},Se={class:"text-center bg-gray-300"},ke={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},Le={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},we={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},Ve={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},Ee={class:"text-center border border-[#d4d4d4]"},Be={key:0,class:"border border-[#d4d4d4]"},Ie={key:1,class:"p-2 border border-[#d4d4d4]"},Te={key:2,class:"border border-[#d4d4d4]"},Ne={key:3,class:"border border-[#d4d4d4]"},Ce={key:3},Ae={class:"text-center text-red-600 my-5"},Je=t("i",{class:"fa fa-exclamation-circle mr-1"},null,-1);function Fe(e,r,a,c,d,l){const v=p("jet-label"),x=p("multiselect"),D=p("TextField"),y=p("jet-button"),S=p("app-layout");return i(),N(S,null,{default:h(()=>[t("div",J,[t("div",F,[t("div",j,[t("div",U,[t("div",null,[m(v,{value:e.__("Clinic")},null,8,["value"]),m(x,{modelValue:d.form.clinic,"onUpdate:modelValue":r[0]||(r[0]=s=>d.form.clinic=s),label:"name",options:d.clinics,placeholder:"Select branch"},null,8,["modelValue","options"])]),t("div",null,[m(v,{value:e.__("Doctor")},null,8,["value"]),m(x,{modelValue:d.form.doctor,"onUpdate:modelValue":r[1]||(r[1]=s=>d.form.doctor=s),label:"name",options:d.doctors,placeholder:"Select customer"},null,8,["modelValue","options"])]),m(D,{modelValue:d.form.startDate,"onUpdate:modelValue":r[2]||(r[2]=s=>d.form.startDate=s),itemType:"date",itemLabel:e.__("Start Date")},null,8,["modelValue","itemLabel"]),m(D,{modelValue:d.form.endDate,"onUpdate:modelValue":r[3]||(r[3]=s=>d.form.endDate=s),itemType:"date",itemLabel:e.__("End Date")},null,8,["modelValue","itemLabel"])]),t("div",M,[m(y,{onClick:r[4]||(r[4]=s=>l.onSearchExpenses())},{default:h(()=>[f(o(e.__("Expenses")),1)]),_:1}),m(y,{onClick:r[5]||(r[5]=s=>l.onSearchIncomes())},{default:h(()=>[f(o(e.__("Incomes")),1)]),_:1})])])])]),t("div",O,[t("div",P,[d.expenses.length>0?(i(),n("div",Q,[t("table",R,[t("thead",W,[t("th",q,o(e.__("Bill Number")),1),t("th",z,o(e.__("Date")),1),t("th",G,o(e.__("Clinic")),1),t("th",H,o(e.__("Doctor")),1),t("th",K,o(e.__("Expenses Amount")),1)]),t("tbody",X,[(i(!0),n(u,null,g(d.expenses,(s,je)=>(i(),n("tr",{class:"border border-[#d4d4d4]",key:s.id},[t("td",Y,o(s.id),1),t("td",Z,o(new Date(s.date).toLocaleDateString()),1),t("td",$,o(s.clinic.name),1),t("td",ee,o(s.doctor.name),1),t("td",te,o(s.totalAmount),1)]))),128)),t("tr",oe,[t("td",se,o(e.__("Total")),1),t("td",re,o(l.totalExpenses()),1)])])])])):d.incomes.length>0?(i(),n("div",de,[t("table",ie,[t("thead",ne,[t("th",ae,o(e.__("Prescription Number")),1),t("th",le,o(e.__("Date")),1),t("th",ce,o(e.__("Clinic")),1),t("th",me,o(e.__("Doctor")),1),t("th",_e,o(e.__("Incomes Amount")),1)]),t("tbody",pe,[(i(!0),n(u,null,g(d.incomes,s=>(i(),n("tr",{class:"border border-[#d4d4d4]",key:s.id},[t("td",be,o(s.id),1),t("td",he,o(new Date(s.dateTimeIssued).toLocaleDateString()),1),t("td",fe,o(s.clinic.name),1),t("td",ue,o(s.doctor.name),1),t("td",ge,o(l.getTotalLineIncome(s)),1)]))),128)),t("tr",null,[t("td",ve,o(e.__("Total")),1),t("td",xe,o(l.totalIncomes()),1)])])])])):d.items.length>0?(i(),n("div",De,[t("table",ye,[t("thead",Se,[t("th",ke,o(e.__("Item")),1),t("th",Le,o(e.__("Beginning Balance")),1),t("th",we,o(e.__("Ending Balance")),1),t("th",Ve,o(e.__("Consumed Quantity")),1)]),t("tbody",Ee,[(i(!0),n(u,null,g(d.items,s=>(i(),n("tr",{class:"border border-[#d4d4d4]",key:s.id},[s.hidden==0?(i(),n("td",Be,o(s.name),1)):b("",!0),s.hidden==0?(i(),n("td",Ie,o(l.beginBalance(s)),1)):b("",!0),s.hidden==0?(i(),n("td",Te,o("-")+" ")):b("",!0),s.hidden==0?(i(),n("td",Ne,o("-")+" ")):b("",!0)]))),128))])])])):(i(),n("div",Ce,[t("p",Ae,[Je,f(" "+o(e.__("No Records Were Found")),1)])]))])])]),_:1})}const Ot=C(A,[["render",Fe]]);export{Ot as default};