<template>
    <layout-client>
        <div class="grid grid-cols-4">
            <div class="col-span-3">
                <h1 class="text-2xl">
                    <strong>{{ props.post.title }}</strong>
                </h1>
            </div>
            <div class="col-span-1">
                <p class="text-sm flex items-center h-full">{{ props.post.posted_at }}</p>
            </div>
        </div>
        <hr>
        <div class="my-2 image">
            <img :src="'storage/images/' + props.post.image" alt="">
        </div>
        <div v-html="props.post.content ?? '...'"></div>

        <div class="shadow-sm h-[35px] bg-gray-100 mt-5">
            <div class="h-full flex items-center mx-3">
              <el-button type="primary" size="small"><font-awesome-icon icon="fa-thumbs-up" class="mr-2"/> Thích {{ props.post.likes.length }}</el-button>
              <el-button type="primary" size="small"><font-awesome-icon icon="share-from-square" class="mr-2"/> Chia sẻ</el-button>
              <el-button type="primary" size="small"><font-awesome-icon icon="comment" class="mr-2"/> Bình luận</el-button>
            </div>
        </div>

    </layout-client>
</template>

<script setup>
import LayoutClient from '../../layout/layoutClient.vue'

const props = defineProps(['post', 'comments'])

console.log(props.post);

</script>

<style>
.image{
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>