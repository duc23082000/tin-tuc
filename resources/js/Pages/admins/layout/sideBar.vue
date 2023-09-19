<template>
  <el-row class="mb-4">
    <div class="w-full">image</div>
  </el-row>
  <el-row>
    <el-menu
        active-text-color="#ffd04b"
        background-color="#545c64"
        class="el-menu-vertical-demo"
        default-active="2"
        text-color="#fff"
      >
        <el-sub-menu index="1">
          <template #title>
            <el-icon><location /></el-icon>
            <span>Posts</span>
          </template>
          <Link :href="route('admin.post.lists')"><el-menu-item>List</el-menu-item></Link>
          <Link :href="route('admin.post.create')"><el-menu-item>Create</el-menu-item></Link>
        </el-sub-menu>
        <el-sub-menu index="2">
          <template #title>
            <el-icon><Grid /></el-icon>
            <span>Categories</span>
          </template>
          <Link :href="route('admin.category.lists')"><el-menu-item>List</el-menu-item></Link>
          <Link :href="route('admin.category.create')"><el-menu-item>Create</el-menu-item></Link>
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
import { Link } from '@inertiajs/vue3';
</script>

<style>
.el-menu-vertical-demo {
  height: 100vh;
}

</style>