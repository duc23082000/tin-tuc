<template>
    <layout-client>
        <strong v-if="props.category != null" class="text-xl">Tìm kiếm theo Danh mục "{{ props.category }}"</strong>
        <strong v-if="props.author != null" class="text-xl">Tìm kiếm theo Tác giả "{{ props.author }}"</strong>
        <strong v-if="props.tag != null" class="text-xl">Tìm kiếm theo Tag "{{ props.tag }}"</strong>
        <strong v-if="props.search != null" class="text-xl">Tìm kiếm theo Từ khóa "{{ props.search }}"</strong>
        <div class="container">
            <div v-for="(post, index) in props.posts.data" :key="index">
                <Link :href="route('home.show', post.title)" class="grid grid-cols-3 mt-10">
                    <div class="col-span-1 mr-5 w-[348px] h-[232px]">
                        <img :src="'storage/images/' + post.image" alt="ko co anh">
                    </div>
                    <div class="col-span-2">
                        {{ post.title }}
                    </div>
                </Link>
            </div>
        </div>
    </layout-client>
</template>

<script setup>
import LayoutClient from '../../layout/layoutClient.vue'
import { Link } from '@inertiajs/vue3';


const props = defineProps(['posts', 'search', 'category', 'author', 'tag'])

</script>

<style>

</style>