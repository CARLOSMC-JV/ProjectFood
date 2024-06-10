// resources/js/toast.js
import { createApp } from 'vue';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

const options = {
  // Puedes configurar tus opciones aquí
};

export function useToast(app) {
  app.use(Toast, options);
}