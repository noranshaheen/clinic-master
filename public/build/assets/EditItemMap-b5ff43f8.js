import{J as b}from"./ActionMessage-61e2ac70.js";import{J as I}from"./ActionSection-b2837b81.js";import{J as N}from"./Button-4bcf952d.js";import{J as E}from"./ConfirmationModal-25a9f4bd.js";import{J as A}from"./DangerButton-8bc4ac7b.js";import{J as v}from"./DialogModal-abac778c.js";import{J as S}from"./FormSection-88b4b82e.js";import{J as V}from"./Input-1c19b971.js";import{J as M}from"./Checkbox-4a56b901.js";import{J as w}from"./InputError-a5d97e62.js";import{J as j}from"./Label-df30c280.js";import{J as D}from"./SecondaryButton-713ac718.js";import{J as T}from"./SectionBorder-e50f0f2f.js";import{J as y}from"./ValidationErrors-d148bef4.js";import{M as k}from"./vue3-multiselect.umd.min-0e68115f.js";import{k as c,c as B,w as r,r as i,o as x,f,t as u,b as m,a,h as U,n as L}from"./app-150d5054.js";import{_ as W}from"./_plugin-vue_export-helper-c27b6911.js";import"./SectionTitle-3e354ea0.js";import"./Modal-af9a88ec.js";/* empty css            */const F={components:{JetActionMessage:b,JetActionSection:I,JetButton:N,JetConfirmationModal:E,JetDangerButton:A,JetDialogModal:v,JetFormSection:S,JetInput:V,JetCheckbox:M,JetInputError:w,JetLabel:j,JetSecondaryButton:D,JetSectionBorder:T,JetValidationErrors:y,Multiselect:k},props:{item_map:{Type:Object,default:null}},data(){return{errors:[],form:this.$inertia.form({MSCode:"",ETACode:"",ItemNameA:"",ItemNameE:"",Val_Diff:0}),eta_item:null,items:[],showDialog:!1}},methods:{ShowDialog(){this.item_map!==null&&(this.form.MSCode=this.item_map.MSCode,this.form.ETACode=this.item_map.ETACode,this.form.ItemNameA=this.item_map.ItemNameA,this.form.ItemNameE=this.item_map.ItemNameE,this.form.Val_Diff=this.item_map.Val_Diff),this.showDialog=!0,this.$nextTick(()=>{this.item_map!=null&&this.items!=null&&(this.eta_item=this.items.find(e=>e.itemCode===this.form.ETACode),this.updateETAItem())})},CancelDlg(){this.showDialog=!1},submit(){c.post(route("ms.items.map.update"),this.form).then(e=>{this.$store.dispatch("setSuccessFlashMessage",!0),this.processing=!1,this.form.reset(),this.form.processing=!1,this.showDialog=!1,setTimeout(()=>{window.location.reload()},500)}).catch(e=>{this.form.processing=!1,this.$page.props.errors=e.response.data.errors,this.errors=e.response.data.errors})},nameWithCode({codeNamePrimaryLang:e,codeNameSecondaryLang:t,itemCode:d}){return this.$page.props.locale=="ar"?d+" - "+t:d+" - "+e},updateETAItem(){this.eta_item&&((this.form.ItemNameA==null||this.form.ItemNameA.length<3)&&(this.form.ItemNameA=this.eta_item.codeNameSecondaryLang),(this.form.ItemNameE==null||this.form.ItemNameE.length<3)&&(this.form.ItemNameE=this.eta_item.codeNamePrimaryLang),this.form.ETACode=this.eta_item.itemCode)}},created(){c.get(route("json.eta.items")).then(e=>{this.items=e.data,this.item_map!=null&&(this.eta_item=this.items.find(t=>t.itemCode===this.form.ETACode),this.updateETAItem())}).catch(e=>{})}},P={class:"grid grid-cols-2 gap-4"},z={class:"col-span-2"},O={class:"col-span-2"},q={class:"col-span-1"},G={class:"col-span-1"},H={class:"flex items-center justify-end"};function K(e,t,d,Q,o,l){const h=i("jet-validation-errors"),n=i("jet-label"),p=i("jet-input"),_=i("multiselect"),g=i("jet-secondary-button"),C=i("jet-button"),J=i("jet-dialog-modal");return x(),B(J,{show:o.showDialog,maxWidth:"3xl",onClose:t[6]||(t[6]=s=>o.showDialog=!1)},{title:r(()=>[f(u(e.__("Item Map")),1)]),content:r(()=>[m(h,{class:"mb-4"}),a("form",{onSubmit:t[4]||(t[4]=U((...s)=>l.submit&&l.submit(...s),["prevent"]))},[a("div",P,[a("div",z,[m(n,{value:e.__("MSCode")},null,8,["value"]),m(p,{id:"MSCode",type:"text",class:"mt-1 block w-full",modelValue:o.form.MSCode,"onUpdate:modelValue":t[0]||(t[0]=s=>o.form.MSCode=s),disabled:!0},null,8,["modelValue"])]),a("div",O,[m(n,{value:e.__("ETACode")},null,8,["value"]),m(_,{modelValue:o.eta_item,"onUpdate:modelValue":[t[1]||(t[1]=s=>o.eta_item=s),l.updateETAItem],options:o.items,"custom-label":l.nameWithCode,label:"codeNamePrimaryLang","track-by":"itemCode",placeholder:e.__("Select item")},null,8,["modelValue","options","custom-label","onUpdate:modelValue","placeholder"])]),a("div",q,[m(n,{value:e.__("Name Arabic")},null,8,["value"]),m(p,{id:"MSCode",type:"text",class:"mt-1 block w-full",modelValue:o.form.ItemNameA,"onUpdate:modelValue":t[2]||(t[2]=s=>o.form.ItemNameA=s)},null,8,["modelValue"])]),a("div",G,[m(n,{value:e.__("Name English")},null,8,["value"]),m(p,{id:"MSCode",type:"text",class:"mt-1 block w-full",modelValue:o.form.ItemNameE,"onUpdate:modelValue":t[3]||(t[3]=s=>o.form.ItemNameE=s)},null,8,["modelValue"])])])],32)]),footer:r(()=>[a("div",H,[m(g,{onClick:t[5]||(t[5]=s=>l.CancelDlg())},{default:r(()=>[f(u(e.__("Cancel")),1)]),_:1}),m(C,{class:L(["ms-2",{"opacity-25":o.form.processing}]),onClick:l.submit,disabled:o.form.processing},{default:r(()=>[f(u(e.__("Save")),1)]),_:1},8,["onClick","class","disabled"])])]),_:1},8,["show"])}const he=W(F,[["render",K]]);export{he as default};