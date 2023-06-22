import{J as h}from"./Button-4bcf952d.js";import{J as g}from"./FormSection-88b4b82e.js";import{J as b}from"./Input-1c19b971.js";import{J as j}from"./InputError-a5d97e62.js";import{J as v}from"./Label-df30c280.js";import{_ as J}from"./_plugin-vue_export-helper-c27b6911.js";import{c as T,w as o,r as s,o as w,f as n,a as e,b as r,t as c,n as C}from"./app-150d5054.js";import"./SectionTitle-3e354ea0.js";/* empty css            */const V={components:{JetButton:h,JetFormSection:g,JetInput:b,JetInputError:j,JetLabel:v},data(){return{form:this.$inertia.form({name:""})}},methods:{createTeam(){this.form.post(route("teams.store"),{errorBag:"createTeam",preserveScroll:!0})}}},x={class:"col-span-6"},B={class:"flex items-center mt-2"},S=["src","alt"],y={class:"ms-4 leading-tight"},N={class:"text-gray-700 text-sm"},k={class:"col-span-6 sm:col-span-4"};function $(a,m,D,F,t,i){const l=s("jet-label"),p=s("jet-input"),u=s("jet-input-error"),_=s("jet-button"),d=s("jet-form-section");return w(),T(d,{onSubmitted:i.createTeam},{title:o(()=>[n(" Team Details ")]),description:o(()=>[n(" Create a new team to collaborate with others on projects. ")]),form:o(()=>[e("div",x,[r(l,{value:"Team Owner"}),e("div",B,[e("img",{class:"w-12 h-12 rounded-full object-cover",src:a.$page.props.auth.user.profile_photo_url,alt:a.$page.props.auth.user.name},null,8,S),e("div",y,[e("div",null,c(a.$page.props.auth.user.name),1),e("div",N,c(a.$page.props.auth.user.email),1)])])]),e("div",k,[r(l,{for:"name",value:"Team Name"}),r(p,{id:"name",type:"text",class:"mt-1 block w-full",modelValue:t.form.name,"onUpdate:modelValue":m[0]||(m[0]=f=>t.form.name=f),autofocus:""},null,8,["modelValue"]),r(u,{message:t.form.errors.name,class:"mt-2"},null,8,["message"])])]),actions:o(()=>[r(_,{class:C({"opacity-25":t.form.processing}),disabled:t.form.processing},{default:o(()=>[n(" Create ")]),_:1},8,["class","disabled"])]),_:1},8,["onSubmitted"])}const H=J(V,[["render",$]]);export{H as default};