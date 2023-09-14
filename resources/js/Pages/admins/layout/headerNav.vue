<template>
    <div class="grid grid-cols-4 h-full shadow">
      <div class="col-span-3 grid grid-cols-5 gap-1">
        <div class="col-span-4 flex items-center">
          <el-input
            class="w-50 m-2"
            size="large"
            placeholder="Search..."
          />
        </div>
        <div class="flex items-center">
          <el-button type="success" size="large">Search</el-button>
        </div>
      </div>
      <div class="flex items-center justify-end m-10">
        <Link :href="route('admin.logout')"><el-button>Logout</el-button></Link>
      </div>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();

console.log(usePage().props.auth.user);
</script>

<style>

</style>