import { debounce } from "./debounce";
import { Request } from "./request";

let Defaults = {
  Selectors: {
    cep: "[data-cep-field]",
    street: "#street",
    neighborhood: "#neighborhood",
    city: "#city",
    state: "#state",
    number: "#number",
    isDirty: "is-dirty",
    textfieldElement: "js-float-field",
    disabledField: "c-button--disabled",
  },
  Attributes: {
    disabled: "disabled",
  },
  regex: {
    onlyNumbers: /[\D]+/g,
  },
  enableAdd: false,
  getEndpoint: (cep) => `https://viacep.com.br/ws/${cep}/json/`,
};

/**
 * Request Viacep API data
 */
class Cep {
  constructor(options = null) {
    if (options && options.Selectors) {
      Object.assign(Defaults.Selectors, options.Selectors);
    }
    this.input = document.querySelector(Defaults.Selectors.cep);
    if (this.input) {
      this.street = document.querySelector(Defaults.Selectors.street);
      this.neighborhood = document.querySelector(
        Defaults.Selectors.neighborhood
      );
      this.city = document.querySelector(Defaults.Selectors.city);
      this.state = document.querySelector(Defaults.Selectors.state);
      this.number = document.querySelector(Defaults.Selectors.number);

      this.fields = [
        this.neighborhood,
        this.street,
        this.city,
        this.state,
      ].filter((field) => field !== undefined);
      this.triggerEvents();
    }
  }

  triggerEvents() {
    this.input.addEventListener(
      "keyup",
      debounce(() => {
        this.findCep(this.input.value);
      }, 600)
    );
  }

  findCep(cep) {
    if (cep && cep.replace(Defaults.regex.onlyNumbers, "").length === 8) {
      Request.get(
        Defaults.getEndpoint(cep.replace(Defaults.regex.onlyNumbers, ""))
      ).then((response) => {
        const { bairro, localidade, uf, logradouro } = response;
        if (this.neighborhood) {
          this.neighborhood.value = bairro || "";
        }
        if (this.street) {
          this.street.value = logradouro || "";
        }
        if (this.city) {
          this.city.value = localidade || "";
        }
        if (this.state) {
          this.state.value = uf || "";
        }

        this.disableAllFields();
        this.fields.forEach((field) => {
          this.checkIsDirty(field);
          this.disableField(field);
        });
      });
    }
  }

  disableAllFields() {
    this.fields.forEach((field) => {
      field.removeAttribute(Defaults.Attributes.disabled);
      this.disableField(field);
    });
  }
  disableField(field) {
    if (
      field.value &&
      field.value.length > 0 &&
      !field.getAttribute(Defaults.Attributes.disabled)
    ) {
      field.setAttribute(Defaults.Attributes.disabled, true);
    }

    if (field.value && field.value.length === 0) {
      field.removeAttribute(Defaults.Attributes.disabled);
    }
  }

  checkIsDirty(field) {
    if (field && field.value) {
      if (field.value != "") {
        const fieldElementClosest = field.closest(
          `.${Defaults.Selectors.textfieldElement}`
        );
        if (fieldElementClosest) {
          if (
            !fieldElementClosest.classList.contains(Defaults.Selectors.isDirty)
          ) {
            fieldElementClosest.classList.add(Defaults.Selectors.isDirty);
          }
        }
      }
    }
  }
}

export default Cep;
export { Cep };
