<template>
  <div class="common-layout">
    <el-container>
      <el-header class="!h-[50px] md:!h-[100px] !p-0 shadow fixed z-30 left-0 right-0 bg-white">
        <header-md-nav class="hidden md:grid"></header-md-nav>
        <header-sm-nav class="md:hidden"></header-sm-nav>
      </el-header>
      <el-main class="md:!px-[400px] mt-[50px] md:mt-[100px]">
        <div class="md:border-x-2 md:border-black-500">
          <div class="md:m-5 mb-2">
            <slot></slot>
          </div>
        </div>
        <hr>
      </el-main>
      <el-footer>
        <div class="flex items-center"> 
          <small class="w-full text-center my-20">duc12345@gmail.com</small>
        </div>
      </el-footer>
    </el-container>
  </div>
</template>

<script setup>
import headerMdNav from './headerMdNav.vue';
import headerSmNav from './headerSmNav.vue';
</script>
