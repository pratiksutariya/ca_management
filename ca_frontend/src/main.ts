import { createApp } from 'vue';
import App from './App.vue';
import { router } from './router';
import store from './store'
import vuetify from './plugins/vuetify';
import '@/scss/style.scss';
import PerfectScrollbar from 'vue3-perfect-scrollbar';
import VueApexCharts from 'vue3-apexcharts';
import VueTablerIcons from 'vue-tabler-icons';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Maska from 'maska';
const app = createApp(App);
app.use(router);
app.use(store);
app.use(PerfectScrollbar);
app.use(VueTablerIcons);
app.use(Maska);
const options = {
  // You can set your default options here
};

app.use(Toast, options)
app.use(VueSweetalert2);
window.Swal =  app.config.globalProperties.$swal;
app.use(VueApexCharts);
app.use(vuetify).mount('#app');
