import{A as V}from"./AppLayout-336b7499.js";import M from"./TypeOfPatient-03c496f5.js";import H from"./ChooseCancellationMethod-648e904d.js";import T from"./AppointmentDetails-3aa666ee.js";import{J as F}from"./ActionMessage-529841b6.js";import{J as N}from"./ActionSection-14bbef3c.js";import{J as L}from"./Button-fce1e67a.js";import{J as E}from"./ConfirmationModal-2d2586d4.js";import{J as O}from"./DangerButton-bf3f8f1f.js";import{J as I}from"./DialogModal-9cb7d35f.js";import{J as U}from"./FormSection-60b88c5f.js";import{J as q}from"./Input-9c9fd5b2.js";import{J as P}from"./Checkbox-7ff4e1d6.js";import{J as R}from"./InputError-48880b4d.js";import{J as W}from"./Label-c6c7e0c2.js";import{J as z}from"./SecondaryButton-fb7ef34d.js";import{J as G}from"./SectionBorder-a45d0249.js";import{J as K}from"./ValidationErrors-ce3c07bd.js";import{M as Q}from"./vue3-multiselect.umd.min-89fe1e95.js";import{T as X}from"./TextField-4dc08153.js";import{k as v,c as _,w as p,r as d,o as n,b as m,a as t,i as Y,C as Z,d as c,g as x,t as i,F as y,h,f as g,e as $}from"./app-98cccb0d.js";import"./sweetalert.min-9f604034.js";import{_ as tt}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-7ca2eef9.js";import"./SectionTitle-f26ec90c.js";import"./Modal-2ccc6cf7.js";/* empty css            */import"./Edit-cfad98b4.js";import"./Edit-04381c68.js";import"./Edit-c883850a.js";import"./Edit-663be45d.js";import"./Edit-833659c9.js";import"./Edit-e905c401.js";import"./Edit-fb9e1a40.js";import"./Edit-8b049cff.js";import"./Edit-7210d6e2.js";import"./Edit-9520adfe.js";/* empty css                                                                  */import"./Load-c81154ca.js";import"./Load-269b27e0.js";import"./Edit-470aa9e5.js";import"./Edit-ae0efa3b.js";import"./Upload-3f7847e9.js";import"./Upload-cab6aca1.js";import"./Upload-4bb109cf.js";import"./Upload-91640e3b.js";import"./Settings-281c0c2c.js";import"./Settings-3a181d36.js";import"./Upload-b3182070.js";import"./Request-264efc19.js";import"./Add-983c5f77.js";import"./Load-b9d12279.js";import"./Upload-0c9409a0.js";import"./Load-c588859c.js";import"./ItemsMap-ac429fa2.js";import"./Upload-69a7afe4.js";import"./ItemsMap-99c5c9fb.js";import"./RequestEx-4f93fb5e.js";import"./ChoosePatient-e20672ef.js";import"./ServiceFees-c3724a56.js";const et={components:{AppLayout:V,TypeOfPatient:M,ChooseCancellationMethod:H,AppointmentDetails:T,JetActionMessage:F,JetActionSection:N,JetButton:L,JetConfirmationModal:E,JetDangerButton:O,JetDialogModal:I,JetFormSection:U,JetInput:q,JetCheckbox:P,JetInputError:R,JetLabel:W,JetSecondaryButton:z,JetSectionBorder:G,JetValidationErrors:K,Multiselect:Q,TextField:X},data(){return{allDoctors:[],form:this.$inertia.form({doctor_id:"",date:""}),appointment_Details:"",appointments:{},selectedAppointemt_id:"",cancelledAppointments:{doctor_id:"",date:""}}},methods:{searchData(){v.post(route("appointment.searchData"),this.form).then(o=>{Object.keys(o.data).length>0?this.appointments=o.data:this.appointments={},console.log(o.data)})},subtractHours(o,e){var u=new Date(o);u.setHours(u.getHours()-e);var k=u.toLocaleTimeString();return k},openDlg(o,e){this.selectedAppointemt_id=e,this.$refs[o].ShowDialog()},showDetails(o){v.get(route("appointments.show",{appointment:o})).then(e=>{console.log(e.data),this.appointment_Details=e.data,this.$refs.dlg3.ShowDialog()})},openCancellationDialog(o,e){this.cancelledAppointments.doctor_id=o,this.cancelledAppointments.date=e,this.$refs.dlg2.ShowDialog()}},created(){v.get(route("doctor.all")).then(o=>{var e=[{id:-1,name:"All"}];this.allDoctors=e.concat(o.data)})}},ot={class:"relative bg-white shadow-md dark:bg-gray-800 sm:rounded-lg m-1 p-1 md:mx-4 md:px-4"},st={class:"p-1"},rt={class:"sm:flex justify-between"},it={class:"sm:w-3/5"},lt={class:"sm:grid sm:grid-cols-2 sm:gap-8"},nt={class:"mb-3 sm:mb-0 text-sm md:text-md"},at=["value"],dt={class:"mb-3 sm:mb-0 text-sm md:text-md"},mt={class:"sm:w-1/5 flex flex-col justify-start items-center mt-2 sm:justify-end sm:items-end sm:mt-0 mx-auto sm:mx-0"},ct=t("i",{class:"fa-solid fa-magnifying-glass mx-1"},null,-1),pt={class:"hidden lg:inline"},_t={class:"mt-5 md:mx-4"},ut={key:0,class:"relative overflow-x-auto shadow-lg sm:rounded-lg"},ft={class:"w-full text-sm text-center text-gray-500 dark:text-gray-400"},ht={class:"text-sm text-gray-700 bg-gray-300 dark:bg-gray-700 dark:text-gray-400"},gt={scope:"col",class:"px-6 py-3"},bt={scope:"col",class:"px-6 py-3"},vt={scope:"col",class:"px-6 py-3"},xt={class:"px-2 md:px-6 md:py-4 border dark:border-gray-700 font-bold"},yt={class:"text-sm text-center md:p-4 md:text-md border dark:border-gray-700"},kt={class:"flex justify-center sm:justify-start flex-wrap md:grid md:grid-cols-2 lg:grid-cols-4"},wt={class:"hidden md:inline"},Dt={class:"hidden md:inline"},Jt={class:"border dark:border-gray-700 md:px-2 md:py-2"},Ct={key:1,class:"relative overflow-x-auto shadow-lg bg-white sm:rounded-lg w-full text-sm text-center"},jt={class:"text-center text-red-600 my-5"},At=t("i",{class:"fa fa-exclamation-circle mr-1"},null,-1);function St(o,e,u,k,a,l){const D=d("type-of-patient"),J=d("choose-cancellation-method"),C=d("appointment-details"),w=d("jet-label"),j=d("jet-input"),A=d("jet-button"),f=d("jet-secondary-button"),S=d("JetButton"),B=d("app-layout");return n(),_(B,null,{default:p(()=>[m(D,{ref:"dlg1",appointment_id:a.selectedAppointemt_id,onSave:e[0]||(e[0]=r=>l.searchData())},null,8,["appointment_id"]),m(J,{ref:"dlg2",doctor_id:a.cancelledAppointments.doctor_id,date:a.cancelledAppointments.date,onSave:e[1]||(e[1]=r=>l.searchData())},null,8,["doctor_id","date"]),m(C,{ref:"dlg3",appointment_Details:a.appointment_Details,onDelete:e[2]||(e[2]=r=>l.searchData())},null,8,["appointment_Details"]),t("div",ot,[t("div",st,[t("div",rt,[t("div",it,[t("div",lt,[t("div",nt,[m(w,{for:"doctor-name",value:o.__("Doctor"),class:"md:inline-block lg:mt-4 font-bold"},null,8,["value"]),Y(t("select",{id:"doctor-name","onUpdate:modelValue":e[3]||(e[3]=r=>a.form.doctor_id=r),class:"mt-1 block w-full border-slate-300 rounded-md"},[(n(!0),c(y,null,x(a.allDoctors,r=>(n(),c("option",{value:r.id,key:r.id},i(r.name),9,at))),128))],512),[[Z,a.form.doctor_id]])]),t("div",dt,[m(w,{for:"date",value:o.__("Date"),class:"md:inline-block lg:mt-4 font-bold"},null,8,["value"]),m(j,{id:"date",type:"date",modelValue:a.form.date,"onUpdate:modelValue":e[4]||(e[4]=r=>a.form.date=r),class:"mt-1 block w-full text-sm",required:""},null,8,["modelValue"])])])]),t("div",mt,[m(A,{id:"search",onClick:e[5]||(e[5]=r=>l.searchData()),class:"text-sm text-center sm:w-1/2 sm:h-1/2 sm:flex justify-around sm:p-2"},{default:p(()=>[ct,t("span",pt,i(o.__("Search")),1)]),_:1})])])])]),t("div",_t,[Object.keys(a.appointments).length>0?(n(),c("div",ut,[t("table",ft,[t("thead",ht,[t("tr",null,[t("th",gt,i(o.__("Doctor")),1),t("th",bt,i(o.__("Appointments")),1),t("th",vt,i(o.__("Actions")),1)])]),t("tbody",null,[(n(!0),c(y,null,x(a.appointments,r=>(n(),c("tr",{class:"bg-white dark:bg-gray-800 dark:border-gray-700",key:r.id},[t("td",xt,i(r[0].doctor.name),1),t("td",yt,[t("div",kt,[(n(!0),c(y,null,x(r,s=>(n(),c("div",{key:s.id,class:"md:m-1"},[s.patient_id==null?(n(),_(f,{key:0,onClick:h(b=>l.openDlg("dlg1",s.id),["prevent"]),class:"m-1 text-blue-500 border-blue-500 hover:bg-[#4099de] hover:text-white md:w-full"},{default:p(()=>[g(i(l.subtractHours(s.from,3)),1)]),_:2},1032,["onClick"])):s.cancelled==null&&s.done==null?(n(),_(f,{key:1,onClick:h(b=>l.showDetails(s.id),["prevent"]),class:"m-1 text-neutral-400 border-neutral-300 hover:bg-[#b7d5ed] hover:text-white md:w-full"},{default:p(()=>[t("span",wt,i(s.patient.name),1),t("p",null,i(l.subtractHours(s.from,3)),1)]),_:2},1032,["onClick"])):s.cancelled==null&&s.done==1?(n(),_(f,{key:2,onClick:h(b=>l.showDetails(s.id),["prevent"]),class:"m-1 text-green-500 border-green-500 hover:bg-green-500 hover:text-white md:w-full"},{default:p(()=>[t("span",Dt,i(s.patient.name),1),t("p",null,i(l.subtractHours(s.from,3)),1)]),_:2},1032,["onClick"])):s.cancelled==1?(n(),_(f,{key:3,onClick:h(b=>l.showDetails(s.id),["prevent"]),class:"m-1 text-red-200 border border-red-200 text-bold hover:bg-red-200 hover:text-white"},{default:p(()=>[g(i(l.subtractHours(s.from,3)),1)]),_:2},1032,["onClick"])):$("",!0)]))),128))])]),t("td",Jt,[m(S,{onClick:s=>l.openCancellationDialog(r[0].doctor_id,this.form.date)},{default:p(()=>[g(i(o.__("Cancel")),1)]),_:2},1032,["onClick"])])]))),128))])])])):(n(),c("div",Ct,[t("p",jt,[At,g(" "+i(o.__("No Records Were Found")),1)])]))])]),_:1})}const Ne=tt(et,[["render",St]]);export{Ne as default};