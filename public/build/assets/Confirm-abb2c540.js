import{J as f}from"./Button-caddf70d.js";import{J as _}from"./DialogModal-08c723b0.js";import{J as u}from"./Input-2cb00575.js";import{J as p}from"./InputError-1ce94fe9.js";import{J as h}from"./SecondaryButton-3445fa1d.js";import{_ as w}from"./_plugin-vue_export-helper-c27b6911.js";import{o as C,c as g,w as o,f as s,t as a,s as J,b as r,r as n}from"./app-5577a803.js";const k={emits:["confirmed"],props:{message:{default:"Are you sure?"},item:null,title:{default:"Confirmation"}},components:{JetButton:f,JetDialogModal:_,JetInput:u,JetInputError:p,JetSecondaryButton:h},data(){return{showDialog:!1}},methods:{ShowModal(){this.showDialog=!0},confirm(){this.$nextTick(()=>this.$emit("confirmed")),this.showDialog=!1},closeModal(){this.showDialog=!1}}};function D(t,j,l,b,i,e){const c=n("jet-secondary-button"),m=n("jet-button"),d=n("jet-dialog-modal");return C(),g(d,{show:i.showDialog,onClose:e.closeModal,"max-width":"xl"},{title:o(()=>[s(a(t.__(l.title)),1)]),content:o(()=>[J(t.$slots,"default")]),footer:o(()=>[r(c,{onClick:e.closeModal},{default:o(()=>[s(a(t.__("No")),1)]),_:1},8,["onClick"]),r(m,{class:"ms-2",onClick:e.confirm},{default:o(()=>[s(a(t.__("Yes")),1)]),_:1},8,["onClick"])]),_:3},8,["show","onClose"])}const T=w(k,[["render",D]]);export{T as C};
