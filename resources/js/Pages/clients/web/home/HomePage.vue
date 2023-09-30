<template>
    <layout-client>
        <h1 class="mb-5">
            <strong v-if="props.category != null" class="text-xl">Tìm kiếm theo Danh mục "{{ props.category }}"</strong>
            <strong v-if="props.author != null" class="text-xl">Tìm kiếm theo Tác giả "{{ props.author }}"</strong>
            <strong v-if="props.tag != null" class="text-xl">Tìm kiếm theo Tag "{{ props.tag }}"</strong>
            <strong v-if="props.search != null" class="text-xl">Tìm kiếm theo Từ khóa "{{ props.search }}"</strong>
        </h1>
        <div class="container">
            <div v-if="props.posts.data.length == 0" class="mt-1 md:mt-10">
                <p class="text-2xl">...</p>
                <p>Không tìm thấy bài nào viết hợp lệ.</p>
            </div>
            <div v-for="(post, index) in props.posts.data" :key="index" class="mb-10">
                <Link :href="route('home.show', post.title)" class="md:grid md:grid-cols-3 ">
                    <div class="md:col-span-1 md:mr-5 h-[200px] w-[300px] md:w-[348px] md:h-[232px]">
                        <img :src="'storage/images/' + post.image" alt="ko co anh">
                    </div>
                    <div class="md:col-span-2 text-[14px] md:text-lg">
                        {{ post.title }}
                    </div>
                </Link>
                <hr class="md:hidden" :class="index == props.posts.data.length - 1 ? 'hidden' : ''">
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