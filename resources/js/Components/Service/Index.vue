<template>
    <div>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Chassis Number</th>
                                <th scope="col">Service Charge</th>
                                <th scope="col">Parts Price</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Start Time</th>
                                <th scope="col">End Time</th>
                                <th scope="col">Actual Time</th>
                                <th scope="col">Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(service, index) in services" :key="index">
                                <td>{{service.customer_name}}</td>
                                <td>{{service.phone}}</td>
                                <td>{{service.chassis_number}}</td>
                                <td>{{service.charge}}</td>
                                <td>{{getPartsPrice(service)}}</td>
                                <td>{{service.charge + getPartsPrice(service)}}</td>
                                <td>{{service.start_time}}</td>
                                <td>{{service.end_time}}</td>
                                <td>{{service.actual_time}}</td>
                                <td>
                                    <button type="button" @click="handleUpdate(service)" class="btn btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Action
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Service Time</label>
                            <VueDatePicker v-model="service.end_time"></VueDatePicker>
                        </div>
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea v-model="service.remarks" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" @click.prevent="save" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import VueDatePicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css'

    const props = defineProps(['services']);
    const modalOpen = ref(false);
    const serviceData = ref(null);
    const service = ref({
        end_time: null,
        remarks: ''
    });

    const getPartsPrice = ({ service_parts }) => {
        if (service_parts.length) {
            let price = 0
            price = service_parts.reduce((acc, item) => {
                console.log(item);
                return acc + (item.quantity * item.parts.retail_price)
            }, 0);
            return price;
        } else {
            return 0;
        }
    }

    const handleUpdate = (service) => {
        modalOpen.value = true;
        serviceData.value = service;
    }

    const save = async() => {
        const response = await axios.put('services/' + serviceData.value.id , service.value);
    }
</script>