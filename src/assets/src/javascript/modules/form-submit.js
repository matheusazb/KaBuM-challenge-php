import { Request } from "./request";
import Swal from "sweetalert2/dist/sweetalert2.js";

class FormSubmit {
  constructor({ context, submitSelector, formSelector }) {
    this.context = context;
    this.submit = document.querySelector(submitSelector);
    this.form = document.querySelector(formSelector);
    if (this.submit && this.form) {
      this.fields = this.form.querySelectorAll(
        "input[type='text'], input[type='hidden']"
      );
      this.triggerEvents();
    }
  }

  triggerEvents() {
    const { action } = this.form;
    const options = {
      credentials: "include",
    };

    this.submit.addEventListener("click", (event) => {
      event.preventDefault();
      const formData = this.getFormData();
      if (this.form.checkValidity()) {
        Request.post(action, formData, options).then((response) => {
          const { success } = response;
          if (success) {
            this.clearForm();
            Swal.fire({
              title: "Cadastro realizado com sucesso",
              icon: "success",
            });
          } else {
            Swal.fire({
              title: "Ocorreu um erro",
              text: "Tente novamente mais tarde.",
              icon: "error",
            });
          }
        });
      } else {
        Swal.fire({
          title: "Preencha todos os dados",
          icon: "info",
        });
      }
    });
  }

  getFormData() {
    const form = {};
    for (let field of this.fields) {
      const { value, name } = field;
      form[name] = value;
    }
    return form;
  }

  clearForm() {
    this.fields.forEach((field) => {
      field.value = "";
    });
  }
}

export default FormSubmit;
export { FormSubmit };
