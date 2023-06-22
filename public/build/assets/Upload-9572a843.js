import{J as c}from"./ActionMessage-517545cc.js";import{J}from"./ActionSection-2c866042.js";import{J as _}from"./Button-11813b5e.js";import{J as g}from"./ConfirmationModal-0f300aca.js";import{J as C}from"./DangerButton-367e534b.js";import{J as h}from"./DialogModal-22356253.js";import{J as b}from"./FormSection-bd296fee.js";import{J as F}from"./Input-8a286b7b.js";import{J as v}from"./Checkbox-ebdeef89.js";import{J as j}from"./InputError-317c03cf.js";import{J as w}from"./Label-e291ccc6.js";import{J as x}from"./SecondaryButton-8a1eaf86.js";import{J as y}from"./SectionBorder-822e764c.js";import{_ as B}from"./_plugin-vue_export-helper-c27b6911.js";import{c as D,w as t,r as m,o as S,f as n,t as s,a as r,b as p}from"./app-010fad37.js";import"./SectionTitle-8abeab5a.js";import"./Modal-97755a3c.js";/* empty css            */const U={components:{JetActionMessage:c,JetActionSection:J,JetButton:_,JetConfirmationModal:g,JetDangerButton:C,JetDialogModal:h,JetFormSection:b,JetInput:F,JetCheckbox:v,JetInputError:j,JetLabel:w,JetSecondaryButton:x,JetSectionBorder:y},data(){return{file:"",uploadingCustomers:!1,processing:!1}},methods:{ShowDialog(){this.uploadingCustomers=!0},CancelAddCustomer(){this.uploadingCustomers=!1},handleFileUpload(o){this.file=o.target.files[0]},submitFile(){let o=new FormData;o.append("file",this.file),this.processing=!0;let e=this;axios.post(route("eta.customer.upload"),o,{headers:{"Content-Type":"multipart/form-data"}}).then(function(){e.processing=!1,e.$refs.inputFile.value=null,e.closeModal()}).catch(function(){e.processing=!1,e.$refs.inputFile.value=null,console.log("FAILURE!!")})}}},k={class:"grid grid-cols-3 md:grid-cols-3 gap-4"},A={class:"flex justify-end"},M={href:"/ExcelTemplates/CustomerUpload.xlsx"};function E(o,e,I,N,l,i){const d=m("jet-secondary-button"),u=m("jet-button"),f=m("jet-dialog-modal");return S(),D(f,{show:l.uploadingCustomers,onClose:e[3]||(e[3]=a=>l.uploadingCustomers=!1)},{title:t(()=>[n(s(o.__("Upload Customers")),1)]),content:t(()=>[r("div",k,[r("label",null,[n(s(o.__("Choose File"))+" ",1),r("input",{type:"file",onChange:e[0]||(e[0]=a=>i.handleFileUpload(a)),ref:"inputFile"},null,544)])]),r("div",A,[r("a",M,s(o.__("Download excel template")),1)])]),footer:t(()=>[p(d,{onClick:e[1]||(e[1]=a=>i.CancelAddCustomer())},{default:t(()=>[n(s(o.__("Cancel")),1)]),_:1}),p(u,{class:"ms-2",onClick:e[2]||(e[2]=a=>i.submitFile()),disabled:l.processing},{default:t(()=>[n(s(o.__("Save")),1)]),_:1},8,["disabled"])]),_:1},8,["show"])}const oe=B(U,[["render",E]]);export{oe as default};