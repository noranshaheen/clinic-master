import{A as c}from"./AppLayout-f49bf28b.js";import{J as f}from"./AuthenticationCard-b9e891bc.js";import{J as _}from"./Button-4bcf952d.js";import{J as b}from"./Input-1c19b971.js";import{J as w}from"./Checkbox-4a56b901.js";import{J as h}from"./Label-df30c280.js";import{J as v}from"./ValidationErrors-d148bef4.js";import{c as V,w as a,r as m,o as J,a as i,b as e,h as x,f as C,n as j}from"./app-150d5054.js";import{_ as y}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-bcfc13f2.js";import"./ActionMessage-61e2ac70.js";import"./ActionSection-b2837b81.js";import"./SectionTitle-3e354ea0.js";import"./ConfirmationModal-25a9f4bd.js";import"./Modal-af9a88ec.js";import"./DangerButton-8bc4ac7b.js";import"./DialogModal-abac778c.js";import"./FormSection-88b4b82e.js";import"./InputError-a5d97e62.js";import"./SecondaryButton-713ac718.js";import"./SectionBorder-e50f0f2f.js";/* empty css            */import"./Edit-0682400b.js";import"./TextField-3250345e.js";import"./Edit-3c089fa6.js";import"./Edit-be99b5ee.js";import"./Edit-597f2255.js";import"./Edit-f9922137.js";import"./vue3-multiselect.umd.min-0e68115f.js";import"./Edit-faa18d1d.js";import"./Edit-cd91fcb4.js";import"./Edit-07cd30d2.js";import"./Edit-34545e2b.js";import"./Edit-db4f3217.js";/* empty css                                                                  */import"./Load-49470aa5.js";import"./Load-63f267b7.js";import"./Edit-ae599c19.js";import"./Upload-84ea7cbc.js";import"./Upload-9f5fa312.js";import"./Settings-16afee17.js";import"./Settings-c1b5727e.js";import"./Upload-ac8dd442.js";import"./Request-7a72620a.js";import"./Add-a5bec431.js";import"./Load-9cedd89f.js";import"./Upload-8acddc09.js";import"./Load-38871443.js";import"./sweetalert.min-d55a1c1c.js";import"./ItemsMap-522638f4.js";import"./Upload-92e0933c.js";import"./ItemsMap-e43ca060.js";import"./RequestEx-92427893.js";const k={components:{AppLayout:c,JetAuthenticationCard:f,JetButton:_,JetInput:b,JetCheckbox:w,JetLabel:h,JetValidationErrors:v},data(){return{form:this.$inertia.form({name:"",eta_code:"",unit_price:""})}},methods:{submit(){this.form.post(this.route("items.store"),{onFinish:()=>this.form.reset("name, etapassword","password_confirmation")})}}},A=i("h1",null,"Create new item",-1),g={class:"bg-white px-12 pb-8 overflow-hidden shadow-xl sm:rounded-lg"},B={class:"mt-4"},E={class:"mt-4"},N={class:"flex items-center justify-end mt-4"};function T(U,o,q,L,t,n){const l=m("jet-validation-errors"),s=m("jet-label"),p=m("jet-input"),d=m("jet-button"),u=m("app-layout");return J(),V(u,null,{header:a(()=>[A]),default:a(()=>[i("div",g,[e(l,{class:"mb-4"}),i("form",{onSubmit:o[3]||(o[3]=x((...r)=>n.submit&&n.submit(...r),["prevent"]))},[i("div",null,[e(s,{for:"name",value:"Name"}),e(p,{id:"name",type:"text",class:"mt-1 block w-full",modelValue:t.form.name,"onUpdate:modelValue":o[0]||(o[0]=r=>t.form.name=r),required:"",autofocus:"",autocomplete:"name"},null,8,["modelValue"])]),i("div",B,[e(s,{for:"ETACode",value:"ETA Code"}),e(p,{id:"ETACode",type:"text",class:"mt-1 block w-full",modelValue:t.form.eta_code,"onUpdate:modelValue":o[1]||(o[1]=r=>t.form.eta_code=r),required:"",autocomplete:"eta-code"},null,8,["modelValue"])]),i("div",E,[e(s,{for:"unit_price",value:"Unit Price"}),e(p,{id:"unit_price",type:"password",class:"mt-1 block w-full",modelValue:t.form.unit_price,"onUpdate:modelValue":o[2]||(o[2]=r=>t.form.unit_price=r),required:"",autocomplete:"new-password"},null,8,["modelValue"])]),i("div",N,[e(d,{class:j(["ms-4",{"opacity-25":t.form.processing}]),disabled:t.form.processing},{default:a(()=>[C(" Save ")]),_:1},8,["class","disabled"])])],32)])]),_:1})}const So=y(k,[["render",T]]);export{So as default};