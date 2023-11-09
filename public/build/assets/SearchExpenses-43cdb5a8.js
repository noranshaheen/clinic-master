import{A as w}from"./AppLayout-336b7499.js";import{J as S}from"./Label-c6c7e0c2.js";import{J as k}from"./Button-fce1e67a.js";import{J as L}from"./SecondaryButton-fb7ef34d.js";import{J as T}from"./DangerButton-bf3f8f1f.js";import{T as B}from"./TextField-4dc08153.js";import{M as V}from"./vue3-multiselect.umd.min-89fe1e95.js";import I from"./EditLine-64c486c6.js";import{k as p,c as N,w as h,r as _,o as n,a as t,t as o,b as m,f,d as a,F as u,g,e as b}from"./app-98cccb0d.js";import"./sweetalert.min-9f604034.js";/* empty css                                                                  */import{_ as C}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-7ca2eef9.js";import"./ActionMessage-529841b6.js";import"./ActionSection-14bbef3c.js";import"./SectionTitle-f26ec90c.js";import"./ConfirmationModal-2d2586d4.js";import"./Modal-2ccc6cf7.js";import"./DialogModal-9cb7d35f.js";import"./FormSection-60b88c5f.js";import"./Input-9c9fd5b2.js";import"./Checkbox-7ff4e1d6.js";import"./InputError-48880b4d.js";import"./SectionBorder-a45d0249.js";import"./ValidationErrors-ce3c07bd.js";/* empty css            */import"./Edit-cfad98b4.js";import"./Edit-04381c68.js";import"./Edit-c883850a.js";import"./Edit-663be45d.js";import"./Edit-833659c9.js";import"./Edit-e905c401.js";import"./Edit-fb9e1a40.js";import"./Edit-8b049cff.js";import"./Edit-7210d6e2.js";import"./Edit-9520adfe.js";import"./Load-c81154ca.js";import"./Load-269b27e0.js";import"./Edit-470aa9e5.js";import"./Edit-ae0efa3b.js";import"./Upload-3f7847e9.js";import"./Upload-cab6aca1.js";import"./Upload-4bb109cf.js";import"./Upload-91640e3b.js";import"./Settings-281c0c2c.js";import"./Settings-3a181d36.js";import"./Upload-b3182070.js";import"./Request-264efc19.js";import"./Add-983c5f77.js";import"./Load-b9d12279.js";import"./Upload-0c9409a0.js";import"./Load-c588859c.js";import"./ItemsMap-ac429fa2.js";import"./Upload-69a7afe4.js";import"./ItemsMap-99c5c9fb.js";import"./RequestEx-4f93fb5e.js";const A={components:{AppLayout:w,JetLabel:S,JetButton:k,JetSecondaryButton:L,JetDangerButton:T,DialogInvoiceLine:I,TextField:B,Multiselect:V},props:{},data(){return{tab_idx:1,clinics:[],doctors:[],expenses:[],incomes:[],items:[],mateched_clinics:[],form:{clinic:"",startDate:new Date().toISOString().slice(0,10),endDate:new Date().toISOString().slice(0,10)}}},methods:{onSearchExpenses:function(){p.post(route("bills.expenses.searchData"),this.form).then(e=>{this.incomes=[],this.items=[],this.expenses=e.data,console.log(e.data)}).catch(e=>{})},onExportExpenses(){p({url:route("bills.expenses.exportData"),method:"POST",data:this.form,responseType:"blob"}).then(e=>{const d=window.URL.createObjectURL(new Blob([e.data])),i=document.createElement("a");i.href=d,i.setAttribute("download","ExpensesReport.xlsx"),document.body.appendChild(i),i.click()})},onSearchIncomes:function(){p.post(route("bills.income.searchData"),this.form).then(e=>{this.expenses=[],this.items=[],this.incomes=e.data,console.log(e.data)}).catch(e=>{})},getTotalLineIncome(e){if(e.appointment.payment!==null){var d=Number(e.appointment.payment.detection_fees);d+=e.appointment.payment.service_fees}else{var d=0;e.prescription_items.forEach(c=>{c.service_fees!==null&&(d+=Number(c.service_fees))})}return d},totalIncomes(){if(this.incomes.length>0){var e=0;return this.incomes.forEach(d=>{e+=Number(this.getTotalLineIncome(d))}),e}},totalExpenses(){if(this.expenses.length>0){var e=0;return this.expenses.forEach(d=>{e+=Number(d.totalAmount)}),e}},beginBalance(e){if(e.bill_details.length>0){var d=[];e.bill_details.forEach(c=>{var r=new Date(c.date).toLocaleDateString(),l=new Date(this.form.startDate).toLocaleDateString();r<=l&&d.push(c)}),console.log("temp1",d)}if(e.spendings.length>0){var i=[];e.spendings.forEach(c=>{var r=new Date(c.date_isseud).toLocaleDateString(),l=new Date(this.form.startDate).toLocaleDateString();r<=l&&i.push(c)}),console.log("temp2",i)}}},created:function(){p.get(route("doctor.all")).then(d=>{var i={id:-1,name:"All"};this.doctors=d.data,this.doctors.unshift(i)}),p.get(route("clinic.all")).then(d=>{var i={id:-1,name:"All"};this.clinics=d.data,this.clinics.unshift(i)})}},J={class:"py-0"},j={class:"mx-auto sm:px-6 lg:px-8"},F={class:"py-3 px-1"},U={class:"bg-white shadow-xl sm:rounded-lg px-4 pb-4 pt-4"},O={class:"grid lg:grid-cols-3 gap-4 sm:grid-cols-1 h-1/2 overflow"},R={class:"flex items-center justify-start mt-4 flex-wrap"},M={class:"mx-auto sm:px-6 lg:px-8"},P={class:"bg-white overflow-hidden shadow-xl sm:rounded-lg"},Q={key:0,class:"result my-5 overflow-x-auto w-full"},W={class:"w-11/12 mx-auto max-w-4xl lg:max-w-full"},q={class:"text-center bg-gray-300"},z={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},G={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},H={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},K={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},X={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},Y={class:"text-center border border-[#d4d4d4]"},Z={class:"p-2 border border-[#d4d4d4]"},$={class:"p-2 border border-[#d4d4d4]"},ee={class:"p-2 border border-[#d4d4d4]"},te={class:"p-2 border border-[#d4d4d4]"},oe={class:"p-2 border border-[#d4d4d4]"},se={class:"border border-[#d4d4d4]"},de={class:"p-2 border font-bold border-[#d4d4d4]",colspan:"4"},re={class:"p-2 border font-bold border-[#d4d4d4]"},ne={key:1,class:"result my-5 overflow-x-auto w-full"},ae={class:"w-11/12 mx-auto max-w-4xl lg:max-w-full"},ie={class:"text-center bg-gray-300"},le={class:"bg-[#f8f9fa] border border-[#d4d4d4]"},ce={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},me={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},pe={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},_e={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},be={class:"text-center border border-[#d4d4d4]"},he={class:"border border-[#d4d4d4]"},fe={class:"p-2 border border-[#d4d4d4]"},ue={class:"border border-[#d4d4d4]"},ge={class:"border border-[#d4d4d4]"},xe={class:"p-2 border border-[#d4d4d4]"},ye={class:"p-2 border font-bold border-[#d4d4d4]",colspan:"4"},ve={class:"p-2 border font-bold border-[#d4d4d4]"},De={key:2,class:"result my-5 overflow-x-auto w-full"},Ee={class:"w-11/12 mx-auto max-w-4xl lg:max-w-full"},we={class:"text-center bg-gray-300"},Se={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},ke={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},Le={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},Te={class:"bg-[#f8f9fa] p-3 border border-[#d4d4d4]"},Be={class:"text-center border border-[#d4d4d4]"},Ve={key:0,class:"border border-[#d4d4d4]"},Ie={key:1,class:"p-2 border border-[#d4d4d4]"},Ne={key:2,class:"border border-[#d4d4d4]"},Ce={key:3,class:"border border-[#d4d4d4]"},Ae={key:3},Je={class:"text-center text-red-600 my-5"},je=t("i",{class:"fa fa-exclamation-circle mr-1"},null,-1);function Fe(e,d,i,c,r,l){const v=_("jet-label"),D=_("multiselect"),x=_("TextField"),y=_("jet-button"),E=_("app-layout");return n(),N(E,null,{default:h(()=>[t("div",J,[t("div",j,[t("h2",F,o(e.__("Expenses")),1),t("div",U,[t("div",O,[t("div",null,[m(v,{value:e.__("Clinic")},null,8,["value"]),m(D,{modelValue:r.form.clinic,"onUpdate:modelValue":d[0]||(d[0]=s=>r.form.clinic=s),label:"name",options:r.clinics,placeholder:"Select branch"},null,8,["modelValue","options"])]),m(x,{modelValue:r.form.startDate,"onUpdate:modelValue":d[1]||(d[1]=s=>r.form.startDate=s),itemType:"date",itemLabel:e.__("Start Date")},null,8,["modelValue","itemLabel"]),m(x,{modelValue:r.form.endDate,"onUpdate:modelValue":d[2]||(d[2]=s=>r.form.endDate=s),itemType:"date",itemLabel:e.__("End Date")},null,8,["modelValue","itemLabel"])]),t("div",R,[m(y,{onClick:d[3]||(d[3]=s=>l.onSearchExpenses())},{default:h(()=>[f(o(e.__("Search")),1)]),_:1}),m(y,{onClick:d[4]||(d[4]=s=>l.onExportExpenses())},{default:h(()=>[f(o(e.__("Export")),1)]),_:1})])])])]),t("div",M,[t("div",P,[r.expenses.length>0?(n(),a("div",Q,[t("table",W,[t("thead",q,[t("th",z,o(e.__("Bill Number")),1),t("th",G,o(e.__("Date")),1),t("th",H,o(e.__("Clinic")),1),t("th",K,o(e.__("Type")),1),t("th",X,o(e.__("Expenses Amount")),1)]),t("tbody",Y,[(n(!0),a(u,null,g(r.expenses,(s,Ue)=>(n(),a("tr",{class:"border border-[#d4d4d4]",key:s.id},[t("td",Z,o(s.id),1),t("td",$,o(new Date(s.date).toLocaleDateString()),1),t("td",ee,o(s.clinic.name),1),t("td",te,o(e.__(s.type)),1),t("td",oe,o(s.totalAmount),1)]))),128)),t("tr",se,[t("td",de,o(e.__("Total")),1),t("td",re,o(l.totalExpenses()),1)])])])])):r.incomes.length>0?(n(),a("div",ne,[t("table",ae,[t("thead",ie,[t("th",le,o(e.__("Prescription Number")),1),t("th",ce,o(e.__("Date")),1),t("th",me,o(e.__("Clinic")),1),t("th",pe,o(e.__("Doctor")),1),t("th",_e,o(e.__("Incomes Amount")),1)]),t("tbody",be,[(n(!0),a(u,null,g(r.incomes,s=>(n(),a("tr",{class:"border border-[#d4d4d4]",key:s.id},[t("td",he,o(s.id),1),t("td",fe,o(new Date(s.dateTimeIssued).toLocaleDateString()),1),t("td",ue,o(s.clinic.name),1),t("td",ge,o(s.doctor.name),1),t("td",xe,o(l.getTotalLineIncome(s)),1)]))),128)),t("tr",null,[t("td",ye,o(e.__("Total")),1),t("td",ve,o(l.totalIncomes()),1)])])])])):r.items.length>0?(n(),a("div",De,[t("table",Ee,[t("thead",we,[t("th",Se,o(e.__("Item")),1),t("th",ke,o(e.__("Beginning Balance")),1),t("th",Le,o(e.__("Ending Balance")),1),t("th",Te,o(e.__("Consumed Quantity")),1)]),t("tbody",Be,[(n(!0),a(u,null,g(r.items,s=>(n(),a("tr",{class:"border border-[#d4d4d4]",key:s.id},[s.hidden==0?(n(),a("td",Ve,o(s.name),1)):b("",!0),s.hidden==0?(n(),a("td",Ie,o(l.beginBalance(s)),1)):b("",!0),s.hidden==0?(n(),a("td",Ne,o("-")+" ")):b("",!0),s.hidden==0?(n(),a("td",Ce,o("-")+" ")):b("",!0)]))),128))])])])):(n(),a("div",Ae,[t("p",Je,[je,f(" "+o(e.__("No Records Were Found")),1)])]))])])]),_:1})}const Mt=C(A,[["render",Fe]]);export{Mt as default};