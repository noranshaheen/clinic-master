import{A as w}from"./AppLayout-b94f7417.js";import{C}from"./Confirm-84247334.js";import b from"./Edit-74f06fe7.js";import{O as x}from"./inertiajs-tables-laravel-query-builder.es-c04de20d.js";import{J as k}from"./SecondaryButton-8a1eaf86.js";import{J as S}from"./Button-11813b5e.js";import{k as B,c as $,w as e,r,o as D,b as s,f as p,t as m,a,p as I,l as T}from"./app-010fad37.js";import{_ as j}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-a73070bb.js";import"./ActionMessage-517545cc.js";import"./ActionSection-2c866042.js";import"./SectionTitle-8abeab5a.js";import"./ConfirmationModal-0f300aca.js";import"./Modal-97755a3c.js";import"./DangerButton-367e534b.js";import"./DialogModal-22356253.js";import"./FormSection-bd296fee.js";import"./Input-8a286b7b.js";import"./Checkbox-ebdeef89.js";import"./TextField-f89d8302.js";import"./Label-e291ccc6.js";import"./InputError-317c03cf.js";import"./SectionBorder-822e764c.js";import"./ValidationErrors-31471297.js";/* empty css            */import"./Edit-7abb2ae3.js";import"./Edit-18d907dc.js";import"./Edit-16ea2851.js";import"./Edit-b486f9ab.js";import"./vue3-multiselect.umd.min-939aa207.js";import"./Edit-ec7eaf71.js";import"./Edit-b040ada8.js";import"./Edit-f6f19305.js";import"./Edit-67e94b24.js";import"./Edit-a5179c0a.js";/* empty css                                                                  */import"./Load-dcf8a148.js";import"./Load-b22526f9.js";import"./Edit-dd846932.js";import"./Upload-b17b92a3.js";import"./Upload-4dcf9d8b.js";import"./Upload-12291f8c.js";import"./Upload-1ea272cb.js";import"./Settings-f203d5a5.js";import"./Settings-3720bcf6.js";import"./Upload-3f1630e8.js";import"./Request-86128435.js";import"./Add-dd2dde44.js";import"./Load-a5c84528.js";import"./Upload-484af51f.js";import"./Load-6372f5e6.js";import"./sweetalert.min-679d9ee2.js";import"./ItemsMap-0f9ec3d1.js";import"./Upload-cd794d3e.js";import"./ItemsMap-5b7489db.js";import"./RequestEx-322cc660.js";const J={components:{EditDoctor:b,Confirm:C,AppLayout:w,Table:x,SecondaryButton:k,JetButton:S},props:{doctors:Object},data(){return{doctor:Object}},methods:{editCustomer(o){this.doctor=o,this.$nextTick(()=>this.$refs.dlg2.ShowDialog())},removeCustomer(o){this.doctor=o,this.$refs.dlg1.ShowModal()},remove(){B.delete(route("doctors.destroy",{doctor:this.doctor.id})).then(o=>{this.$store.dispatch("setSuccessFlashMessage",!0),setTimeout(()=>{window.location.reload()},500)}).catch(o=>{})},showColumn(o){if(!this.$inertia.page.props.queryBuilderProps.default.columns)return!1;const i=this.$inertia.page.props.queryBuilderProps.default.columns.find(n=>n.key===o);return i?!i.hidden:!1}}},d=o=>(I("data-v-efe3e5ce"),o=o(),T(),o),O={class:"py-4"},A={class:"mx-auto sm:px-6 lg:px-8"},F={class:"wrapper Gbg-white shadow-xl sm:rounded-lg p-4"},N=d(()=>a("i",{class:"fa fa-edit"},null,-1)),V=d(()=>a("i",{class:"fa fa-trash"},null,-1));function q(o,i,n,E,l,c){const _=r("edit-doctor"),u=r("confirm"),f=r("secondary-button"),h=r("jet-button"),y=r("Table"),g=r("app-layout");return D(),$(g,null,{default:e(()=>[s(_,{ref:"dlg2",doctor:l.doctor},null,8,["doctor"]),s(u,{ref:"dlg1",onConfirmed:i[0]||(i[0]=t=>c.remove())},{default:e(()=>[p(m(o.__("Are you sure you want to delete this doctor?")),1)]),_:1},512),a("div",O,[a("div",A,[a("div",F,[s(y,{resource:n.doctors},{"cell(date_of_birth)":e(({item:t})=>[p(m(new Date().getFullYear()-new Date(t.date_of_birth).getFullYear()),1)]),"cell(specialty_id)":e(({item:t})=>[p(m(t.specialties.name),1)]),"cell(actions)":e(({item:t})=>[s(f,{onClick:v=>c.editCustomer(t)},{default:e(()=>[N,p(" "+m(o.__("Edit")),1)]),_:2},1032,["onClick"]),s(h,{class:"ms-2",onClick:v=>c.removeCustomer(t)},{default:e(()=>[V,p(" "+m(o.__("Delete")),1)]),_:2},1032,["onClick"])]),_:1},8,["resource"])])])])]),_:1})}const Go=j(J,[["render",q],["__scopeId","data-v-efe3e5ce"]]);export{Go as default};
