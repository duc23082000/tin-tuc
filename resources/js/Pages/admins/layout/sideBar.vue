<template>
  <el-row class="h-[100px]">
    <div class="w-full">image</div>
  </el-row>
  <el-row v-if="user.role == 0">
    <el-menu
        active-text-color="#ffd04b"
        background-color="#545c64"
        class="el-menu-vertical-demo w-full"
        :default-active="active"
        text-color="#fff"
      >
        <el-sub-menu index="1">
          <template #title>
            <el-icon><location /></el-icon>
            <span>Posts</span>
          </template>
          <Link :href="route('admin.post.lists')"><el-menu-item index="1-1">List</el-menu-item></Link>
          <Link :href="route('admin.post.create')"><el-menu-item index="1-2">Create</el-menu-item></Link>
        </el-sub-menu>
        <el-sub-menu index="2">
          <template #title>
            <el-icon><Grid /></el-icon>
            <span>Categories</span>
          </template>
          <Link :href="route('admin.category.lists')"><el-menu-item index="2-1">List</el-menu-item></Link>
          <Link :href="route('admin.category.create')"><el-menu-item index="2-2">Create</el-menu-item></Link>
        </el-sub-menu>
        <el-sub-menu index="3">
          <template #title>
            <el-icon><Bell /></el-icon>
            <span>Notifications</span>
          </template>
          <Link :href="route('admin.notice.lists')"><el-menu-item index="3-1">List</el-menu-item></Link>
          <Link :href="route('admin.notice.create')"><el-menu-item index="3-2">Create</el-menu-item></Link>
        </el-sub-menu>
      </el-menu>
  </el-row>

  <el-row v-if="user.role == 1">
    <el-menu
        active-text-color="#ffd04b"
        background-color="#545c64"
        class="el-menu-vertical-demo w-full"
        default-active="2"
        text-color="#fff"
      >
        <el-sub-menu index="1">
          <template #title>
            <el-icon><location /></el-icon>
            <span>Posts</span>
          </template>
          <Link :href="route('author.post.lists')"><el-menu-item>List</el-menu-item></Link>
          <Link :href="route('author.post.create')"><el-menu-item>Create</el-menu-item></Link>
        </el-sub-menu>
      </el-menu>
  </el-row>
</template>

<script lang="ts" setup>
import {
  Document,
  Menu as IconMenu,
  Location,
  Setting,
  Grid,
  Bell,
} from '@element-plus/icons-vue'
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const active = ref("");

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
}


const user = usePage().props.auth.user;

</script>

<style>
.el-menu-vertical-demo {
  height: 100vh;
}

</style>