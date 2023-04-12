import{J as v}from"./ActionMessage-c078ab58.js";import{J as g}from"./ActionSection-503f6cc4.js";import{J as y}from"./Button-caddf70d.js";import{J as C}from"./ConfirmationModal-747d8d1a.js";import{J as w}from"./DangerButton-0ca7bbd2.js";import{J as S}from"./DialogModal-08c723b0.js";import{J as V}from"./FormSection-f05163be.js";import{J}from"./Input-2cb00575.js";import{J as D}from"./Checkbox-0b804630.js";import{J as I}from"./InputError-1ce94fe9.js";import{J as N}from"./Label-715dcd10.js";import{J as B}from"./SecondaryButton-3445fa1d.js";import{J as k}from"./SectionBorder-30338fa4.js";import{J as j}from"./ValidationErrors-deb0d81a.js";import{k as h,c as L,w as m,r as l,o as M,f as p,t,b as i,a as e,i as q,C as U,h as A,n as T}from"./app-5577a803.js";import{_ as F}from"./_plugin-vue_export-helper-c27b6911.js";import"./SectionTitle-75c86d6b.js";import"./Modal-5b92d53d.js";/* empty css            */const z={components:{JetActionMessage:v,JetActionSection:g,JetButton:y,JetConfirmationModal:C,JetDangerButton:w,JetDialogModal:S,JetFormSection:V,JetInput:J,JetCheckbox:D,JetInputError:I,JetLabel:N,JetSecondaryButton:B,JetSectionBorder:k,JetValidationErrors:j},props:{branch:{Type:Object,default:null}},data(){return{errors:[],form:this.$inertia.form({name:"",issuer_id:"",type:"B",address:{branchID:"",country:"",governate:"",regionCity:"",street:"",buildingNumber:"",postalCode:"",additionalInformation:""},branchLogo:""}),showDialog:!1}},methods:{ShowDialog(){this.branch!==null&&(this.form.name=this.branch.name,this.form.issuer_id=this.branch.issuer_id,this.form.type=this.branch.type,this.form.address.branchID=this.branch.address.branchID,this.form.address.country=this.branch.address.country,this.form.address.governate=this.branch.address.governate,this.form.address.regionCity=this.branch.address.regionCity,this.form.address.street=this.branch.address.street,this.form.address.buildingNumber=this.branch.address.buildingNumber,this.form.address.postalCode=this.branch.address.postalCode,this.form.address.additionalInformation=this.branch.address.additionalInformation),this.showDialog=!0},CancelAddBranch(){this.showDialog=!1},SaveBranch(){const o=new FormData;this.form.branchLogo&&o.append("branchLogo",this.form.branchLogo),o.append("name",this.form.name),o.append("issuer_id",this.form.issuer_id),o.append("type",this.form.type),o.append("address[branchID]",this.form.address.branchID),o.append("address[country]",this.form.address.country),o.append("address[governate]",this.form.address.governate),o.append("address[regionCity]",this.form.address.regionCity),o.append("address[street]",this.form.address.street),o.append("address[buildingNumber]",this.form.address.buildingNumber),o.append("address[postalCode]",this.form.address.postalCode),o.append("address[additionalInformation]",this.form.address.additionalInformation),o.append("_method","PUT"),h.post(route("branches.update",{branch:this.branch.Id}),o,{headers:{"Content-Type":"multipart/form-data"}}).then(s=>{this.$store.dispatch("setSuccessFlashMessage",!0),this.showDialog=!1,setTimeout(()=>{window.location.reload()},500)}).catch(s=>{console.log(s),this.form.processing=!1,this.$page.props.errors=s.response.data.errors,this.errors=s.response.data.errors})},SaveNewBranch(){const o=new FormData;o.append("branchLogo",this.form.branchLogo),o.append("name",this.form.name),o.append("issuer_id",this.form.issuer_id),o.append("type",this.form.type),o.append("address[branchID]",this.form.address.branchID),o.append("address[country]",this.form.address.country),o.append("address[governate]",this.form.address.governate),o.append("address[regionCity]",this.form.address.regionCity),o.append("address[street]",this.form.address.street),o.append("address[buildingNumber]",this.form.address.buildingNumber),o.append("address[postalCode]",this.form.address.postalCode),o.append("address[additionalInformation]",this.form.address.additionalInformation),h.post(route("branches.store"),o,{headers:{"Content-Type":"multipart/form-data"}}).then(s=>{this.$store.dispatch("setSuccessFlashMessage",!0),this.processing=!1,this.$nextTick(()=>this.$emit("dataUpdated")),this.form.reset(),this.form.processing=!1,this.showDialog=!1,setTimeout(()=>{window.location.reload()},500)}).catch(s=>{this.form.processing=!1,this.$page.props.errors=s.response.data.errors,this.errors=s.response.data.errors})},submit(){this.branch==null?this.SaveNewBranch():this.SaveBranch()},branchLogo(o){this.form.branchLogo=o.target.files[0]}}},E={class:"grid grid-cols-2 gap-4"},G={class:"mt-4"},P={class:"mt-4"},Q={class:"mt-4"},R={class:"mt-4"},H={class:"mt-4"},K={class:"mt-4"},O={value:"Cairo"},W={value:"Giza"},X={value:"Alexandria"},Y={value:"Gharbiya"},Z={value:"Qalioubiya"},$={value:"Assiut"},x={value:"Aswan"},oo={value:"Beheira"},eo={value:"Bani Suef"},so={value:"Daqahliya"},to={value:"Damietta"},ao={value:"Fayyoum"},ro={value:"Helwan"},io={value:"Ismailia"},no={value:"Kafr El Sheikh"},lo={value:"Luxor"},uo={value:"Marsa Matrouh"},mo={value:"Minya"},po={value:"Monofiya"},ho={value:"New Valley"},fo={value:"North Sinai"},_o={value:"Port Said"},co={value:"Qena"},bo={value:"Red Sea"},vo={value:"Sharqiya"},go={value:"Sohag"},yo={value:"South Sinai"},Co={value:"Suez"},wo={value:"Tanta"},So={class:"mt-4"},Vo={class:"mt-4"},Jo={class:"mt-4"},Do={class:"flex items-center justify-end"};function Io(o,s,No,Bo,r,u){const f=l("jet-validation-errors"),n=l("jet-label"),d=l("jet-input"),_=l("jet-secondary-button"),c=l("jet-button"),b=l("jet-dialog-modal");return M(),L(b,{show:r.showDialog,onClose:s[13]||(s[13]=a=>r.showDialog=!1)},{title:m(()=>[p(t(o.__("Branch Information")),1)]),content:m(()=>[i(f,{class:"mb-4"}),e("form",{onSubmit:s[11]||(s[11]=A((...a)=>u.submit&&u.submit(...a),["prevent"]))},[e("div",E,[e("div",null,[e("div",null,[i(n,{for:"branchNo",value:o.__("Branch Number")},null,8,["value"]),i(d,{id:"branchNo",type:"number",class:"mt-1 block w-full",modelValue:r.form.address.branchID,"onUpdate:modelValue":s[0]||(s[0]=a=>r.form.address.branchID=a),required:"",autofocus:""},null,8,["modelValue"])]),e("div",G,[i(n,{for:"id",value:o.__("Tax Registration Number")},null,8,["value"]),i(d,{id:"id",type:"number",class:"mt-1 block w-full",modelValue:r.form.issuer_id,"onUpdate:modelValue":s[1]||(s[1]=a=>r.form.issuer_id=a),required:""},null,8,["modelValue"])]),e("div",P,[i(n,{for:"name",value:o.__("Branch Name")},null,8,["value"]),i(d,{id:"name",type:"text",class:"mt-1 block w-full",modelValue:r.form.name,"onUpdate:modelValue":s[2]||(s[2]=a=>r.form.name=a),required:""},null,8,["modelValue"])]),e("div",Q,[i(n,{for:"additionalInformation",value:o.__("Additional Information (Location)")},null,8,["value"]),i(d,{id:"additionalInformation",type:"text",class:"mt-1 block w-full",modelValue:r.form.address.additionalInformation,"onUpdate:modelValue":s[3]||(s[3]=a=>r.form.address.additionalInformation=a)},null,8,["modelValue"])]),e("div",R,[i(n,{for:"postalCode",value:o.__("Postal Code")},null,8,["value"]),i(d,{id:"postalCode",type:"number",class:"mt-1 block w-full",modelValue:r.form.address.postalCode,"onUpdate:modelValue":s[4]||(s[4]=a=>r.form.address.postalCode=a)},null,8,["modelValue"])]),e("div",H,[i(n,{for:"branchLogo",value:o.__("Branch Logo")},null,8,["value"]),e("input",{type:"file",class:"mt-1 block w-full py-2",required:"",accept:".jpg,.png,.jpeg",onChange:s[5]||(s[5]=a=>u.branchLogo(a))},null,32)])]),e("div",null,[e("div",null,[i(n,{for:"country",value:o.__("Country")},null,8,["value"]),i(d,{id:"country",type:"text",class:"mt-1 block w-full",modelValue:r.form.address.country,"onUpdate:modelValue":s[6]||(s[6]=a=>r.form.address.country=a),required:""},null,8,["modelValue"])]),e("div",K,[i(n,{for:"governate",value:o.__("Governate/State")},null,8,["value"]),q(e("select",{id:"governate","onUpdate:modelValue":s[7]||(s[7]=a=>r.form.address.governate=a),class:"mt-1 block w-full rounded border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm"},[e("option",O,t(o.__("Cairo")),1),e("option",W,t(o.__("Giza")),1),e("option",X,t(o.__("Alexandria")),1),e("option",Y,t(o.__("Gharbiya")),1),e("option",Z,t(o.__("Qalioubiya")),1),e("option",$,t(o.__("Assiut")),1),e("option",x,t(o.__("Aswan")),1),e("option",oo,t(o.__("Beheira")),1),e("option",eo,t(o.__("Bani Suef")),1),e("option",so,t(o.__("Daqahliya")),1),e("option",to,t(o.__("Damietta")),1),e("option",ao,t(o.__("Fayyoum")),1),e("option",ro,t(o.__("Helwan")),1),e("option",io,t(o.__("Ismailia")),1),e("option",no,t(o.__("Kafr El Sheikh")),1),e("option",lo,t(o.__("Luxor")),1),e("option",uo,t(o.__("Marsa Matrouh")),1),e("option",mo,t(o.__("Minya")),1),e("option",po,t(o.__("Monofiya")),1),e("option",ho,t(o.__("New Valley")),1),e("option",fo,t(o.__("North Sinai")),1),e("option",_o,t(o.__("Port Said")),1),e("option",co,t(o.__("Qena")),1),e("option",bo,t(o.__("Red Sea")),1),e("option",vo,t(o.__("Sharqiya")),1),e("option",go,t(o.__("Sohag")),1),e("option",yo,t(o.__("South Sinai")),1),e("option",Co,t(o.__("Suez")),1),e("option",wo,t(o.__("Tanta")),1)],512),[[U,r.form.address.governate]])]),e("div",So,[i(n,{for:"regionCity",value:o.__("Region/City")},null,8,["value"]),i(d,{id:"regionCity",type:"text",class:"mt-1 block w-full",modelValue:r.form.address.regionCity,"onUpdate:modelValue":s[8]||(s[8]=a=>r.form.address.regionCity=a),required:""},null,8,["modelValue"])]),e("div",Vo,[i(n,{for:"street",value:o.__("Street")},null,8,["value"]),i(d,{id:"street",type:"text",class:"mt-1 block w-full",modelValue:r.form.address.street,"onUpdate:modelValue":s[9]||(s[9]=a=>r.form.address.street=a),required:""},null,8,["modelValue"])]),e("div",Jo,[i(n,{for:"buildingNumber",value:o.__("Building Number")},null,8,["value"]),i(d,{id:"buildingNumber",type:"text",class:"mt-1 block w-full",modelValue:r.form.address.buildingNumber,"onUpdate:modelValue":s[10]||(s[10]=a=>r.form.address.buildingNumber=a),required:""},null,8,["modelValue"])])])])],32)]),footer:m(()=>[e("div",Do,[i(_,{onClick:s[12]||(s[12]=a=>u.CancelAddBranch())},{default:m(()=>[p(t(o.__("Cancel")),1)]),_:1}),i(c,{class:T(["ms-2",{"opacity-25":r.form.processing}]),onClick:u.submit,disabled:r.form.processing},{default:m(()=>[p(t(o.__("Save")),1)]),_:1},8,["onClick","class","disabled"])])]),_:1},8,["show"])}const Xo=F(z,[["render",Io]]);export{Xo as default};
