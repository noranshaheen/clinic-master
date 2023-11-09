import{J as v}from"./ActionMessage-529841b6.js";import{J as w}from"./ActionSection-14bbef3c.js";import{J as C}from"./Button-fce1e67a.js";import{J as S}from"./ConfirmationModal-2d2586d4.js";import{J as j}from"./DangerButton-bf3f8f1f.js";import{J as y}from"./DialogModal-9cb7d35f.js";import{J as k}from"./FormSection-60b88c5f.js";import{J as D}from"./Input-9c9fd5b2.js";import{J as B}from"./Checkbox-7ff4e1d6.js";import{J as V}from"./InputError-48880b4d.js";import{J as M}from"./Label-c6c7e0c2.js";import{J as N}from"./SecondaryButton-fb7ef34d.js";import{J as x}from"./SectionBorder-a45d0249.js";import{J as F}from"./ValidationErrors-ce3c07bd.js";import{k as c,c as T,w as n,r as i,o as d,f as u,t as m,b as a,a as r,i as A,C as E,d as f,g as I,F as R,h as U,n as q}from"./app-98cccb0d.js";import{_ as L}from"./_plugin-vue_export-helper-c27b6911.js";import"./SectionTitle-f26ec90c.js";import"./Modal-2ccc6cf7.js";/* empty css            */const z={components:{JetActionMessage:v,JetActionSection:w,JetButton:C,JetConfirmationModal:S,JetDangerButton:j,JetDialogModal:y,JetFormSection:k,JetInput:D,JetCheckbox:B,JetInputError:V,JetLabel:M,JetSecondaryButton:N,JetSectionBorder:x,JetValidationErrors:F},props:{room:{Type:Object,default:null}},data(){return{errors:[],allClinics:[],form:this.$inertia.form({name:"",clinic_id:""}),showDialog:!1}},methods:{ShowDialog(){this.room!==null&&(this.form.name=this.room.name,this.form.clinic_id=this.room.clinic_id),this.showDialog=!0},CancelAddcustomer(){this.showDialog=!1},SaveCustomer(){c.put(route("rooms.update",{room:this.room.id}),this.form).then(o=>{this.$store.dispatch("setSuccessFlashMessage",!0),this.showDialog=!1,setTimeout(()=>{window.location.reload()},500)}).catch(o=>{console.log(o),this.form.processing=!1,this.$page.props.errors=o.response.data.errors,this.errors=o.response.data.errors})},SaveNewCustomer(){c.post(route("rooms.store"),this.form).then(o=>{this.$store.dispatch("setSuccessFlashMessage",!0),this.processing=!1,this.$nextTick(()=>this.$emit("dataUpdated")),this.form.reset(),this.form.processing=!1,this.showDialog=!1,setTimeout(()=>{window.location.reload()},500)}).catch(o=>{this.form.processing=!1,this.$page.props.errors=o.response.data.errors,this.errors=o.response.data.errors})},submit(){this.room==null?this.SaveNewCustomer():this.SaveCustomer()}},created:function(){c.get(route("clinic.all")).then(e=>{this.allClinics=e.data}).catch(e=>{console.log(e)})}},O={class:"grid grid-cols-1 gap-4"},G={class:"mt-4"},H=["value"],K={class:"flex items-center justify-end"};function P(o,e,Q,W,s,l){const h=i("jet-validation-errors"),p=i("jet-label"),_=i("jet-input"),g=i("jet-secondary-button"),J=i("jet-button"),b=i("jet-dialog-modal");return d(),T(b,{show:s.showDialog,onClose:e[4]||(e[4]=t=>s.showDialog=!1)},{title:n(()=>[u(m(o.__("Room Information")),1)]),content:n(()=>[a(h,{class:"mb-4"}),r("form",{onSubmit:e[2]||(e[2]=U((...t)=>l.submit&&l.submit(...t),["prevent"]))},[r("div",O,[r("div",null,[r("div",G,[a(p,{for:"type",value:o.__("Room Name")},null,8,["value"]),a(_,{id:"type",type:"text",class:"mt-1 block w-full",modelValue:s.form.name,"onUpdate:modelValue":e[0]||(e[0]=t=>s.form.name=t),required:""},null,8,["modelValue"])]),r("div",null,[a(p,{for:"branch",value:o.__("Choose Clinic")},null,8,["value"]),A(r("select",{id:"branch",required:"","onUpdate:modelValue":e[1]||(e[1]=t=>s.form.clinic_id=t),class:"mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm"},[(d(!0),f(R,null,I(s.allClinics,t=>(d(),f("option",{key:t.id,value:t.id},m(t.name),9,H))),128))],512),[[E,s.form.clinic_id]])])])])],32)]),footer:n(()=>[r("div",K,[a(g,{onClick:e[3]||(e[3]=t=>l.CancelAddcustomer())},{default:n(()=>[u(m(o.__("Cancel")),1)]),_:1}),a(J,{class:q(["ms-2",{"opacity-25":s.form.processing}]),onClick:l.submit,disabled:s.form.processing},{default:n(()=>[u(m(o.__("Save")),1)]),_:1},8,["onClick","class","disabled"])])]),_:1},8,["show"])}const _o=L(z,[["render",P]]);export{_o as default};