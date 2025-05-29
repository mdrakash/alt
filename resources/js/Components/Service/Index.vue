<template>
    <div>
        <div class="container">
            <div class="col mb-2">
                <div class="d-flex justify-content-between">
                    <h3>All Services</h3>
                    <a href="/services/create" class="btn btn-primary mt-2">Create Service</a>
                </div>
            </div>
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
                            <tr v-for="(service, index) in services.data" :key="index">
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
            <div class="col mb-2">
                <div class="d-flex justify-content-end gap-2">
                    <a :href="`/services?page=${services.current_page - 1}`" :class="{ 'disabled': !services.prev_page_url }" class="btn btn-primary mt-2">Prev</a>
                    <a :href="`/services?page=${services.current_page + 1}`" :class="{ 'disabled': !services.next_page_url }" class="btn btn-primary mt-2">Next</a>
                </div>
            </div>
        </div>
        

        <div class="container">
            <div class="row">
                <div class="col">
                    <h3>Distributed 100 Discount Across All Parts Retail Price</h3>
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Retail Price</th>
                                <th>Discount Price</th>
                                <th>Discount %</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(parts, index) in partses" :key="index">
                                <td>{{parts.code}}</td>
                                <td>{{parts.name}}</td>
                                <td>{{parts.stock}}</td>
                                <td>{{parts.retail_price}}</td>
                                <td>{{ getPartsDiscountPrice(parts.retail_price) }}</td>
                                <td>{{ getPartsDiscountParcentage(parts.retail_price)}}%</td>
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
                        <div class="mb-2">
                            <label for="start_time" class="form-label">End Service for Customer <b>{{serviceData.customer_name}}</b></label>
                        </div>
                        <div class="mb-2">
                            <PartsComponent :services="service.partses" :partses="partses" @addParts="addParts"/>
                        </div>
                        <div class="mb-2">
                            <label for="end_time" class="form-label">End Time</label>
                            <VueDatePicker v-model="service.end_time"></VueDatePicker>
                        </div>
                        <div class="mb-2">
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
    import PartsComponent from './PartsComponent.vue';
    import { toast } from 'vue3-toastify';

    import 'vue3-toastify/dist/index.css';
    import '@vuepic/vue-datepicker/dist/main.css'

    const props = defineProps(['services', 'partses']);
    const modalOpen = ref(false);
    const serviceData = ref({});
    const service = ref({
        id: null,
        partses:[],
        end_time: new Date(),
        remarks: '',
    });

    const getPartsPrice = ({ service_parts }) => {
        if (service_parts.length) {
            let price = 0
            price = service_parts.reduce((acc, item) => {
                return acc + (item.quantity * item.parts.retail_price)
            }, 0);
            return price;
        } else {
            return 0;
        }
    }

    const getPartsDiscountPrice = (price) => {
        const partses = props.partses;
        return (price - (100 / partses.length)).toFixed(2);
    }

    const getPartsDiscountParcentage = (price) => {
        const partses = props.partses;
        return ((100 / partses.length) / price * 100).toFixed(2);
    }

    const handleUpdate = (item) => {
        modalOpen.value = true;
        service.value.id = item.id;
        service.value.partses = item.service_parts;
    }

    const save = async () => {
        try {
            setLoading(true);
            const response = await axios.put('/services/' + service.value.id, service.value);

            if (response.status === 200) {
                toast.success(response.data.message || 'Service Updated Successfully');
                window.location.href = '/services/';
            }
        } catch (error) {
            if (error.response) {
                toast.error(error.response.data.message || 'Something went wrong');
            } else {
                toast.error(error.message || 'Unexpected error occurred');
            }
        } finally {
            setLoading(false);
        }
    }

    const addParts = () => {
        service.value.partses.push({services_id: service.value.id, parts_id: '', quantity: 1});
    }
</script>