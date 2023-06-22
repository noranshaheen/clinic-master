import{J as F}from"./ActionSection-b2837b81.js";import{J as v}from"./Button-4bcf952d.js";import{J}from"./DialogModal-abac778c.js";import{J as P}from"./Input-1c19b971.js";import{J as T}from"./InputError-a5d97e62.js";import{J as x}from"./SecondaryButton-713ac718.js";import{o as s,d as i,a,s as S,b as n,w as o,f as c,t as p,bs as R,n as C,r as d,c as b,e as f,F as A,g as B}from"./app-150d5054.js";import{_ as k}from"./_plugin-vue_export-helper-c27b6911.js";import{J as E}from"./DangerButton-8bc4ac7b.js";import"./SectionTitle-3e354ea0.js";import"./Modal-af9a88ec.js";/* empty css            */const M={emits:["confirmed"],props:{title:{default:"Confirm Password"},content:{default:"For your security, please confirm your password to continue."},button:{default:"Confirm"}},components:{JetButton:v,JetDialogModal:J,JetInput:P,JetInputError:T,JetSecondaryButton:x},data(){return{confirmingPassword:!1,form:{password:"",error:""}}},methods:{startConfirmingPassword(){axios.get(route("password.confirmation")).then(r=>{r.data.confirmed?this.$emit("confirmed"):(this.confirmingPassword=!0,setTimeout(()=>this.$refs.password.focus(),250))})},confirmPassword(){this.form.processing=!0,axios.post(route("password.confirm"),{password:this.form.password}).then(()=>{this.form.processing=!1,this.closeModal(),this.$nextTick(()=>this.$emit("confirmed"))}).catch(r=>{this.form.processing=!1,this.form.error=r.response.data.errors.password[0],this.$refs.password.focus()})},closeModal(){this.confirmingPassword=!1,this.form.password="",this.form.error=""}}},V={class:"mt-4"};function q(r,u,h,j,e,t){const w=d("jet-input"),l=d("jet-input-error"),_=d("jet-secondary-button"),g=d("jet-button"),y=d("jet-dialog-modal");return s(),i("span",null,[a("span",{onClick:u[0]||(u[0]=(...m)=>t.startConfirmingPassword&&t.startConfirmingPassword(...m))},[S(r.$slots,"default")]),n(y,{show:e.confirmingPassword,onClose:t.closeModal},{title:o(()=>[c(p(h.title),1)]),content:o(()=>[c(p(h.content)+" ",1),a("div",V,[n(w,{type:"password",class:"mt-1 block w-3/4",placeholder:"Password",ref:"password",modelValue:e.form.password,"onUpdate:modelValue":u[1]||(u[1]=m=>e.form.password=m),onKeyup:R(t.confirmPassword,["enter"])},null,8,["modelValue","onKeyup"]),n(l,{message:e.form.error,class:"mt-2"},null,8,["message"])])]),footer:o(()=>[n(_,{onClick:t.closeModal},{default:o(()=>[c(" Cancel ")]),_:1},8,["onClick"]),n(g,{class:C(["ms-2",{"opacity-25":e.form.processing}]),onClick:t.confirmPassword,disabled:e.form.processing},{default:o(()=>[c(p(h.button),1)]),_:1},8,["onClick","class","disabled"])]),_:1},8,["show","onClose"])])}const D=k(M,[["render",q]]),N={components:{JetActionSection:F,JetButton:v,JetConfirmsPassword:D,JetDangerButton:E,JetSecondaryButton:x},data(){return{enabling:!1,disabling:!1,qrCode:null,recoveryCodes:[]}},methods:{enableTwoFactorAuthentication(){this.enabling=!0,this.$inertia.post("/user/two-factor-authentication",{},{preserveScroll:!0,onSuccess:()=>Promise.all([this.showQrCode(),this.showRecoveryCodes()]),onFinish:()=>this.enabling=!1})},showQrCode(){return axios.get("/user/two-factor-qr-code").then(r=>{this.qrCode=r.data.svg})},showRecoveryCodes(){return axios.get("/user/two-factor-recovery-codes").then(r=>{this.recoveryCodes=r.data})},regenerateRecoveryCodes(){axios.post("/user/two-factor-recovery-codes").then(r=>{this.showRecoveryCodes()})},disableTwoFactorAuthentication(){this.disabling=!0,this.$inertia.delete("/user/two-factor-authentication",{preserveScroll:!0,onSuccess:()=>this.disabling=!1})}},computed:{twoFactorEnabled(){return!this.enabling&&this.$page.props.auth.user.two_factor_enabled}}},K={key:0,class:"text-lg font-medium text-gray-900"},L={key:1,class:"text-lg font-medium text-gray-900"},Q=a("div",{class:"mt-3 max-w-xl text-sm text-gray-600"},[a("p",null," When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application. ")],-1),Y={key:2},H={key:0},I=a("div",{class:"mt-4 max-w-xl text-sm text-gray-600"},[a("p",{class:"font-semibold"}," Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator application. ")],-1),z=["innerHTML"],G={key:1},U=a("div",{class:"mt-4 max-w-xl text-sm text-gray-600"},[a("p",{class:"font-semibold"}," Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost. ")],-1),W={class:"grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg"},O={class:"mt-5"},X={key:0},Z={key:1};function $(r,u,h,j,e,t){const w=d("jet-button"),l=d("jet-confirms-password"),_=d("jet-secondary-button"),g=d("jet-danger-button"),y=d("jet-action-section");return s(),b(y,null,{title:o(()=>[c(" Two Factor Authentication ")]),description:o(()=>[c(" Add additional security to your account using two factor authentication. ")]),content:o(()=>[t.twoFactorEnabled?(s(),i("h3",K," You have enabled two factor authentication. ")):(s(),i("h3",L," You have not enabled two factor authentication. ")),Q,t.twoFactorEnabled?(s(),i("div",Y,[e.qrCode?(s(),i("div",H,[I,a("div",{class:"mt-4",innerHTML:e.qrCode},null,8,z)])):f("",!0),e.recoveryCodes.length>0?(s(),i("div",G,[U,a("div",W,[(s(!0),i(A,null,B(e.recoveryCodes,m=>(s(),i("div",{key:m},p(m),1))),128))])])):f("",!0)])):f("",!0),a("div",O,[t.twoFactorEnabled?(s(),i("div",Z,[n(l,{onConfirmed:t.regenerateRecoveryCodes},{default:o(()=>[e.recoveryCodes.length>0?(s(),b(_,{key:0,class:"mr-3"},{default:o(()=>[c(" Regenerate Recovery Codes ")]),_:1})):f("",!0)]),_:1},8,["onConfirmed"]),n(l,{onConfirmed:t.showRecoveryCodes},{default:o(()=>[e.recoveryCodes.length===0?(s(),b(_,{key:0,class:"mr-3"},{default:o(()=>[c(" Show Recovery Codes ")]),_:1})):f("",!0)]),_:1},8,["onConfirmed"]),n(l,{onConfirmed:t.disableTwoFactorAuthentication},{default:o(()=>[n(g,{class:C({"opacity-25":e.disabling}),disabled:e.disabling},{default:o(()=>[c(" Disable ")]),_:1},8,["class","disabled"])]),_:1},8,["onConfirmed"])])):(s(),i("div",X,[n(l,{onConfirmed:t.enableTwoFactorAuthentication},{default:o(()=>[n(w,{type:"button",class:C({"opacity-25":e.enabling}),disabled:e.enabling},{default:o(()=>[c(" Enable ")]),_:1},8,["class","disabled"])]),_:1},8,["onConfirmed"])]))])]),_:1})}const ue=k(N,[["render",$]]);export{ue as default};