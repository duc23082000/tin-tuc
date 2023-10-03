<template>
  <div class="w-full grid md:grid-cols-4 h-full shadow">
    <div class="hidden md:col-span-3 md:grid grid-cols-5 gap-1">
      <div class="md:col-span-4 flex items-center">
        <el-input class="w-50 m-2" size="large" placeholder="Search..." />
      </div>
      <div class="md:flex items-center">
        <el-button type="success" size="large">Search</el-button>
      </div>
    </div>

    <div class="flex items-center w-full pr-[10px] md:pr-[50px]">
      <div class="md:hidden text-start ml-[-6px]">
        <el-button size="small" @click="drawer.sidebar = true"><font-awesome-icon icon="bars" /></el-button>
        <el-drawer v-model="drawer.sidebar" size="60%" title="I am the title" :with-header="false" direction="ltr">
          <div class="p-6">
            Menu
            <hr>
          </div>
          <el-menu active-text-color="#ffd04b" class="el-menu-vertical-demo !border-r-0 w-full" :default-active="active">
            <el-sub-menu index="1">
              <template #title>
                <el-icon>
                  <Document />
                </el-icon>
                <span>Posts</span>
              </template>
              <Link :href="route('admin.post.lists')"><el-menu-item index="1-1">List</el-menu-item></Link>
              <Link :href="route('admin.post.create')"><el-menu-item index="1-2">Create</el-menu-item></Link>
            </el-sub-menu>
            <el-sub-menu index="2">
              <template #title>
                <el-icon>
                  <Grid />
                </el-icon>
                <span>Categories</span>
              </template>
              <Link :href="route('admin.category.lists')"><el-menu-item index="2-1">List</el-menu-item></Link>
              <Link :href="route('admin.category.create')"><el-menu-item index="2-2">Create</el-menu-item></Link>
            </el-sub-menu>
            <el-sub-menu index="3">
              <template #title>
                <el-icon>
                  <Bell />
                </el-icon>
                <span>Notifications</span>
              </template>
              <Link :href="route('admin.notice.lists')"><el-menu-item index="3-1">List</el-menu-item></Link>
              <Link :href="route('admin.notice.create')"><el-menu-item index="3-2">Create</el-menu-item></Link>
            </el-sub-menu>
            <el-sub-menu index="4">
              <template #title>
                <el-icon><EditPen /></el-icon>
                <span>Authors</span>
              </template>
              <Link :href="route('admin.author.lists')"><el-menu-item index="4-1">List</el-menu-item></Link>
              <Link :href="route('admin.author.create')"><el-menu-item index="4-2">Create</el-menu-item></Link>
            </el-sub-menu>
            <el-sub-menu index="5">
              <template #title>
                <el-icon><User /></el-icon>
                <span>User</span>
              </template>
              <Link :href="route('admin.user.lists')"><el-menu-item index="5-1">List</el-menu-item></Link>
              <Link :href="route('admin.user.create')"><el-menu-item index="5-2">Create</el-menu-item></Link>
            </el-sub-menu>
          </el-menu>
        </el-drawer>
      </div>

      <div class="flex items-center justify-end w-full">
        <Link :href="route('admin.logout')" class="text-[12px] md:text-lg font-semibold">Logout</Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
  Document,
  Menu as IconMenu,
  Grid,
  Bell,
  EditPen,
  User,
} from '@element-plus/icons-vue'

const drawer = ref({
  sidebar: false
})

const active = ref('')

switch(window.location.href){
  case route('admin.post.lists'):
    active.value = "1-1"
    break
  case route('admin.post.create'):
    active.value = "1-2"
    break
  case route('admin.category.lists'):
    active.value = "2-1"
    break
  case route('admin.category.create'):
    active.value = "2-2"
    break
  case route('admin.notice.lists'):
    active.value = "3-1"
    break
  case route('admin.notice.create'):
    active.value = "3-2"
    break
  case route('admin.author.lists'):
    active.value = "4-1"
    break
  case route('admin.author.create'):
    active.value = "4-2"
    break
  case route('admin.user.lists'):
    active.value = "5-1"
    break
  case route('admin.user.create'):
    active.value = "5-2"
    break
}

const page = usePage();

</script>

<style></style>