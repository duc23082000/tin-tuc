<template>
  <div class="common-layout">
    <el-container>
      <el-header height="100px" class="!p-0 shadow">
        <header-nav></header-nav>
      </el-header>
      <el-main class="!px-[400px]">
        <slot></slot>
      </el-main>
      <el-footer><hr></el-footer>
    </el-container>
  </div>
</template>

<script setup>
import headerNav from './headerNav.vue';
</script>
