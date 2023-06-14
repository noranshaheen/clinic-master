import{J as b}from"./ActionMessage-61e2ac70.js";import{J as v}from"./ActionSection-b2837b81.js";import{J as w}from"./Button-4bcf952d.js";import{J as D}from"./ConfirmationModal-25a9f4bd.js";import{J as C}from"./DangerButton-8bc4ac7b.js";import{J as S}from"./DialogModal-abac778c.js";import{J as j}from"./FormSection-88b4b82e.js";import{J as V}from"./Input-1c19b971.js";import{J as k}from"./Checkbox-4a56b901.js";import{J as y}from"./InputError-a5d97e62.js";import{J as M}from"./Label-df30c280.js";import{J as B}from"./SecondaryButton-713ac718.js";import{J as N}from"./SectionBorder-e50f0f2f.js";import{J as x}from"./ValidationErrors-d148bef4.js";import{M as T}from"./vue3-multiselect.umd.min-0e68115f.js";import{k as d,c as A,w as l,r as i,o as U,f as u,t as p,b as r,a,h as E,n as F}from"./app-150d5054.js";import{_ as I}from"./_plugin-vue_export-helper-c27b6911.js";import"./SectionTitle-3e354ea0.js";import"./Modal-af9a88ec.js";/* empty css            */const q={components:{JetActionMessage:b,JetActionSection:v,JetButton:w,JetConfirmationModal:D,JetDangerButton:C,JetDialogModal:S,JetFormSection:j,JetInput:V,JetCheckbox:k,JetInputError:y,JetLabel:M,JetSecondaryButton:B,JetSectionBorder:N,JetValidationErrors:x,Multiselect:T},props:{drug:{Type:Object,default:null}},data(){return{errors:[],allDiagnosis:[],form:this.$inertia.form({name:"",description:"",diagnose:""}),showDialog:!1}},methods:{ShowDialog(){this.drug!==null&&(this.form.name=this.drug.name,this.form.description=this.drug.description),this.showDialog=!0},CancelAddcustomer(){this.showDialog=!1},SaveCustomer(){d.put(route("drugs.update",{drug:this.drug.id}),this.form).then(e=>{this.$store.dispatch("setSuccessFlashMessage",!0),this.showDialog=!1,setTimeout(()=>{window.location.reload()},500)}).catch(e=>{console.log(e),this.form.processing=!1,this.$page.props.errors=e.response.data.errors,this.errors=e.response.data.errors})},SaveNewCustomer(){d.post(route("drugs.store"),this.form).then(e=>{this.$store.dispatch("setSuccessFlashMessage",!0),this.processing=!1,this.$nextTick(()=>this.$emit("dataUpdated")),this.form.reset(),this.form.processing=!1,this.showDialog=!1,setTimeout(()=>{window.location.reload()},500)}).catch(e=>{this.form.processing=!1,this.$page.props.errors=e.response.data.errors,this.errors=e.response.data.errors})},submit(){this.drug==null?this.SaveNewCustomer():this.SaveCustomer()}},created:function(){d.get(route("diagnosi.all")).then(o=>{this.allDiagnosis=o.data}).catch(o=>{})}},z={class:"grid grid-cols-1"},L={class:"mt-4"},O={class:"mt-4"},R={class:"mt-4"},G={class:"flex items-center justify-end"};function H(e,o,K,P,t,n){const f=i("jet-validation-errors"),m=i("jet-label"),c=i("jet-input"),h=i("multiselect"),g=i("jet-secondary-button"),_=i("jet-button"),J=i("jet-dialog-modal");return U(),A(J,{show:t.showDialog,onClose:o[5]||(o[5]=s=>t.showDialog=!1)},{title:l(()=>[u(p(e.__("Drug Information")),1)]),content:l(()=>[r(f,{class:"mb-4"}),a("form",{onSubmit:o[3]||(o[3]=E((...s)=>n.submit&&n.submit(...s),["prevent"]))},[a("div",z,[a("div",null,[a("div",L,[r(m,{value:e.__("Drug Name")},null,8,["value"]),r(c,{type:"text",class:"mt-1 block w-full",modelValue:t.form.name,"onUpdate:modelValue":o[0]||(o[0]=s=>t.form.name=s),required:""},null,8,["modelValue"])]),a("div",O,[r(m,{value:e.__("Drug Description")},null,8,["value"]),r(c,{type:"text",class:"mt-1 block w-full",modelValue:t.form.description,"onUpdate:modelValue":o[1]||(o[1]=s=>t.form.description=s)},null,8,["modelValue"])]),a("div",R,[r(m,{value:e.__("Related Diagnosis")},null,8,["value"]),r(h,{modelValue:t.form.diagnose,"onUpdate:modelValue":o[2]||(o[2]=s=>t.form.diagnose=s),label:"name","hide-selected":!0,options:t.allDiagnosis,searchable:!0,multiple:!0,"track-by":"id",placeholder:"Select Diagnose"},null,8,["modelValue","options"])])])])],32)]),footer:l(()=>[a("div",G,[r(g,{onClick:o[4]||(o[4]=s=>n.CancelAddcustomer())},{default:l(()=>[u(p(e.__("Cancel")),1)]),_:1}),r(_,{class:F(["ms-2",{"opacity-25":t.form.processing}]),onClick:n.submit,disabled:t.form.processing},{default:l(()=>[u(p(e.__("Save")),1)]),_:1},8,["onClick","class","disabled"])])]),_:1},8,["show"])}const fe=I(q,[["render",H]]);export{fe as default};
