<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <form>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="cutomer_name" class="form-label">Cutomer Name</label>
                                <input type="text" v-model="service.customer_name" name="cutomer_name" class="form-control" id="cutomer_name" placeholder="Customer Name">
                            </div>
                            <div class="col-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" v-model="service.phone" name="phone" class="form-control" id="phone" placeholder="Phone">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="chassis_number" class="form-label">Chassis Number</label>
                                <input type="text" v-model="service.chassis_number" name="chassis_number" class="form-control" id="chassis_number" placeholder="Chassis Number">
                            </div>
                            <div class="col-4">
                                <label for="km_run" class="form-label">KM Run</label>
                                <input type="number" v-model="service.km_run" name="km_run" class="form-control" id="km_run" placeholder="KM Run">
                            </div>
                            <div class="col-4">
                                <label for="bay_number" class="form-label">Bay Number</label>
                                <input type="text" v-model="service.bay_number" name="bay_number" class="form-control" id="bay_number" placeholder="Bay Number">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="charge" class="form-label">Charge</label>
                                <input type="number" v-model="service.charge" name="charge" class="form-control" id="charge" placeholder="Charge">
                            </div>
                            <div class="col-4">
                                <label for="type" class="form-label">Charge</label>
                                <select v-model="service.type" name="type" class="form-select" id="type" aria-label="Service Type">
                                    <option value="1">Free</option>
                                    <option value="2">Paid</option>
                                  </select>
                            </div>
                            <div class="col-4">
                                <label for="start_time" class="form-label">Service Time</label>
                                <!-- <input type="date" v-model="service.start_time" name="start_time" class="form-control" id="start_time"> -->
                                <VueDatePicker v-model="service.start_time"></VueDatePicker>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="img" class="form-label">Bike Image</label>
                                <input type="file" @change="handleImage" name="img" class="form-control" id="img">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="card mt-2">
                                    <div class="card-body">
                                        <div v-for="(item, index) in service.parts" :key="index" class="row">
                                            <div class="col-8">
                                                <label class="form-label">Select Parts</label>
                                                <select v-model="service.parts[index].parts_id" class="form-select">
                                                    <option v-for="(parts, index) in partses" :key="index" :value="parts.id">{{parts.name}}</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label">Quantity</label>
                                                <input type="number" v-model="service.parts[index].quantity" class="form-control" placeholder="Quantity">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="d-flex justify-content-end">
                                                <button type="button" @click.prevent="addParts" class="btn btn-primary mt-2">Add Parts</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="button" @click.prevent="submit" class="btn btn-primary mt-2">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
    import axios from 'axios';
    import {ref} from 'vue';
    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css'
    const props = defineProps(['partses']);
    const service = ref({
        customer_name: null,
        chassis_number: null,
        km_run: null,
        bay_number: null,
        charge: null,
        type: 1,
        start_time: null,
        img: null,
        parts:[
            {parts_id: '', quantity: 1}
        ]
    });

    const handleImage = (e) => {
        service.value.img = e.target.files[0];
    }

    const addParts = () => {
        service.value.parts.push({parts_id: '', quantity: 1});
    }

    const submit = async () => {
        try {
            const response = await axios.post('/services', service.value,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            if(response.status == 201) {
                // window.location.href = 'services/'
            }
        } catch (error) {
            console.log(error);
        }
    }


</script>
