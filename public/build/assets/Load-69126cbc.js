import{J as c}from"./ActionMessage-c078ab58.js";import{J as f}from"./ActionSection-503f6cc4.js";import{J as g}from"./Button-caddf70d.js";import{J as _}from"./ConfirmationModal-747d8d1a.js";import{J}from"./DangerButton-0ca7bbd2.js";import{J as v}from"./DialogModal-08c723b0.js";import{J as x}from"./FormSection-f05163be.js";import{J as y}from"./Input-2cb00575.js";import{J as A}from"./Checkbox-0b804630.js";import{J as T}from"./InputError-1ce94fe9.js";import{J as E}from"./Label-715dcd10.js";import{J as V}from"./SecondaryButton-3445fa1d.js";import{J as w}from"./SectionBorder-30338fa4.js";import{J as b}from"./ValidationErrors-deb0d81a.js";import{_ as C}from"./_plugin-vue_export-helper-c27b6911.js";import{c as L,w as a,r as i,o as S,f as n,t,b as l,a as o}from"./app-5577a803.js";import"./SectionTitle-75c86d6b.js";import"./Modal-5b92d53d.js";/* empty css            */const k={components:{JetActionMessage:c,JetActionSection:f,JetButton:g,JetConfirmationModal:_,JetDangerButton:J,JetDialogModal:v,JetFormSection:x,JetInput:y,JetCheckbox:A,JetInputError:T,JetLabel:E,JetSecondaryButton:V,JetSectionBorder:w,JetValidationErrors:b},props:["branch"],data(){return{errors:[],progress:{value:0,maxValue:100},form:{value:0,type:"EGS"},addingNew:!1}},methods:{ShowDialog(){this.addingNew=!0,this.$nextTick(()=>this.LoadETA())},CancelAdd(){this.addingNew=!1},LoadETA(){this.form.value=this.progress.value+1,axios.post(route("eta.items.sync"),this.form).then(s=>{this.progress.maxValue=s.data.totalPages,this.progress.value=this.progress.value+1,this.progress.value<this.progress.maxValue?this.$nextTick(()=>this.LoadETA()):this.form.type=="EGS"?(this.progress.maxValue=0,this.progress.value=0,this.form.type="GS1",this.$nextTick(()=>this.LoadETA())):(this.progress.maxValue=0,this.progress.value=0,this.form.type="Requests",this.LoadETARequests())}).catch(s=>{this.$page.props.errors=s.response.data.errors,this.errors=s.response.data.errors})},LoadETARequests(){this.form.value=this.progress.value+1,axios.post(route("eta.items.requests.sync"),this.form).then(s=>{this.progress.maxValue=s.data.totalPages,this.progress.value=this.progress.value+1,this.progress.value<this.progress.maxValue?this.$nextTick(()=>this.LoadETARequests()):this.CancelAdd()}).catch(s=>{this.$page.props.errors=s.response.data.errors,this.errors=s.response.data.errors})},submit(){}}},N={for:"sync"},j=o("br",null,null,-1),B=["value","max"],q={class:"flex items-center justify-end mt-4"};function D(s,r,$,R,e,m){const p=i("jet-validation-errors"),d=i("jet-secondary-button"),u=i("jet-dialog-modal");return S(),L(u,{show:e.addingNew,onClose:r[1]||(r[1]=h=>e.addingNew=!1)},{title:a(()=>[n(t(s.__("Loading items from ETA")),1)]),content:a(()=>[l(p,{class:"mb-4"}),o("div",null,[o("label",N,t(s.__("Synchronizing"))+" "+t(e.form.type),1),j,o("progress",{class:"w-full",id:"sync",value:e.progress.value,max:e.progress.maxValue},t(e.progress.value)+"% ",9,B)])]),footer:a(()=>[o("div",q,[l(d,{onClick:r[0]||(r[0]=h=>m.CancelAdd())},{default:a(()=>[n(t(s.__("Cancel")),1)]),_:1})])]),_:1},8,["show"])}const rs=C(k,[["render",D]]);export{rs as default};
