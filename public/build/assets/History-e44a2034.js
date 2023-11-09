import{k as u,c as x,w as p,r as _,o as n,b as a,a as t,t as o,f as c,i as w,v as y,d as l,g as b,F as g}from"./app-98cccb0d.js";import{A as P}from"./AppLayout-336b7499.js";import{J as C}from"./Label-c6c7e0c2.js";import{J}from"./Button-fce1e67a.js";import{J as T}from"./SecondaryButton-fb7ef34d.js";import{J as B}from"./DangerButton-bf3f8f1f.js";import{T as N}from"./TextField-4dc08153.js";import{M as R}from"./vue3-multiselect.umd.min-89fe1e95.js";import L from"./EditLine-64c486c6.js";import A from"./Show-70d6b51d.js";import j from"./ServiceFees-c3724a56.js";import O from"./AppointmentDetails-3aa666ee.js";/* empty css                                                                  */import{_ as V}from"./_plugin-vue_export-helper-c27b6911.js";/* empty css            */import"./Edit-7ca2eef9.js";import"./ActionMessage-529841b6.js";import"./ActionSection-14bbef3c.js";import"./SectionTitle-f26ec90c.js";import"./ConfirmationModal-2d2586d4.js";import"./Modal-2ccc6cf7.js";import"./DialogModal-9cb7d35f.js";import"./FormSection-60b88c5f.js";import"./Input-9c9fd5b2.js";import"./Checkbox-7ff4e1d6.js";import"./InputError-48880b4d.js";import"./SectionBorder-a45d0249.js";import"./ValidationErrors-ce3c07bd.js";import"./Edit-cfad98b4.js";import"./Edit-04381c68.js";import"./Edit-c883850a.js";import"./Edit-663be45d.js";import"./Edit-833659c9.js";import"./Edit-e905c401.js";import"./Edit-fb9e1a40.js";import"./Edit-8b049cff.js";import"./Edit-7210d6e2.js";import"./Edit-9520adfe.js";import"./Load-c81154ca.js";import"./Load-269b27e0.js";import"./Edit-470aa9e5.js";import"./Edit-ae0efa3b.js";import"./Upload-3f7847e9.js";import"./Upload-cab6aca1.js";import"./Upload-4bb109cf.js";import"./Upload-91640e3b.js";import"./Settings-281c0c2c.js";import"./Settings-3a181d36.js";import"./Upload-b3182070.js";import"./Request-264efc19.js";import"./Add-983c5f77.js";import"./Load-b9d12279.js";import"./Upload-0c9409a0.js";import"./Load-c588859c.js";import"./sweetalert.min-9f604034.js";import"./ItemsMap-ac429fa2.js";import"./Upload-69a7afe4.js";import"./ItemsMap-99c5c9fb.js";import"./RequestEx-4f93fb5e.js";const E={components:{AppLayout:P,JetLabel:C,JetButton:J,JetSecondaryButton:T,JetDangerButton:B,DialogInvoiceLine:L,TextField:N,Multiselect:R,ShowPrescription:A,ServiceFees:j,AppointmentDetails:O,axios:u},props:{payments:{default:null},prescriptions:{default:null}},data(){return{tab_idx:1,errors:[],prescription_details:"",appointment_Details:"",prs:"",totalServiceFees:0}},methods:{openDlg(e){this.prescription_details=e,this.$nextTick(()=>this.$refs.dlg1.ShowDialog())},getPaidServiceFees(e){return e.appointment.payment.service_fees?e.appointment.payment.service_fees:"Not Paid"},getTotalServiceFees(e){var i=0;return e.prescription_items.forEach(m=>{m.service_fees!==null&&(i+=Number(m.service_fees))}),this.totalServiceFees=i,i},getRemainingOfServiceFees(e){if(e.appointment.payment){if(this.totalServiceFees!=0&&e.appointment.payment.service_fees!==null){var i=e.appointment.payment.service_fees;return this.totalServiceFees-Number(i)}else if(e.appointment.payment.service_fees==null)return this.totalServiceFees}else return this.totalServiceFees},payRemaining(e){e.appointment.payment==null?this.showDetails(e.appointment_id):u.get(route("prescription.serviceFees",e.appointment_id)).then(i=>{this.prs=i.data,this.$nextTick(()=>{this.$refs.dlg2.ShowDialog()})})},showDetails(e){u.get(route("appointments.show",{appointment:e})).then(i=>{console.log(i.data),this.appointment_Details=i.data,this.$nextTick(()=>{this.$refs.dlg3.ShowDialog()})})},downloadPDF(e){window.open(route("pdf.payment.preview",[e.id]))},downloadPrescriptionPDF(e){window.open(route("pdf.prescription.preview",[e.id]))}},created:function(){console.log("prescriptions",this.prescriptions),console.log("payments",this.payments)}},I={class:"py-4"},M={class:"mx-auto sm:px-6 lg:px-8"},H={class:"bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 pb-4 pt-0"},W={class:"my-4 font-bold"},q={class:"flex items-center ms-0 mb-4 border-b border-gray-200"},z={class:"overflow-auto"},G={class:"w-full"},K={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},Q={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},U={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},X={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},Y={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},Z={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},$={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},ee={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},te={class:"text-center border p-2"},oe={class:"text-center border p-2"},se={class:"text-center border p-2"},ie={class:"text-center border p-2"},re={class:"text-center border p-2"},ne={class:"text-center border p-2"},ae={class:"text-center border p-2"},le={class:"text-center border p-2"},de={class:"overflow-auto"},pe={key:0,class:"w-full"},ce={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},_e={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},me={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},fe={class:"bg-[#f8f9fa] p-3 border border-[#eceeef]"},he={class:"text-center border py-2"},ue={class:"text-center border py-2"},be={class:"text-center border py-2"},ge={class:"list-disc list-inside"},ve={class:"text-center border py-2"},we={class:"flex flex-col sm:flex-row justify-center items-center"},ye={key:1},De={class:"text-center text-red-600"},Se=t("i",{class:"fa fa-exclamation-circle mr-1"},null,-1);function Fe(e,i,m,ke,r,d){const D=_("show-prescription"),S=_("appointment-details"),F=_("ServiceFees"),v=_("jet-button"),h=_("JetButton"),k=_("app-layout");return n(),x(k,null,{default:p(()=>[a(D,{ref:"dlg1",prescription:r.prescription_details},null,8,["prescription"]),a(S,{ref:"dlg3",appointment_Details:r.appointment_Details},null,8,["appointment_Details"]),a(F,{ref:"dlg2",prescription:r.prs},null,8,["prescription"]),t("div",I,[t("div",M,[t("div",H,[t("div",W,[t("h2",null,o(this.prescriptions[0].patient.name),1)]),t("div",q,[a(v,{onClick:i[0]||(i[0]=s=>r.tab_idx=1),disabled:r.tab_idx==1,isRounded:!1},{default:p(()=>[c(o(e.__("Payments")),1)]),_:1},8,["disabled"]),a(v,{onClick:i[1]||(i[1]=s=>r.tab_idx=2),disabled:r.tab_idx==2,isRounded:!1},{default:p(()=>[c(o(e.__("Prescriptions")),1)]),_:1},8,["disabled"])]),w(t("div",z,[t("table",G,[t("tr",null,[t("th",K,o(e.__("Date")),1),t("th",Q,o(e.__("Detection Type")),1),t("th",U,o(e.__("Payment Status")),1),t("th",X,o(e.__("Detection Fees")),1),t("th",Y,o(e.__("Total Service Fees")),1),t("th",Z,o(e.__("Paid Service Fees")),1),t("th",$,o(e.__("Remains")),1),t("th",ee,o(e.__("Actions")),1)]),(n(!0),l(g,null,b(m.prescriptions,s=>(n(),l("tr",{key:s.id},[t("td",te,o(new Date(s.appointment.date).toLocaleDateString()),1),t("td",oe,o(e.__(s.appointment.type)),1),t("td",se,o(e.__(s.appointment.status)),1),t("td",ie,o(s.appointment.amount),1),t("td",re,o(s.appointment.prescription_items!==null?d.getTotalServiceFees(s):"0"),1),t("td",ne,o(s.appointment.payment!==null?e.__(d.getPaidServiceFees(s)):e.__("Not Paid")),1),t("td",ae,o(s.appointment.prescription_items!==null?d.getRemainingOfServiceFees(s):"0"),1),t("td",le,[a(h,{onClick:f=>d.downloadPDF(s)},{default:p(()=>[c(o(e.__("Print")),1)]),_:2},1032,["onClick"]),a(h,{onClick:f=>d.payRemaining(s)},{default:p(()=>[c(o(e.__("Pay")),1)]),_:2},1032,["onClick"])])]))),128))])],512),[[y,r.tab_idx==1]]),w(t("div",de,[this.prescriptions.length!==0?(n(),l("table",pe,[t("tr",null,[t("th",ce,o(e.__("Date")),1),t("th",_e,o(e.__("Doctor")),1),t("th",me,o(e.__("Diagnose")),1),t("th",fe,o(e.__("Actions")),1)]),(n(!0),l(g,null,b(m.prescriptions,s=>(n(),l("tr",{key:s.id},[t("td",he,o(new Date(s.dateTimeIssued).toLocaleDateString()),1),t("td",ue,o(s.doctor.name),1),t("td",be,[(n(!0),l(g,null,b(JSON.parse(s.diagnosis),f=>(n(),l("ul",ge,[t("li",null,o(f),1)]))),256))]),t("td",ve,[t("div",we,[a(h,{class:"w-full sm:w-min",onClick:f=>d.downloadPrescriptionPDF(s)},{default:p(()=>[c(o(e.__("Print")),1)]),_:2},1032,["onClick"]),a(h,{class:"w-full sm:w-min",onClick:f=>d.openDlg(s)},{default:p(()=>[c(o(e.__("Show")),1)]),_:2},1032,["onClick"])])])]))),128))])):(n(),l("div",ye,[t("p",De,[Se,c(" "+o(e.__("No Records Were Found")),1)])]))],512),[[y,r.tab_idx==2]])])])])]),_:1})}const Bt=V(E,[["render",Fe]]);export{Bt as default};