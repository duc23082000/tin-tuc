<template>
  <div class="common-layout">
    <el-container>
      <el-aside class="hidden md:grid md:fixed left-0 right-0" width="200px">
        <side-bar></side-bar>
      </el-aside>
      <el-container>
        <el-header class="md:!h-[100px] !p-0 fixed left-0 right-0 !z-30 bg-white md:!ml-[200px]" >
          <header-nav></header-nav>
        </el-header>
        <el-main class="h-screen !p-0 mt-[70px] md:!mt-[100px] md:ml-[200px] md:!p-5 !z-10">
          <slot></slot>
        </el-main>
      </el-container>
    </el-container>
  </div>
</template>

<script setup>
    import headerNav from './headerNav.vue';
    import sideBar from './sideBar.vue';
</script>

<style>

</style>