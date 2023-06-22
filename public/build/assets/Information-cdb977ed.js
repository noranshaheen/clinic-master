import{J as _}from"./ActionMessage-61e2ac70.js";import{J as p}from"./ActionSection-b2837b81.js";import{J}from"./Button-4bcf952d.js";import{J as h}from"./ConfirmationModal-25a9f4bd.js";import{J as u}from"./DangerButton-8bc4ac7b.js";import{J as g}from"./DialogModal-abac778c.js";import{J as b}from"./FormSection-88b4b82e.js";import{J as w}from"./Input-1c19b971.js";import{J as D}from"./Checkbox-4a56b901.js";import{J as C}from"./InputError-a5d97e62.js";import{J as B}from"./Label-df30c280.js";import{J as j}from"./SecondaryButton-713ac718.js";import{J as y}from"./SectionBorder-e50f0f2f.js";import{J as I}from"./ValidationErrors-d148bef4.js";import{_ as S}from"./_plugin-vue_export-helper-c27b6911.js";import{c as k,w as a,r as i,o as v,f as l,t as o,a as t,b as x}from"./app-150d5054.js";import"./SectionTitle-3e354ea0.js";import"./Modal-af9a88ec.js";/* empty css            */const A={components:{JetActionMessage:_,JetActionSection:p,JetButton:J,JetConfirmationModal:h,JetDangerButton:u,JetDialogModal:g,JetFormSection:b,JetInput:w,JetCheckbox:D,JetInputError:C,JetLabel:B,JetSecondaryButton:j,JetSectionBorder:y,JetValidationErrors:I},props:{patient:{Type:Object,default:null}},data(){return{prescription_detail:"",showDialog:!1}},methods:{ShowDialog(){console.log(this.patient),this.showDialog=!0},CancelAddcustomer(){this.showDialog=!1}}},N={class:"w-full"},V={class:"border"},F={class:"p-2 font-bold text-center bg-[#f8f9fa]"},M={class:"p-2"},E={class:"border"},O={class:"p-2 font-bold text-center bg-[#f8f9fa]"},P={class:"p-2"},T={class:"border"},Y={class:"p-2 font-bold text-center bg-[#f8f9fa]"},G={class:"p-2"},L={class:"flex items-center justify-end"};function q(e,s,r,z,n,d){const m=i("jet-secondary-button"),c=i("jet-dialog-modal");return v(),k(c,{show:n.showDialog,onClose:s[1]||(s[1]=f=>n.showDialog=!1)},{title:a(()=>[l(o(e.__("Pateint Information")),1)]),content:a(()=>[t("div",null,[t("table",N,[t("tr",V,[t("td",F,o(e.__("Name")),1),t("td",M,o(r.patient.name),1)]),t("tr",E,[t("td",O,o(e.__("Age")),1),t("td",P,o(new Date().getFullYear()-new Date(r.patient.date_of_birth).getFullYear()),1)]),t("tr",T,[t("td",Y,o(e.__("General Information")),1),t("td",G,o(r.patient.additionalInformation),1)])])])]),footer:a(()=>[t("div",L,[x(m,{onClick:s[0]||(s[0]=f=>d.CancelAddcustomer())},{default:a(()=>[l(o(e.__("Ok")),1)]),_:1})])]),_:1},8,["show"])}const mt=S(A,[["render",q]]);export{mt as default};