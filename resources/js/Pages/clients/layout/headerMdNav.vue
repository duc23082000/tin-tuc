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

        <div class="col-span-4 grid grid-cols-5 items-center relative">
          <div>
            <Link :href="route('home')" class="font-semibold" :class="selected('')">Trang chủ</Link>
          </div>
          <div class="group h-full flex items-center">
            <div
              class="text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center"
            >
              <span class="mr-1" :class="selected('.category')">Categories</span>
            </div>
            <div class="absolute hidden text-gray-700 pt-1 group-hover:block w-full h-[300px] left-0 top-[95px] bg-slate-100">
              <div class="grid grid-cols-5">
                <div class="" v-for="(category, index) in categories" :key="index">
                  <Link
                    class="rounded-t hover:bg-gray-50 py-2 px-4 block whitespace-no-wrap"
                    :href="route('home.category') + '?category=' + category.name"
                    >{{ category.name }}</Link
                  >
                </div>
              </div>
            </div>
          </div>

          <div class="group h-full flex items-center">
            <div
              class="text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center"
            >
              <span class="mr-1" :class="selected('.author')">Authors</span>
            </div>
            <ul class="absolute hidden text-gray-700 pt-1 group-hover:block w-full left-0 top-[95px] h-[300px] bg-slate-100">
              <div class="grid grid-cols-5">
                <li class="" v-for="(author, index) in authors" :key="index">
                  <Link
                    class="rounded-t hover:bg-gray-50 py-2 px-4 block whitespace-no-wrap"
                    :href="route('home.author') + '?author=' + author.username"
                    >{{ author.username }}</Link
                  >
                </li>
              </div>
            </ul>
          </div>

          <div class="group h-full flex items-center">
            <div
              class="text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center"
            >
              <span class="mr-1" :class="selected('.tag')">Tags</span>
            </div>
            <ul class="absolute hidden text-gray-700 pt-1 group-hover:block h-[400px] overflow-auto w-full left-0 top-[95px] bg-slate-100">
              <div class="grid grid-cols-5">
                <li class="" v-for="(tag, index) in tags" :key="index">
                  <Link
                    class="rounded-t hover:bg-gray-50 py-2 px-4 block whitespace-no-wrap"
                    :href="route('home.tag') + '?tag=' + tag.name"
                    >{{ tag.name }}</Link
                  >
                </li>
              </div>
            </ul>
          </div>

          <div>
            <Link :href="route('home')" class="text-gray-700 font-semibold">Đáng chú ý</Link>
          </div>
        </div>
      </div>

      <div class="flex flex-row gap-20 items-center justify-end m-10">
        <el-dropdown trigger="click" v-if="user">
          <div class="el-dropdown-link inline-flex text-2xl">
            <font-awesome-icon icon="bell"/>
            <sup class="text-[#D71313]">
              <b>{{ notifications?.unread_notifications?.length }}</b>
            </sup>
          </div>
          <template #dropdown>
            <el-dropdown-menu class="w-[300px]">
              <Link 
                v-for="(notification, index) in notifications?.notifications?.slice(0, length_notification)" 
                :key="index"
                :href="route('notification.show', notification.id)">
                <el-dropdown-item class="h-[50px]">
                  <p :class="notification.read_at == null ? 'text-red-400' : ''">
                    {{ notification.data.title }}
                  </p>
                  <small class="w-full flex justify-end">
                    {{ formatDate(notification.created_at) }}
                  </small>
                </el-dropdown-item>
              </Link>
              <hr>
              <div class="cursor-pointer h-10 flex items-center text-[0.9rem]" v-if="hiddenShow" @click="showNotification">
                <p class="w-full text-center">Show All</p>
              </div>
              <div class="cursor-pointer h-10 flex items-center text-[0.9rem]" v-if="!hiddenShow" @click="hiddenNotification">
                <p class="w-full text-center">Hidden Less</p>
              </div>
            </el-dropdown-menu>
          </template>
        </el-dropdown>

        <div v-if="user">
          <el-dropdown trigger="click">
            <span class="el-dropdown-link">
              <el-avatar> user </el-avatar>
            </span>
            <template #dropdown>
              <div class="w-[250px]">
                <el-dropdown-menu>
                  <el-dropdown-item class="h-[50px]">Profile</el-dropdown-item>
                  <el-dropdown-item class="h-[50px]">Setting</el-dropdown-item>
                  <Link :href="route('user.logout')">
                    <el-dropdown-item  class="h-[50px]">Logout</el-dropdown-item>
                  </Link>
                </el-dropdown-menu>
              </div>
            </template>
          </el-dropdown>
        </div>

        <Link :href="route('login')" v-if="!user" ><el-button>Login</el-button></Link>
      </div>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { handleError, h } from 'vue';
import { ref, watchEffect } from 'vue';
import { router } from '@inertiajs/vue3';
import moment from 'moment';
import { ElNotification } from 'element-plus';


const user = usePage().props.auth.user;

const categories = ref({});

const length_notification = ref(7)

const hiddenShow = ref(true)

const authors = ref({});

const tags = ref({});

const search = ref('')

const notifications = ref({})

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
  length_notification.value = notifications.notifications.length;
  hiddenShow.value = !hiddenShow.value
}

const getNotifications = () => {
  axios.get(route('api.notification.all'))
  .then(function(respornse){
    notifications.value = respornse.data
  })
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

watchEffect([getCategories, getAuthors, getTags, getNotifications])

Echo.private(`notification.${user.id}`)
    .listen('.notification.user', (data) => {
        if(data.created_by){
          getNotifications()
          ElNotification({
            title: 'Thông báo Mới',
            message: h('i', { style: 'color: teal' }, 'Bạn có 1 thông báo từ' + data.created_by),
          })
        }
    });

</script>

<style>

</style>