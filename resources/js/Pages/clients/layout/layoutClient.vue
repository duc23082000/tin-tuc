<template>
  <div class="common-layout">
    <el-container>
      <el-header height="100px" class="!p-0 bg-slate-400">
        <header-nav></header-nav>
      </el-header>
      <el-main>Main</el-main>
      <el-footer>Footer</el-footer>
    </el-container>
  </div>
</template>

<script setup>
import headerNav from './headerNav.vue';
</script>
