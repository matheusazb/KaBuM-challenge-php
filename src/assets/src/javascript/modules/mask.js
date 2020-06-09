import VMasker from "vanilla-masker";

const Defaults = {
  AutoMaskFields: {
    cpf: "[data-mask-cpf]",
    phone: "[data-mask-phone]",
    birthdate: "[data-mask-birthdate]",
    cep: "[data-mask-cep]",
  },
  Masks: {
    cep: "99999-999",
    cpf: "999.999.999-99",
    cellphone: "(99) 99999-9999",
    telephone: "(99) 9999-9999",
    birthdate: "99/99/9999",
  },
};

class Mask {
  constructor(formSelector) {
    this.form = document.querySelector(formSelector);
    if (this.form) {
      this.maskFields();
    }
  }

  maskFields() {
    Object.keys(Defaults.AutoMaskFields).forEach((key) => {
      const fields = this.form.querySelectorAll(Defaults.AutoMaskFields[key]);
      if (fields && fields.length > 0) {
        fields.forEach((field) => {
          if (key === "phone") {
            field.addEventListener(
              "input",
              Mask.ApplyMultiMask.bind(
                undefined,
                [Defaults.Masks.telephone, Defaults.Masks.cellphone],
                14
              ),
              false
            );
          } else {
            Mask.ApplyMask(field, Defaults.Masks[key]);
          }
        });
      }
    });
  }

  static ApplyMask(input, mask) {
    if (input && mask) {
      VMasker(input).maskPattern(mask);
    }
  }

  static ApplyMultiMask(masks, max, event) {
    const element = event.target;
    const value = element.value.replace(/\D/g, "");
    const mask = element.value.length > max ? 1 : 0;
    VMasker(element).unMask();
    VMasker(element).maskPattern(masks[mask]);
    element.value = VMasker.toPattern(value, masks[mask]);
  }
}

export default Mask;
export { Mask };
