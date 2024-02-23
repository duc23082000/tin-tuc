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

          <div class="mt-5">
            <div class="mt-1 flex-row">
              <div class="flex">
                <span class="!w-20 font-semibold ">Mới nhất</span>
                <div class="flex justify-end w-full items-end m-[2px]">
                  <font-awesome-icon icon="angle-right"  class="text-[10px]"/>
                </div>
              </div>
              <hr class="row-span-1">
            </div>
          </div>

          <div class="mt-5">
            <div class="mt-1 flex-row">
              <div class="flex">
                <span class="!w-20 font-semibold ">Hôm qua</span>
                <div class="flex justify-end w-full items-end m-[2px]">
                  <font-awesome-icon icon="angle-right"  class="text-[10px]"/>
                </div>
              </div>
              <hr class="row-span-1">
            </div>
          </div>

          <div class="mt-5">
            <div class="mt-1 flex-row">
              <div class="flex">
                <span class="!w-20 font-semibold ">Tuần trước</span>
                <div class="flex justify-end w-full items-end m-[2px]">
                  <font-awesome-icon icon="angle-right"  class="text-[10px]"/>
                </div>
              </div>
              <hr class="row-span-1">
            </div>
          </div>

        </el-drawer>
      </div>

      <div>
        <Link :href="route('home')" class="font-semibold" :class="usePageStore().selected('')">Home</Link>
      </div>

      <div @click="drawer.categories = true">
        <span class="font-semibold" :class="usePageStore().selected('.category')">Categories</span>
        <el-drawer v-model="drawer.categories" size="50%" title="I am the title" :with-header="false" direction="ttb">
          <div class="grid grid-cols-4 gap-2">
            <div v-for="(category, index) in usePageStore().categories" :key="index">
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
        <span class="font-semibold" :class="usePageStore().selected('.author')">Author</span>
        <el-drawer v-model="drawer.authors" size="50%" title="I am the title" :with-header="false" direction="ttb">
          <div class="grid grid-cols-4 gap-2">
            <div v-for="(author, index) in usePageStore().authors" :key="index">
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
              <b>{{ useUsersStore().notifications?.unread_notifications?.length }}</b>
            </sup>
          </div>
          <template #dropdown>
            <el-dropdown-menu class="w-[150px] bg-white">
              <Link 
                v-for="(notification, index) in useUsersStore().notifications?.notifications?.slice(0, length_notification)" 
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
                  <a :href="route('user.logout')">
                    <el-dropdown-item  class="h-[30px] !text-[10px]">
                      <font-awesome-icon icon="fa-arrow-right-from-bracket" />
                      <span class="w-full flex justify-end">Logout</span>
                    </el-dropdown-item>
                  </a>
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
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import moment from 'moment';
import { useUsersStore, usePageStore } from '@/stores/store.js'

const drawer = ref({
  sidebar: false,
  categories: false,
  authors: false,
})

const user = useUsersStore().user;
const length_notification = ref(7)
const hiddenShow = ref(true)
const search = ref('')

const showNotification = () => {
  length_notification.value = useUsersStore().notifications.notifications.length;
  hiddenShow.value = !hiddenShow.value
}

const hiddenNotification = () => {
  length_notification.value = 7;
  hiddenShow.value = !hiddenShow.value
}

const formatDate = (date) => {
  return moment(date).format('HH:mm DD/MM');
}

const handleSearch = () => {
  router.visit(route('home.search') + '?search=' + search.value)
}

</script>

<style>

</style>