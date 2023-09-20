<template>
    <div class="grid grid-cols-4 h-full">
      <div class="col-span-3 grid grid-cols-5 gap-1">
        <div class="col-span-2"></div>
        <div class="flex items-center">
          
        </div>
      </div>
      <div class="flex items-center justify-end m-10">
        <Link :href="route('admin.logout')"><el-button>Logout</el-button></Link>
      </div>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { watchEffect } from 'vue';

const page = usePage();

const getCategories = () => {
  axios.get(route('home.api.categories'))
  .then(function(respornse){
    console.log(respornse.data);
  })
  .catch(function(errors){
    console.log(errors);
  })
}

watchEffect(getCategories)

</script>

<style>

</style>