import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

export default function showToast(message, color) {
  Toastify({
    text: message,
    duration: 3000,
    newWindow: true,
    close: true,
    gravity: "bottom",
    position: "center",
    stopOnFocus: true,
    style: {
        background: `${color}`,
    },
  }).showToast();
}
