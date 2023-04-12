import{J as w}from"./ActionMessage-c078ab58.js";import{J as _}from"./Button-caddf70d.js";import{J as g}from"./FormSection-f05163be.js";import{J as b}from"./Input-2cb00575.js";import{J as j}from"./InputError-1ce94fe9.js";import{J}from"./Label-715dcd10.js";import{_ as V}from"./_plugin-vue_export-helper-c27b6911.js";import{c as v,w as e,r as t,o as h,f as n,a as l,b as o,n as P}from"./app-5577a803.js";import"./SectionTitle-75c86d6b.js";/* empty css            */const S={components:{JetActionMessage:w,JetButton:_,JetFormSection:g,JetInput:b,JetInputError:j,JetLabel:J},data(){return{form:this.$inertia.form({current_password:"",password:"",password_confirmation:""})}},methods:{updatePassword(){this.form.put(route("user-password.update"),{errorBag:"updatePassword",preserveScroll:!0,onSuccess:()=>this.form.reset(),onError:()=>{this.form.errors.password&&(this.form.reset("password","password_confirmation"),this.$refs.password.focus()),this.form.errors.current_password&&(this.form.reset("current_password"),this.$refs.current_password.focus())}})}}},y={class:"col-span-6 sm:col-span-4"},k={class:"col-span-6 sm:col-span-4"},x={class:"col-span-6 sm:col-span-4"};function B(C,r,U,N,s,d){const m=t("jet-label"),p=t("jet-input"),c=t("jet-input-error"),i=t("jet-action-message"),u=t("jet-button"),f=t("jet-form-section");return h(),v(f,{onSubmitted:d.updatePassword},{title:e(()=>[n(" Update Password ")]),description:e(()=>[n(" Ensure your account is using a long, random password to stay secure. ")]),form:e(()=>[l("div",y,[o(m,{for:"current_password",value:"Current Password"}),o(p,{id:"current_password",type:"password",class:"mt-1 block w-full",modelValue:s.form.current_password,"onUpdate:modelValue":r[0]||(r[0]=a=>s.form.current_password=a),ref:"current_password",autocomplete:"current-password"},null,8,["modelValue"]),o(c,{message:s.form.errors.current_password,class:"mt-2"},null,8,["message"])]),l("div",k,[o(m,{for:"password",value:"New Password"}),o(p,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:s.form.password,"onUpdate:modelValue":r[1]||(r[1]=a=>s.form.password=a),ref:"password",autocomplete:"new-password"},null,8,["modelValue"]),o(c,{message:s.form.errors.password,class:"mt-2"},null,8,["message"])]),l("div",x,[o(m,{for:"password_confirmation",value:"Confirm Password"}),o(p,{id:"password_confirmation",type:"password",class:"mt-1 block w-full",modelValue:s.form.password_confirmation,"onUpdate:modelValue":r[2]||(r[2]=a=>s.form.password_confirmation=a),autocomplete:"new-password"},null,8,["modelValue"]),o(c,{message:s.form.errors.password_confirmation,class:"mt-2"},null,8,["message"])])]),actions:e(()=>[o(i,{on:s.form.recentlySuccessful,class:"mr-3"},{default:e(()=>[n(" Saved. ")]),_:1},8,["on"]),o(u,{class:P({"opacity-25":s.form.processing}),disabled:s.form.processing},{default:e(()=>[n(" Save ")]),_:1},8,["class","disabled"])]),_:1},8,["onSubmitted"])}const G=V(S,[["render",B]]);export{G as default};
