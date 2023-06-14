import{J as y}from"./Button-4bcf952d.js";import{J as g}from"./SecondaryButton-713ac718.js";import{J as b}from"./DialogModal-abac778c.js";import{M as C}from"./vue3-multiselect.umd.min-0e68115f.js";import{k as f,d as w,b as a,w as n,r as i,o as D,f as m,t as p,a as l,i as d,D as u}from"./app-150d5054.js";import{s as S}from"./sweetalert.min-d55a1c1c.js";import{_ as V}from"./_plugin-vue_export-helper-c27b6911.js";import"./Modal-af9a88ec.js";/* empty css            */const P={components:{JetButton:y,JetSecondaryButton:g,JetDialogModal:b,Multiselect:C},props:{appointment_id:{default:null}},data(){return{showDialog:!1,form:this.$inertia.form({patient:"",type:""}),allPatients:[],errors:[]}},methods:{ShowDialog(){this.showDialog=!0},nameWithCode({id:t,name:e}){return t+" - "+e},onSave(){this.form.patient==""?S("Please select a patient !",{icon:"error"}):f.post(route("appointment.reserve",{appointment_id:this.appointment_id}),{form:this.form}).then(t=>{this.$store.dispatch("setSuccessFlashMessage",!0),this.showDialog=!1,this.$emit("Save")}).catch(t=>{console.log(t),this.$page.props.errors=t.response.data.errors,this.errors=t.response.data.errors})},onCancel(){this.showDialog=!1}},created(){f.get(route("patient.all")).then(t=>{this.allPatients=t.data})}},j={class:"mb-2 border-b"},J={class:"mb-2"},k=l("label",{for:"1",class:"ml-2"},"Normal",-1),B={class:"mb-2"},M=l("label",{for:"2",class:"ml-2"},"Emergency",-1),N={class:"mb-2"},U=l("label",{for:"3",class:"ml-2"},"Consultation",-1);function x(t,e,E,W,o,r){const c=i("multiselect"),_=i("jet-button"),h=i("jet-secondary-button"),v=i("jet-dialog-modal");return D(),w("div",null,[a(v,{show:o.showDialog,onClose:e[6]||(e[6]=s=>o.showDialog=!1),maxWidth:"md"},{title:n(()=>[m(p(t.__("Choose Patient Dialog")),1)]),content:n(()=>[l("div",j,[l("div",J,[d(l("input",{id:"1",type:"radio",name:"type",value:"Normal","onUpdate:modelValue":e[0]||(e[0]=s=>o.form.type=s)},null,512),[[u,o.form.type]]),k]),l("div",B,[d(l("input",{id:"2",type:"radio",name:"type",value:"Emergency","onUpdate:modelValue":e[1]||(e[1]=s=>o.form.type=s)},null,512),[[u,o.form.type]]),M]),l("div",N,[d(l("input",{id:"3",type:"radio",name:"type",value:"Consultation","onUpdate:modelValue":e[2]||(e[2]=s=>o.form.type=s)},null,512),[[u,o.form.type]]),U])]),a(c,{modelValue:o.form.patient,"onUpdate:modelValue":e[3]||(e[3]=s=>o.form.patient=s),label:"name",options:o.allPatients,"custom-label":r.nameWithCode,placeholder:t.__("Select Patient")},null,8,["modelValue","options","custom-label","placeholder"])]),footer:n(()=>[a(_,{onClick:e[4]||(e[4]=s=>r.onSave()),class:"m-1"},{default:n(()=>[m(p(t.__("Save")),1)]),_:1}),a(h,{onClick:e[5]||(e[5]=s=>r.onCancel()),class:"m-1"},{default:n(()=>[m(p(t.__("Cancel")),1)]),_:1})]),_:1},8,["show"])])}const K=V(P,[["render",x]]);export{K as default};
