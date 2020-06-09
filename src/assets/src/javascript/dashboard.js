import { ready, RemoveModal, Mask, FormSubmit } from "./modules";

const FormOptions = {
  context: "cliente",
  submitSelector: ".js-submit",
  formSelector: ".js-form",
};
const CurrentPathName = window.location.pathname;

const Page = {
  isCreate: CurrentPathName.indexOf("create") >= 0,
  isUpdate: CurrentPathName.indexOf("update") >= 0,
  isList: CurrentPathName.indexOf("list") >= 0,
  isClientAddress: CurrentPathName.startsWith("/clients/address"),
};

ready(() => {
  setTimeout(() => {
    if (CurrentPathName.startsWith("/clients")) {
      if (Page.isCreate || Page.isUpdate) {
        if (Page.isClientAddress) {
          new FormSubmit({ ...FormOptions, context: "endereço" });
        } else {
          new FormSubmit({ ...FormOptions });
        }
        new Mask(FormOptions.formSelector);
      }
      let endpoint = window.ENDPOINT_CLIENT_DELETE;
      if (Page.isList && Page.isClientAddress) {
        if (CurrentPathName) {
          endpoint = window.ENDPOINT_ADDRESS_DELETE;
        }
      }
      new RemoveModal({
        selector: "js-list-remove",
        endpoint,
        selectorRemoveItem: ".c-list__item",
      });
    }
  }, 0);
});
