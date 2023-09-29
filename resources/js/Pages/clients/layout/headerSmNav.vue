<template>
    <div class="h-full text-[10px] grid grid-cols-5 items-center">
      <div class="text-start ml-[-6px]">
        <el-button size="small" @click="drawer.sidebar = true"><font-awesome-icon icon="bars" /></el-button>
        <el-drawer v-model="drawer.sidebar" size="50%" title="I am the title" :with-header="false" direction="ltr">
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

      <div>
        <Link :href="route('home')" class="font-semibold" :class="selected('')">Home</Link>
      </div>

      <div @click="drawer.categories = true">
        <span class="font-semibold" :class="selected('.category')">Categories</span>
        <el-drawer v-model="drawer.categories" size="50%" title="I am the title" :with-header="false" direction="ttb">
          <div class="grid grid-cols-4 gap-2">
            <div v-for="(category, index) in categories" :key="index">
              <Link
                  class="rounded-t bg-white hover:bg-gray-50 py-2 px-4 block whitespace-no-wrap"
                  :href="route('home.category') + '?category=' + category.name"
                  >{{ category.name }}</Link
                >
            </div>
          </div>
        </el-drawer>
      </div>
      
      <div @click="drawer.authors = true">
        <span class="font-semibold" :class="selected('.author')">Author</span>
        <el-drawer v-model="drawer.authors" size="50%" title="I am the title" :with-header="false" direction="ttb">
          <div class="grid grid-cols-4 gap-2">
            <div v-for="(author, index) in authors" :key="index">
              <Link
                  class="rounded-t bg-white hover:bg-gray-50 py-2 px-4 block whitespace-no-wrap"
                  :href="route('home.author') + '?author=' + author.username"
                  >{{ author.username }}</Link
                >
            </div>
          </div>
        </el-drawer>
      </div>

      <div class="grid grid-cols-2 items-center">
        <el-dropdown trigger="click" v-if="user">
          <div class="el-dropdown-link inline-flex text-l">
            <font-awesome-icon icon="bell"/>
            <sup class="text-[#D71313]">
              <b>{{ user.unread_notifications.length }}</b>
            </sup>
          </div>
          <template #dropdown>
            <el-dropdown-menu class="w-[150px]">
              <Link 
                v-for="(notification, index) in user.notifications.slice(0, length_notification)" 
                :key="index"
                :href="route('notification.show', notification.id)">
                <el-dropdown-item class="h-[30px] !text-[10px]">
                  <p :class="notification.read_at == null ? 'text-red-400' : ''">
                    {{ notification.data.title }}
                  </p>
                  <small class="w-full flex justify-end">
                    {{ formatDate(notification.created_at) }}
                  </small>
                </el-dropdown-item>
              </Link>
              <hr>
              <div class="cursor-pointer h-5 flex items-center !text-[10px]" v-if="hiddenShow" @click="showNotification">
                <p class="w-full text-center">Show All</p>
              </div>
              <div class="cursor-pointer h-5 flex items-center !text-[10px]" v-if="!hiddenShow" @click="hiddenNotification">
                <p class="w-full text-center">Hidden Less</p>
              </div>
            </el-dropdown-menu>
          </template>
        </el-dropdown>

        <div v-if="user">
          <el-dropdown trigger="click">
            <span class="el-dropdown-link">
              <el-avatar class="!w-6 !h-6 !text-[8px]"> user </el-avatar>
            </span>
            <template #dropdown>
              <div class="w-[100px]">
                <el-dropdown-menu>
                  <el-dropdown-item class="h-[30px] !text-[10px] flex">
                    <font-awesome-icon icon="fa-user" />
                    <span class="w-full flex justify-end">Profile</span>
                  </el-dropdown-item>
                  <el-dropdown-item class="h-[30px] !text-[10px] flex">
                    <font-awesome-icon icon="fa-gears" />
                    <span class="w-full flex justify-end">Setting</span>
                  </el-dropdown-item>
                  <Link :href="route('user.logout')">
                    <el-dropdown-item  class="h-[30px] !text-[10px]">
                      <font-awesome-icon icon="fa-arrow-right-from-bracket" />
                      <span class="w-full flex justify-end">Logout</span>
                    </el-dropdown-item>
                  </Link>
                </el-dropdown-menu>
              </div>
            </template>
          </el-dropdown>
        </div>

        <Link :href="route('login')" v-if="!user" ><span class="font-semibold">Login</span></Link>
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

const drawer = ref({
  sidebar: false,
  categories: false,
  authors: false,
})

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