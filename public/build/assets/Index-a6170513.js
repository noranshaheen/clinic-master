import{A as w}from"./AppLayout-f49bf28b.js";import{C}from"./Confirm-bf02ee04.js";import b from"./Edit-bcfc13f2.js";import{O as x}from"./inertiajs-tables-laravel-query-builder.es-f3abfc1e.js";import{J as k}from"./SecondaryButton-713ac718.js";import{J as S}from"./Button-4bcf952d.js";import{k as B,c as $,w as e,r,o as D,b as s,f as p,t as m,a,p as I,l as T}from"./app-150d5054.js";import{_ as j}from"./_plugin-vue_export-helper-c27b6911.js";import"./Edit-0682400b.js";import"./ActionMessage-61e2ac70.js";import"./ActionSection-b2837b81.js";import"./SectionTitle-3e354ea0.js";import"./ConfirmationModal-25a9f4bd.js";import"./Modal-af9a88ec.js";import"./DangerButton-8bc4ac7b.js";import"./DialogModal-abac778c.js";import"./FormSection-88b4b82e.js";import"./Input-1c19b971.js";import"./Checkbox-4a56b901.js";import"./TextField-3250345e.js";import"./Label-df30c280.js";import"./InputError-a5d97e62.js";import"./SectionBorder-e50f0f2f.js";import"./ValidationErrors-d148bef4.js";/* empty css            */import"./Edit-3c089fa6.js";import"./Edit-be99b5ee.js";import"./Edit-597f2255.js";import"./Edit-f9922137.js";import"./vue3-multiselect.umd.min-0e68115f.js";import"./Edit-faa18d1d.js";import"./Edit-cd91fcb4.js";import"./Edit-07cd30d2.js";import"./Edit-34545e2b.js";import"./Edit-db4f3217.js";/* empty css                                                                  */import"./Load-49470aa5.js";import"./Load-63f267b7.js";import"./Edit-ae599c19.js";import"./Upload-84ea7cbc.js";import"./Upload-9f5fa312.js";import"./Settings-16afee17.js";import"./Settings-c1b5727e.js";import"./Upload-ac8dd442.js";import"./Request-7a72620a.js";import"./Add-a5bec431.js";import"./Load-9cedd89f.js";import"./Upload-8acddc09.js";import"./Load-38871443.js";import"./sweetalert.min-d55a1c1c.js";import"./ItemsMap-522638f4.js";import"./Upload-92e0933c.js";import"./ItemsMap-e43ca060.js";import"./RequestEx-92427893.js";const J={components:{EditDoctor:b,Confirm:C,AppLayout:w,Table:x,SecondaryButton:k,JetButton:S},props:{doctors:Object},data(){return{doctor:Object}},methods:{editCustomer(o){this.doctor=o,this.$nextTick(()=>this.$refs.dlg2.ShowDialog())},removeCustomer(o){this.doctor=o,this.$refs.dlg1.ShowModal()},remove(){B.delete(route("doctors.destroy",{doctor:this.doctor.id})).then(o=>{this.$store.dispatch("setSuccessFlashMessage",!0),setTimeout(()=>{window.location.reload()},500)}).catch(o=>{})},showColumn(o){if(!this.$inertia.page.props.queryBuilderProps.default.columns)return!1;const i=this.$inertia.page.props.queryBuilderProps.default.columns.find(n=>n.key===o);return i?!i.hidden:!1}}},d=o=>(I("data-v-efe3e5ce"),o=o(),T(),o),O={class:"py-4"},A={class:"mx-auto sm:px-6 lg:px-8"},F={class:"wrapper Gbg-white shadow-xl sm:rounded-lg p-4"},N=d(()=>a("i",{class:"fa fa-edit"},null,-1)),V=d(()=>a("i",{class:"fa fa-trash"},null,-1));function q(o,i,n,E,l,c){const _=r("edit-doctor"),u=r("confirm"),f=r("secondary-button"),h=r("jet-button"),y=r("Table"),g=r("app-layout");return D(),$(g,null,{default:e(()=>[s(_,{ref:"dlg2",doctor:l.doctor},null,8,["doctor"]),s(u,{ref:"dlg1",onConfirmed:i[0]||(i[0]=t=>c.remove())},{default:e(()=>[p(m(o.__("Are you sure you want to delete this doctor?")),1)]),_:1},512),a("div",O,[a("div",A,[a("div",F,[s(y,{resource:n.doctors},{"cell(date_of_birth)":e(({item:t})=>[p(m(new Date().getFullYear()-new Date(t.date_of_birth).getFullYear()),1)]),"cell(specialty_id)":e(({item:t})=>[p(m(t.specialties.name),1)]),"cell(actions)":e(({item:t})=>[s(f,{onClick:v=>c.editCustomer(t)},{default:e(()=>[N,p(" "+m(o.__("Edit")),1)]),_:2},1032,["onClick"]),s(h,{class:"ms-2",onClick:v=>c.removeCustomer(t)},{default:e(()=>[V,p(" "+m(o.__("Delete")),1)]),_:2},1032,["onClick"])]),_:1},8,["resource"])])])])]),_:1})}const Po=j(J,[["render",q],["__scopeId","data-v-efe3e5ce"]]);export{Po as default};