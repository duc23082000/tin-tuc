<template>
    <layout-client>
        <div class="grid grid-cols-4">
            <div class="col-span-3">
                <h1 class="text-2xl">
                    <strong>{{ notificationData.data.title }}</strong>
                </h1>
            </div>
            <div class="col-span-1">
                <p class="text-sm flex items-center h-full">{{ formatDate(notificationData.created_at) }}</p>
            </div>
        </div>
        <hr>
        <div v-html="notificationData.data.content ?? '...'"></div>
    </layout-client>
</template>

<script setup>
import { ref } from 'vue';
import LayoutClient from '../../layout/layoutClient.vue';
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import moment from 'moment';

const props = defineProps(['notification', 'comments'])

const notificationData = ref(props.notification);

const formatDate = (date) => {
  return moment(date).format('HH:mm-DD/MM/YYYY');
}

</script>

<style>
.image{
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>