<template>
    <div class="grid grid-cols-4 h-full shadow">
      <div class="col-span-3 grid grid-cols-5 gap-1">
        <div class="col-span-4 flex items-center">
          <el-input
            v-model="input1"
            class="w-50 m-2"
            size="large"
            placeholder="Search..."
            :suffix-icon="Search"
          />
        </div>
        <div class="flex items-center">
          <el-button type="success" size="large" @click="search">Search</el-button>
        </div>
      </div>
      <div></div>
    </div>
</template>

<script setup>

</script>

<style>

</style>