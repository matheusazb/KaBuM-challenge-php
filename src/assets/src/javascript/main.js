import { ready } from "./modules";
import Textfield from "../styles/components/src/textfield/textfield";
// import Menu from "../styles/components/src/menu/menu";

ready(() => {
  setTimeout(() => {
    Textfield.mount();
    // new Menu();
  }, 0);
});
