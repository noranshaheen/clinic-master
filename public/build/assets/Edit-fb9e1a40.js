import{J as S}from"./ActionMessage-529841b6.js";import{J as j}from"./ActionSection-14bbef3c.js";import{J as A}from"./Button-fce1e67a.js";import{J as U}from"./ConfirmationModal-2d2586d4.js";import{J as B}from"./DangerButton-bf3f8f1f.js";import{J as M}from"./DialogModal-9cb7d35f.js";import{J as x}from"./FormSection-60b88c5f.js";import{J as T}from"./Input-9c9fd5b2.js";import{J as F}from"./Checkbox-7ff4e1d6.js";import{J as R}from"./InputError-48880b4d.js";import{J as E}from"./Label-c6c7e0c2.js";import{J as q}from"./SecondaryButton-fb7ef34d.js";import{J as N}from"./SectionBorder-a45d0249.js";import{J as I}from"./ValidationErrors-ce3c07bd.js";import{M as L}from"./vue3-multiselect.umd.min-89fe1e95.js";import{T as O}from"./TextField-4dc08153.js";import{k as _,c as z,w as c,r as p,o as r,f as g,t as n,b as s,a as t,i as f,C as w,d,g as v,F as b,u as W,v as G,n as H}from"./app-98cccb0d.js";import{_ as K}from"./_plugin-vue_export-helper-c27b6911.js";import"./SectionTitle-f26ec90c.js";import"./Modal-2ccc6cf7.js";/* empty css            */const P={components:{JetActionMessage:S,JetActionSection:j,JetButton:A,JetConfirmationModal:U,JetDangerButton:B,JetDialogModal:M,JetFormSection:x,JetInput:T,JetCheckbox:F,JetInputError:R,JetLabel:E,JetSecondaryButton:q,JetSectionBorder:N,JetValidationErrors:I,Multiselect:L,TextField:O},props:{appointment:{type:Object,default:null}},data(){return{errors:[],form:this.$inertia.form({doctor_id:"",clinic_id:"",records:[]}),allrooms:[],availableRooms:[],clinics:[],doctors:[],showDialog:!1}},methods:{ShowDialog(){this.appointment!=null&&(this.form.doctor_id=this.appointment.doctor_id,this.form.records.room_id=this.appointment.room_id,this.form.records.date=new Date(this.appointment.date).toISOString(),this.form.records.from=new Date(this.appointment.from).toLocaleTimeString(),this.form.records.to=new Date(this.appointment.to).toLocaleTimeString()),this.showDialog=!0},CancelDlg(){this.showDialog=!1},updateAvailableRooms(e){this.availableRooms=this.allrooms.filter(i=>i.clinic_id==e),console.log(e),console.log(this.availableRooms)},SaveNewAppointment(){_.post(route("appointments.store"),this.form).then(e=>{this.$store.dispatch("setSuccessFlashMessage",!0),this.processing=!1,this.form.reset(),this.form.processing=!1,this.showDialog=!1,setTimeout(()=>{window.location.reload()},500)}).catch(e=>{this.form.processing=!1,this.$page.props.errors=e.response.data.errors,this.errors=e.response.data.errors})},SaveAppointment(){_.put(route("appointments.store",{appointment:this.appointment.id}),this.form).then(e=>{this.$store.dispatch("setSuccessFlashMessage",!0),this.processing=!1,this.form.reset(),this.form.processing=!1,this.showDialog=!1,setTimeout(()=>{window.location.reload()},500)}).catch(e=>{this.form.processing=!1,this.$page.props.errors=e.response.data.errors,this.errors=e.response.data.errors})},submit(){this.appointment==null?this.SaveNewAppointment():this.SaveAppointment()},addBalance(){this.form.records.push({date:new Date().toISOString().slice(0,10),from:"",to:"",room_id:"",num_of_cases:0,repeat:!1})},deleteEntry(e){this.form.records.splice(e,1)}},created(){this.addBalance(),_.get(route("doctor.all")).then(e=>{this.doctors=e.data}),_.get(route("clinic.all")).then(e=>{this.clinics=e.data}),_.get(route("room.all")).then(e=>{this.allrooms=e.data})}},Q={class:"grid grid-cols-1"},X={class:"sm:grid sm:grid-cols-2 sm:gap-1 md:gap-3"},Y={class:"sm:col-span-1"},Z=["value"],$={class:"mb-4 sm:col-span-1"},ee=["value"],oe={class:"col-span-1"},te={class:"col-span-1"},se={class:"col-span-1"},le={class:"col-span-1"},ae={class:"col-span-1"},ie=["onUpdate:modelValue"],ne=["value"],re={class:"col-span-1"},me=["onUpdate:modelValue"],de={class:"col-span-1 flex justify-center sm:justify-end"},ce={class:"col-span-1 w-1/5 my-2 mx-auto"},pe={class:""},ue={class:"hidden lg:inline"},_e={class:"flex items-center justify-end"};function fe(e,i,he,ge,a,u){const V=p("jet-validation-errors"),m=p("jet-label"),h=p("jet-input"),y=p("jet-danger-button"),k=p("jet-button"),C=p("jet-secondary-button"),D=p("jet-dialog-modal");return r(),z(D,{show:a.showDialog,maxWidth:"5xl",onClose:i[4]||(i[4]=o=>a.showDialog=!1)},{title:c(()=>[g(n(e.__("Add An Appointment")),1)]),content:c(()=>[s(V,{class:"mb-4"}),t("div",Q,[t("div",X,[t("div",Y,[s(m,{value:e.__("Doctor")},null,8,["value"]),f(t("select",{"onUpdate:modelValue":i[0]||(i[0]=o=>a.form.doctor_id=o),class:"mt-1 block w-full border-slate-300 rounded-md"},[(r(!0),d(b,null,v(a.doctors,o=>(r(),d("option",{value:o.id,key:o.id},n(o.name),9,Z))),128))],512),[[w,a.form.doctor_id]])]),t("div",$,[s(m,{value:e.__("Clinic")},null,8,["value"]),f(t("select",{"onUpdate:modelValue":i[1]||(i[1]=o=>a.form.clinic_id=o),class:"mt-1 block w-full border-slate-300 rounded-md",onChange:i[2]||(i[2]=o=>u.updateAvailableRooms(a.form.clinic_id))},[(r(!0),d(b,null,v(a.clinics,o=>(r(),d("option",{value:o.id,key:o.id},n(o.name),9,ee))),128))],544),[[w,a.form.clinic_id]])]),(r(!0),d(b,null,v(a.form.records,(o,J)=>(r(),d("div",{key:J,class:"bg-gray-200 sm:grid sm:grid-cols-2 sm:gap-2 sm:col-span-2 lg:grid lg:grid-cols-7 lg:gap-3 p-2 mb-2"},[t("div",oe,[s(m,{value:e.__("Date"),class:"mt-4"},null,8,["value"]),s(h,{type:"date",class:"mt-1 block w-full text-sm",modelValue:o.date,"onUpdate:modelValue":l=>o.date=l,required:""},null,8,["modelValue","onUpdate:modelValue"])]),t("div",te,[s(m,{value:e.__("From"),class:"mt-4"},null,8,["value"]),s(h,{type:"time",class:"mt-1 block w-full text-sm",modelValue:o.from,"onUpdate:modelValue":l=>o.from=l,required:""},null,8,["modelValue","onUpdate:modelValue"])]),t("div",se,[s(m,{value:e.__("To"),class:"mt-4"},null,8,["value"]),s(h,{type:"time",class:"mt-1 block w-full text-sm",modelValue:o.to,"onUpdate:modelValue":l=>o.to=l,required:""},null,8,["modelValue","onUpdate:modelValue"])]),t("div",le,[s(m,{value:e.__("Cases"),class:"mt-4"},null,8,["value"]),s(h,{type:"number",min:"1",class:"mt-1 block w-full text-sm",modelValue:o.num_of_cases,"onUpdate:modelValue":l=>o.num_of_cases=l,required:""},null,8,["modelValue","onUpdate:modelValue"])]),t("div",ae,[s(m,{value:e.__("Room"),class:"mt-4"},null,8,["value"]),f(t("select",{required:"","onUpdate:modelValue":l=>o.room_id=l,class:"mt-1 block w-full border-slate-300 rounded-md text-sm"},[(r(!0),d(b,null,v(a.availableRooms,l=>(r(),d("option",{value:l.id,key:l.id},n(l.name),9,ne))),128))],8,ie),[[w,o.room_id]])]),t("div",re,[s(m,{value:e.__("repeat"),class:"mt-4"},null,8,["value"]),f(t("input",{"onUpdate:modelValue":l=>o.repeat=l,type:"checkbox",name:"repeat",class:"mt-1 block text-sm"},null,8,me),[[W,o.repeat]])]),t("div",de,[s(y,{onClick:l=>u.deleteEntry(J),class:"mt-8 block min-w-fit"},{default:c(()=>[g(n(e.__("Delete")),1)]),_:2},1032,["onClick"])]),f(t("span",{class:"col-span-7 text-xs text-red-400 block"},n(e.__("will repeat this appointment after 1 week")),513),[[G,o.repeat]])]))),128))]),t("div",ce,[s(k,{class:"ps-2 w-full mt-1",onClick:u.addBalance,disabled:a.form.processing},{default:c(()=>[t("span",pe,n(e.__("Add")),1),t("span",ue,n(e.__(" An Appointment")),1)]),_:1},8,["onClick","disabled"])])])]),footer:c(()=>[t("div",_e,[s(C,{onClick:i[3]||(i[3]=o=>u.CancelDlg())},{default:c(()=>[g(n(e.__("Cancel")),1)]),_:1}),s(k,{class:H(["ms-2",{"opacity-25":a.form.processing}]),onClick:u.submit,disabled:a.form.processing},{default:c(()=>[g(n(e.__("Save")),1)]),_:1},8,["onClick","class","disabled"])])]),_:1},8,["show"])}const Ne=K(P,[["render",fe]]);export{Ne as default};