<template>
    <div class="grid grid-cols-6 h-full">
      <div class="col-span-5 grid grid-cols-6 gap-1">

        <div class="col-span-2 grid grid-cols-5">
          <div class="col-span-3 flex items-center">
            <el-input
              class="w-20 m-2"
              size="large"
              placeholder="Search..."
              v-model="search"
            />
          </div>
          <div class="flex items-center">
            <el-button type="success" size="large" @click="handleSearch">Search</el-button>
          </div>
        </div>

        <div class="col-span-4 grid grid-cols-5 items-center">
          <div>
            <Link :href="route('home')" class="text-gray-700 font-semibold">Trang chủ</Link>
          </div>
          <div class="group inline-block relative">
            <div
              class="text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center"
            >
              <span class="mr-1">Categories</span>
            </div>
            <ul class="absolute hidden text-gray-700 pt-1 group-hover:block">
              <li class="" v-for="(category, index) in categories" :key="index">
                <Link
                  class="rounded-t bg-white hover:bg-gray-50 py-2 px-4 block whitespace-no-wrap"
                  :href="route('home.category') + '?category=' + category.name"
                  >{{ category.name }}</Link
                >
              </li>
            </ul>
          </div>

          <div class="group inline-block relative">
            <div
              class="text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center"
            >
              <span class="mr-1">Authors</span>
            </div>
            <ul class="absolute hidden text-gray-700 pt-1 group-hover:block">
              <li class="" v-for="(author, index) in authors" :key="index">
                <Link
                  class="rounded-t bg-white hover:bg-gray-50 py-2 px-4 block whitespace-no-wrap"
                  :href="route('home.author') + '?author=' + author.username"
                  >{{ author.username }}</Link
                >
              </li>
            </ul>
          </div>

          <div class="group inline-block relative">
            <div
              class="text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center"
            >
              <span class="mr-1">Tags</span>
            </div>
            <ul class="absolute hidden text-gray-700 pt-1 group-hover:block h-[400px] overflow-auto">
              <li class="" v-for="(tag, index) in tags" :key="index">
                <Link
                  class="rounded-t bg-white hover:bg-gray-50 py-2 px-4 block whitespace-no-wrap"
                  :href="route('home.tag') + '?tag=' + tag.name"
                  >{{ tag.name }}</Link
                >
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="flex items-center justify-end m-10">
        <Link :href="route('user.logout')" v-if="page.props.auth.user"><el-button>Logout</el-button></Link>
        <Link :href="route('login')" v-if="!page.props.auth.user"><el-button>Login</el-button></Link>
      </div>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { handleError } from 'vue';
import { ref, watchEffect } from 'vue';
import { router } from '@inertiajs/vue3';

const page = usePage();

const categories = ref({});

const authors = ref({});

const tags = ref({});

const search = ref('')

const getCategories = () => {
  axios.get(route('home.api.categories'))
  .then(function(respornse){
    categories.value = respornse.data
    console.log(3);

  })
  .catch(function(errors){
    console.log(errors);
  })
}

const getAuthors = () => {
  axios.get(route('home.api.authors'))
  .then(function(respornse){
    authors.value = respornse.data
    console.log(2);

  })
  .catch(function(errors){
    console.log(errors);
  })
}

const getTags = () => {
  axios.get(route('home.api.tags'))
  .then(function(respornse){
    tags.value = respornse.data
    console.log(1);
  })
  .catch(function(errors){
    console.log(errors);
  })
}

const handleSearch = () => {
  router.visit(route('home.search') + '?search=' + search.value)
}

watchEffect([getCategories, getAuthors, getTags])
// getCategories()
// getTags()
// getAuthors()

</script>

<style>

</style>