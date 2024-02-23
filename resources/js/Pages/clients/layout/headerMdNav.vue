<template>
    <div class="grid grid-cols-5 h-full">
      <div class="col-span-4 grid grid-cols-8 gap-1">
        <div class="col-span-2 grid grid-cols-4">
          <div class="col-span-3 flex items-center">
            <el-input
              class="w-20 m-2"
              placeholder="Search..."
              v-model="search"
            />
          </div>
          <div class="flex items-center">
            <el-button @click="handleSearch">Search</el-button>
          </div>
        </div>

        <div class="col-span-6 grid grid-cols-5 items-center relative">
          <div class="flex justify-center">
            <Link :href="route('home')" class="font-semibold" :class="usePageStore().selected('') ?? 'text-blue-400'">Trang chủ</Link>
          </div>
          <div class="group h-full flex items-center">
            <div
              class="font-semibold py-2 px-4 rounded w-full inline-flex items-center justify-center"
            >
              <span class="mr-1" :class="usePageStore().selected('.category')">Categories</span>
            </div>
            <div class="absolute hidden text-gray-700 pt-1 group-hover:block w-full h-[200px] left-0 top-[95px] bg-white shadow rounded-[6px]">
              <div class="grid grid-cols-5">
                <div class="" v-for="(category, index) in usePageStore().categories" :key="index">
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
              class="font-semibold py-2 px-4 rounded w-full inline-flex items-center justify-center"
            >
              <span class="mr-1" :class="usePageStore().selected('.author')">Authors</span>
            </div>
            <ul class="absolute hidden text-gray-700 pt-1 group-hover:block w-full left-0 top-[95px] h-[200px] bg-white shadow rounded-[6px]">
              <div class="grid grid-cols-5">
                <li class="" v-for="(author, index) in usePageStore().authors" :key="index">
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
              class="font-semibold py-2 px-4 rounded w-full inline-flex items-center justify-center"
            >
              <span class="mr-1" :class="usePageStore().selected('.tag')">Tags</span>
            </div>
            <ul class="absolute hidden text-gray-700 pt-1 group-hover:block h-[300px] overflow-auto w-full left-0 top-[95px] bg-white shadow rounded-[6px]">
              <div class="grid grid-cols-5">
                <li class="" v-for="(tag, index) in usePageStore().tags" :key="index">
                  <Link
                    class="rounded-t hover:bg-gray-50 py-2 px-4 block whitespace-no-wrap"
                    :href="route('home.tag') + '?tag=' + tag.name"
                    >{{ tag.name }}</Link
                  >
                </li>
              </div>
            </ul>
          </div>

          <div class="flex justify-center">
            <Link :href="route('home')" class="text-gray-700 font-semibold">Đáng chú ý</Link>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-3 items-center justify-between m-10">
        <div class="col-span-2 grid grid-cols-4 h-[full] !ml-0">
            <a href="https://www.youtube.com/channel/UCIW9cGgoRuGJnky3K3tbzNg">
                <img src="https://thanhnien-static.mediacdn.vn/thanhnien.vn/image/icon_youtube_fill.svg">
            </a>
            <a href="https://www.facebook.com/thanhnien" class="item" ref="nofollow">
                <img src="https://thanhnien-static.mediacdn.vn/thanhnien.vn/image/icon_facebook_full_color.svg" >
            </a>
            <a href="https://www.tiktok.com/@baothanhnien.official" class="item">
                <img src="https://thanhnien-static.mediacdn.vn/thanhnien.vn/image/Icon_Tiktok_fill.svg" alt="Tiktok" >

            </a>
            <a href="https://zalo.me/2431025964363015388" class="item" ref="nofollow">
                <img src="https://thanhnien-static.mediacdn.vn/thanhnien.vn/image/icon_zalo_full_color.svg" alt="Zalo">
            </a>
        </div>
        <div class="flex justify-between">
          <el-dropdown trigger="click" v-if="user" class="flex justify-center">
            <div class="el-dropdown-link inline-flex text-2xl">
              <font-awesome-icon icon="bell"/>
              <sup class="text-[#D71313]">
                <b>{{ useUsersStore().notifications?.unread_notifications?.length }}</b>
              </sup>
            </div>
            <template #dropdown>
              <el-dropdown-menu class="w-[300px]">
                <Link 
                  v-for="(notification, index) in useUsersStore().notifications?.notifications?.slice(0, length_notification)" 
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

          <div v-if="user" class="flex justify-center">
            <el-dropdown trigger="click">
              <span class="el-dropdown-link">
                <el-avatar> user </el-avatar>
              </span>
              <template #dropdown>
                <div class="w-[250px]">
                  <el-dropdown-menu>
                    <el-dropdown-item class="h-[50px]">Profile</el-dropdown-item>
                    <el-dropdown-item class="h-[50px]">Setting</el-dropdown-item>
                    <a :href="route('user.logout')">
                      <el-dropdown-item  class="h-[50px]">Logout</el-dropdown-item>
                    </a>
                  </el-dropdown-menu>
                </div>
              </template>
            </el-dropdown>
          </div>
          <div class="w-full flex justify-end" v-if="!user">
            <Link :href="route('login')"><el-button>Login</el-button></Link>
          </div>
        </div>
      </div>
    </div>
</template>

<script setup>
import { ref, h } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import moment from 'moment';
import { ElNotification } from 'element-plus';
import { usePageStore, useUsersStore } from '@/stores/store.js'


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

if(user){
  Echo.private(`notification.${user.id}`)
    .listen('.notification.user', (data) => {
        if(data.created_by){
          useUsersStore().getNotifications()
          ElNotification({
            title: 'Thông báo Mới',
            message: h('i', { style: 'color: teal' }, 'Bạn có 1 thông báo từ' + data.created_by),
          })
        }
    });
}

</script>

<style>

</style>