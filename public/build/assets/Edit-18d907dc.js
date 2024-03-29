import{J as g}from"./ActionMessage-517545cc.js";import{J as v}from"./ActionSection-2c866042.js";import{J as b}from"./Button-11813b5e.js";import{J as w}from"./ConfirmationModal-0f300aca.js";import{J as C}from"./DangerButton-367e534b.js";import{J as j}from"./DialogModal-22356253.js";import{J as S}from"./FormSection-bd296fee.js";import{J as V}from"./Input-8a286b7b.js";import{J as k}from"./Checkbox-ebdeef89.js";import{J as D}from"./InputError-317c03cf.js";import{J as y}from"./Label-e291ccc6.js";import{J as B}from"./SecondaryButton-8a1eaf86.js";import{J as N}from"./SectionBorder-822e764c.js";import{J as x}from"./ValidationErrors-31471297.js";import{k as p,c as M,w as n,r as l,o as A,f as d,t as u,b as r,a as i,h as T,n as U}from"./app-010fad37.js";import{_ as q}from"./_plugin-vue_export-helper-c27b6911.js";import"./SectionTitle-8abeab5a.js";import"./Modal-97755a3c.js";/* empty css            */const E={components:{JetActionMessage:g,JetActionSection:v,JetButton:b,JetConfirmationModal:w,JetDangerButton:C,JetDialogModal:j,JetFormSection:S,JetInput:V,JetCheckbox:k,JetInputError:D,JetLabel:y,JetSecondaryButton:B,JetSectionBorder:N,JetValidationErrors:x},props:{clinic:{Type:Object,default:null}},data(){return{errors:[],form:this.$inertia.form({name:"",phone:"",address:""}),showDialog:!1}},methods:{ShowDialog(){this.clinic!==null&&(this.form.name=this.clinic.name,this.form.phone=this.clinic.phone,this.form.address=this.clinic.address),this.showDialog=!0},CancelAddcustomer(){this.showDialog=!1},SaveCustomer(){p.put(route("clinics.update",{clinic:this.clinic.id}),this.form).then(e=>{this.$store.dispatch("setSuccessFlashMessage",!0),this.showDialog=!1,setTimeout(()=>{window.location.reload()},500)}).catch(e=>{console.log(e),this.form.processing=!1,this.$page.props.errors=e.response.data.errors,this.errors=e.response.data.errors})},SaveNewCustomer(){p.post(route("clinics.store"),this.form).then(e=>{this.$store.dispatch("setSuccessFlashMessage",!0),this.processing=!1,this.$nextTick(()=>this.$emit("dataUpdated")),this.form.reset(),this.form.processing=!1,this.showDialog=!1,setTimeout(()=>{window.location.reload()},500)}).catch(e=>{this.form.processing=!1,this.$page.props.errors=e.response.data.errors,this.errors=e.response.data.errors})},submit(){this.clinic==null?this.SaveNewCustomer():this.SaveCustomer()}}},F={class:"grid grid-cols-1"},I={class:"mt-4"},z={class:"mt-4"},L={class:"mt-4"},O={class:"flex items-center justify-end"};function P(e,o,G,H,s,a){const f=l("jet-validation-errors"),m=l("jet-label"),c=l("jet-input"),h=l("jet-secondary-button"),_=l("jet-button"),J=l("jet-dialog-modal");return A(),M(J,{show:s.showDialog,onClose:o[5]||(o[5]=t=>s.showDialog=!1)},{title:n(()=>[d(u(e.__("Clinic Information")),1)]),content:n(()=>[r(f,{class:"mb-4"}),i("form",{onSubmit:o[3]||(o[3]=T((...t)=>a.submit&&a.submit(...t),["prevent"]))},[i("div",F,[i("div",null,[i("div",I,[r(m,{value:e.__("Clinic Name")},null,8,["value"]),r(c,{type:"text",class:"mt-1 block w-full",modelValue:s.form.name,"onUpdate:modelValue":o[0]||(o[0]=t=>s.form.name=t),required:""},null,8,["modelValue"])]),i("div",z,[r(m,{value:e.__("Phone Number")},null,8,["value"]),r(c,{type:"text",class:"mt-1 block w-full",modelValue:s.form.phone,"onUpdate:modelValue":o[1]||(o[1]=t=>s.form.phone=t),required:""},null,8,["modelValue"])]),i("div",L,[r(m,{value:e.__("Address")},null,8,["value"]),r(c,{type:"text",class:"mt-1 block w-full",modelValue:s.form.address,"onUpdate:modelValue":o[2]||(o[2]=t=>s.form.address=t),required:"",autofocus:""},null,8,["modelValue"])])])])],32)]),footer:n(()=>[i("div",O,[r(h,{onClick:o[4]||(o[4]=t=>a.CancelAddcustomer())},{default:n(()=>[d(u(e.__("Cancel")),1)]),_:1}),r(_,{class:U(["ms-2",{"opacity-25":s.form.processing}]),onClick:a.submit,disabled:s.form.processing},{default:n(()=>[d(u(e.__("Save")),1)]),_:1},8,["onClick","class","disabled"])])]),_:1},8,["show"])}const de=q(E,[["render",P]]);export{de as default};
