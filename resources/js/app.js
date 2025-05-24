import './bootstrap';
import { createApp } from 'vue' 
import ServiceCreate from './Components/Service/Create.vue'
import ServiceEdit from './Components/Service/Edit.vue'
import ServiceIndex from './Components/Service/Index.vue'
 
const app = createApp({}) 
    .component('ServiceCreate', ServiceCreate)
    .component('ServiceEdit', ServiceEdit)
    .component('ServiceIndex', ServiceIndex)

    .mount('#app') 