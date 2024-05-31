<script setup>
import PostItem from "@/Components/app/PostItem.vue";
import PostModal from "@/Components/app/PostModal.vue";
import {ref} from "vue";
import {usePage} from "@inertiajs/vue3";

defineProps({
  posts : Array
})
const showEditModel = ref(false)
const editPost = ref({})

function  openEditModel(post){
  editPost.value=post;
  showEditModel.value = true;
}
const authUser =usePage().props.auth.user
function onModulaHide(){
  editPost.value= {  id: null,
    body :'',
    user : authUser}
}

</script>

<template >
  <div class=" overflow-auto">
    <PostItem  v-for="post of posts" :key="post.id" :post="post" @editClick="openEditModel"/>
    <PostModal  :post="editPost" v-model="showEditModel" @hide="onModulaHide"/>
  </div>

</template>

<style scoped>

</style>