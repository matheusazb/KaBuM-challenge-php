import Swal from "sweetalert2/dist/sweetalert2.js";
import { Request } from "./request";

class RemoveModal {
  constructor({
    selector,
    endpoint,
    selectorRemoveItem,
    reloadOnClose,
    dataAttribute,
  }) {
    this.links = document.querySelectorAll(`.${selector}`);
    this.selector = selector;
    this.dataAttribute = dataAttribute || "data-id";
    this.selectorItem = selectorRemoveItem;
    this.reloadOnClose = reloadOnClose || false;
    this.endpoint = endpoint;
    if (this.links) {
      this.applyEvents();
    }
  }

  showModal(options = {}) {
    return Swal.fire(...options);
  }

  applyEvents() {
    this.links.forEach((link) => {
      link.addEventListener("click", (event) => this.removeClickEvent(event));
    });
  }

  removeClickEvent(event) {
    event.preventDefault();
    const { srcElement } = event;
    let id = srcElement.getAttribute(this.dataAttribute);
    if (!id) {
      id = srcElement
        .closest(`.${this.selector}`)
        .getAttribute(this.dataAttribute);
    }
    if (id) {
      Swal.fire({
        title: "Você tem certeza disso?",
        text: "A confirmação desta ação não pode ser revertida!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Não, obrigado",
      }).then((result) => {
        if (result.value) {
          Request.delete(`${this.endpoint}/${id}`).then((response) => {
            const { success } = response;
            if (success) {
              Swal.fire({
                title: "Deletado com sucesso!",
                icon: "success",
                onClose: () => {
                  if (this.selectorItem) {
                    const parentElement = srcElement.closest(this.selectorItem);
                    if (parentElement) {
                      parentElement.remove();
                    }
                  } else {
                    if (this.reloadOnClose) {
                      window.location.reload();
                    }
                  }
                },
              });
            } else {
              Swal.fire({
                title: "Ocorreu um erro",
                text: "Tente novamente mais tarde.",
                icon: "error",
              });
            }
          });
        }
      });
    }
  }
}

export default RemoveModal;
export { RemoveModal };
