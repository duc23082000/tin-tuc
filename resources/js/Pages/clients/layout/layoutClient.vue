<template>
  <div class="common-layout">
    <el-container>
      <el-header height="100px" class="!p-0 shadow">
        <header-nav></header-nav>
      </el-header>
      <el-main class="!px-[400px]">
        <div class="border-x-2 border-black-500">
          <div class="m-5">
            <slot></slot>
          </div>
        </div>
      </el-main>
      <el-footer>
        <hr>
        <div class="flex items-center"> 
          <small class="w-full text-center my-20">duc12345@gmail.com</small>
        </div>
      </el-footer>
    </el-container>
  </div>
</template>

<script setup>
import headerNav from './headerNav.vue';
</script>
