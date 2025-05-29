<template>
    <div class="card mt-2">
        <div class="card-body">
            <div v-for="(item, index) in services" :key="index" class="row">
                <div class="col-8">
                    <label class="form-label">Select Parts</label>
                    <select v-model="services[index].parts_id" class="form-select">
                        <option v-for="(parts, index) in partses" :key="index" :value="parts.id">{{parts.name}}</option>
                    </select>
                </div>
                <div class="col-4">
                    <label class="form-label">Quantity</label>
                    <input type="number" v-model="services[index].quantity" class="form-control" placeholder="Quantity">
                </div>
            </div>
            <div class="col">
                <div class="d-flex justify-content-end">
                    <button type="button" @click.prevent="emit('addParts')" class="btn btn-primary mt-2">Add Parts</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import {ref} from 'vue';

    const props = defineProps(['services', 'partses']);

    const emit = defineEmits('addParts');
</script>