import{M as i}from"./Modal-97755a3c.js";import{_ as d}from"./_plugin-vue_export-helper-c27b6911.js";import{o as r,c as m,w as h,a as t,s as l,r as _}from"./app-010fad37.js";const f={emits:["close"],components:{Modal:i},props:{show:{default:!1},maxWidth:{default:"2xl"},closeable:{default:!0}},methods:{close(){this.$emit("close")}}},p={class:"text-lg px-6 py-3 relative bg-[#4099de] text-white"},u=t("i",{class:"fa fa-times"},null,-1),x=[u],b=t("hr",{class:"mb-5"},null,-1),w={class:"mt-4 px-6 pb-4"},v=t("hr",{class:"mt-5"},null,-1),g={class:"px-6 py-4 text-right"};function C(s,a,e,k,y,o){const c=_("modal");return r(),m(c,{show:e.show,"max-width":e.maxWidth,closeable:e.closeable,onClose:o.close},{default:h(()=>[t("div",null,[t("div",p,[l(s.$slots,"title"),t("button",{class:"self-center px-5 py-1 absolute top-0 rtl:left-0 ltr:right-0 bottom-0",onClick:a[0]||(a[0]=(...n)=>o.close&&o.close(...n))},x)]),b,t("div",w,[l(s.$slots,"content")])]),v,t("div",g,[l(s.$slots,"footer")])]),_:3},8,["show","max-width","closeable","onClose"])}const W=d(f,[["render",C]]);export{W as J};