import{A as d}from"./AppLayout-f49bf28b.js";import{_ as c}from"./_plugin-vue_export-helper-c27b6911.js";import{c as l,w as u,r as g,o as p,a as t,t as o,d as a,g as v,F as _,n as m}from"./app-150d5054.js";import"./Edit-bcfc13f2.js";import"./ActionMessage-61e2ac70.js";import"./ActionSection-b2837b81.js";import"./SectionTitle-3e354ea0.js";import"./Button-4bcf952d.js";import"./ConfirmationModal-25a9f4bd.js";import"./Modal-af9a88ec.js";import"./DangerButton-8bc4ac7b.js";import"./DialogModal-abac778c.js";import"./FormSection-88b4b82e.js";import"./Input-1c19b971.js";import"./Checkbox-4a56b901.js";import"./InputError-a5d97e62.js";import"./Label-df30c280.js";import"./SecondaryButton-713ac718.js";import"./SectionBorder-e50f0f2f.js";import"./ValidationErrors-d148bef4.js";import"./Edit-0682400b.js";import"./TextField-3250345e.js";import"./Edit-3c089fa6.js";import"./Edit-be99b5ee.js";import"./Edit-597f2255.js";import"./Edit-f9922137.js";import"./vue3-multiselect.umd.min-0e68115f.js";import"./Edit-faa18d1d.js";import"./Edit-cd91fcb4.js";import"./Edit-07cd30d2.js";import"./Edit-34545e2b.js";import"./Edit-db4f3217.js";/* empty css                                                                  */import"./Load-49470aa5.js";import"./Load-63f267b7.js";import"./Edit-ae599c19.js";import"./Upload-84ea7cbc.js";import"./Upload-9f5fa312.js";import"./Settings-16afee17.js";import"./Settings-c1b5727e.js";import"./Upload-ac8dd442.js";import"./Request-7a72620a.js";import"./Add-a5bec431.js";import"./Load-9cedd89f.js";import"./Upload-8acddc09.js";import"./Load-38871443.js";import"./sweetalert.min-d55a1c1c.js";import"./ItemsMap-522638f4.js";import"./Upload-92e0933c.js";import"./ItemsMap-e43ca060.js";import"./RequestEx-92427893.js";/* empty css            */const y={components:{AppLayout:d},props:{items:Array,total_credit:Number,total_debit:Number,net_profit:Number}},f={class:"w-full flex justify-center"},b={class:"grid grid-cols-3 divide-x divide-y w-1/2 bg-white p-4 striped"},h={class:"p-2 bg-gray-400"},w={class:"p-2 bg-gray-400"},k={class:"p-2 bg-gray-400"},A={class:"p-2 bg-gray-400"},N={class:"p-2 bg-gray-400"},B={class:"p-2 bg-gray-400"},C={class:"p-2 bg-gray-200"},D={class:"p-2 bg-green-50 col-span-2 flex justify-center"};function F(i,S,e,j,x,L){const n=g("app-layout");return p(),l(n,null,{default:u(()=>[t("div",f,[t("div",b,[t("div",h,o(i.__("Description")),1),t("div",w,o(i.__("Debit Amount")),1),t("div",k,o(i.__("Credit Amount")),1),(p(!0),a(_,null,v(e.items,(r,R,s)=>(p(),a(_,{key:r.id},[t("div",{class:m(["p-2",s%2==1?"dark-row":""])},o(r.name)+"("+o(r.id)+")",3),t("div",{class:m(["p-2",s%2==1?"dark-row":""])},o(r.debit_amount),3),t("div",{class:m(["p-2",s%2==1?"dark-row":""])},o(r.credit_amount),3)],64))),128)),t("div",A,o(i.__("Total")),1),t("div",N,o(e.total_debit),1),t("div",B,o(e.total_credit),1),t("div",C,o(i.__("Net Profit")),1),t("div",D,o(e.net_profit.toFixed(2)),1)])])]),_:1})}const Lt=c(y,[["render",F]]);export{Lt as default};