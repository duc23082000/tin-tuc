<template>
  <div class="common-layout">
    <el-container>
      <el-header>
        <header-nav></header-nav>
      </el-header>
      <el-container>
        <el-aside width="200px">
            <side-bar></side-bar>
        </el-aside>
        <el-main>
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