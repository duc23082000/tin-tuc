<template>
    <div class="h-full text-[10px] grid grid-cols-5 items-center">
      <div class="text-start ml-[-6px]">
        <el-button size="small" @click="drawer = true"><font-awesome-icon icon="bars" /></el-button>
        <el-drawer v-model="drawer" size="50%" title="I am the title" :with-header="false" direction="ltr">
          <div class="grid grid-cols-4 gap-1 text-xs">
            <el-input
              v-model="search"
              class="w-50 col-span-3"
              size="small"
              placeholder="Search"
            />
            <el-button class="w-50" size="small" @click="handleSearch"><font-awesome-icon icon="magnifying-glass" /></el-button>
          </div>
        </el-drawer>
      </div>
      <div >Home</div>
      <div >Categories</div>
      <div >Author</div>
      <div >
        Login
      </div>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { handleError } from 'vue';
import { ref, watchEffect } from 'vue';
import { router } from '@inertiajs/vue3';
import moment from 'moment';

const drawer = ref(false)

const user = usePage().props.auth.user;

const categories = ref({});

const length_notification = ref(7)

const hiddenShow = ref(true)

const authors = ref({});

const tags = ref({});

const search = ref('')

const selected = (url) => { 
  const pathname = ref(window.location.pathname);
  if (pathname.value == '/') {
    pathname.value  = '';
  }
  return window.location.origin + pathname.value == route('home' + url) ? 'text-blue-400' : 'text-gray-700';
}

const getCategories = () => {
  axios.get(route('home.api.categories'))
  .then(function(respornse){
    categories.value = respornse.data

  })
  .catch(function(errors){
    console.log(errors);
  })
}

const showNotification = () => {
  length_notification.value = user.notifications.length;
  hiddenShow.value = !hiddenShow.value
}

const hiddenNotification = () => {
  length_notification.value = 7;
  hiddenShow.value = !hiddenShow.value
}

const getAuthors = () => {
  axios.get(route('home.api.authors'))
  .then(function(respornse){
    authors.value = respornse.data

  })
  .catch(function(errors){
    console.log(errors);
  })
}

const formatDate = (date) => {
  return moment(date).format('HH:mm DD/MM');
}

const getTags = () => {
  axios.get(route('home.api.tags'))
  .then(function(respornse){
    tags.value = respornse.data
  })
  .catch(function(errors){
    console.log(errors);
  })
}

const handleSearch = () => {
  router.visit(route('home.search') + '?search=' + search.value)
}

watchEffect([getCategories, getAuthors, getTags])

</script>

<style>

</style>