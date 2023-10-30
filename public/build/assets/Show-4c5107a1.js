import{A as h}from"./AppLayout-336b7499.js";import g from"./DeleteUserForm-8e850971.js";import{J as w}from"./SectionBorder-a45d0249.js";import F from"./LogoutOtherBrowserSessionsForm-e71ace2b.js";import y from"./TwoFactorAuthenticationForm-954a5315.js";import $ from"./UpdatePasswordForm-a9c379e4.js";import k from"./UpdateProfileInformationForm-6f7e32ca.js";import{_ as b}from"./_plugin-vue_export-helper-c27b6911.js";import{c as j,w as a,r as t,o as e,a as i,d as s,b as o,e as p,F as v}from"./app-98cccb0d.js";import"./Edit-7ca2eef9.js";import"./ActionMessage-529841b6.js";import"./ActionSection-14bbef3c.js";import"./SectionTitle-f26ec90c.js";import"./Button-fce1e67a.js";import"./ConfirmationModal-2d2586d4.js";import"./Modal-2ccc6cf7.js";import"./DangerButton-bf3f8f1f.js";import"./DialogModal-9cb7d35f.js";import"./FormSection-60b88c5f.js";import"./Input-9c9fd5b2.js";import"./Checkbox-7ff4e1d6.js";import"./InputError-48880b4d.js";import"./Label-c6c7e0c2.js";import"./SecondaryButton-fb7ef34d.js";import"./ValidationErrors-ce3c07bd.js";/* empty css            */import"./Edit-cfad98b4.js";import"./TextField-4dc08153.js";import"./Edit-04381c68.js";import"./Edit-c883850a.js";import"./Edit-663be45d.js";import"./Edit-833659c9.js";import"./vue3-multiselect.umd.min-89fe1e95.js";import"./Edit-e905c401.js";import"./Edit-fb9e1a40.js";import"./Edit-8b049cff.js";import"./Edit-7210d6e2.js";import"./Edit-9520adfe.js";/* empty css                                                                  */import"./Load-c81154ca.js";import"./Load-269b27e0.js";import"./Edit-470aa9e5.js";import"./Edit-ae0efa3b.js";import"./Upload-3f7847e9.js";import"./Upload-cab6aca1.js";import"./Upload-4bb109cf.js";import"./Upload-91640e3b.js";import"./Settings-281c0c2c.js";import"./Settings-3a181d36.js";import"./Upload-b3182070.js";import"./Request-264efc19.js";import"./Add-983c5f77.js";import"./Load-b9d12279.js";import"./Upload-0c9409a0.js";import"./Load-c588859c.js";import"./sweetalert.min-9f604034.js";import"./ItemsMap-ac429fa2.js";import"./Upload-69a7afe4.js";import"./ItemsMap-99c5c9fb.js";import"./RequestEx-4f93fb5e.js";const B={props:["sessions"],components:{AppLayout:h,DeleteUserForm:g,JetSectionBorder:w,LogoutOtherBrowserSessionsForm:F,TwoFactorAuthenticationForm:y,UpdatePasswordForm:$,UpdateProfileInformationForm:k}},x=i("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Profile ",-1),A={class:"mx-auto py-10 sm:px-6 lg:px-8"},P={key:0},U={key:1},C={key:2};function N(r,S,n,V,D,I){const c=t("update-profile-information-form"),m=t("jet-section-border"),_=t("update-password-form"),d=t("two-factor-authentication-form"),l=t("logout-other-browser-sessions-form"),f=t("delete-user-form"),u=t("app-layout");return e(),j(u,null,{header:a(()=>[x]),default:a(()=>[i("div",null,[i("div",A,[r.$page.props.jetstream.canUpdateProfileInformation?(e(),s("div",P,[o(c,{user:r.$page.props.auth.user},null,8,["user"]),o(m)])):p("",!0),r.$page.props.jetstream.canUpdatePassword?(e(),s("div",U,[o(_,{class:"mt-10 sm:mt-0"}),o(m)])):p("",!0),r.$page.props.jetstream.canManageTwoFactorAuthentication?(e(),s("div",C,[o(d,{class:"mt-10 sm:mt-0"}),o(m)])):p("",!0),o(l,{sessions:n.sessions,class:"mt-10 sm:mt-0"},null,8,["sessions"]),r.$page.props.jetstream.hasAccountDeletionFeatures?(e(),s(v,{key:3},[o(m),o(f,{class:"mt-10 sm:mt-0"})],64)):p("",!0)])])]),_:1})}const zo=b(B,[["render",N]]);export{zo as default};
