<script setup>
import PostItem from "@/Components/app/PostItem.vue";
import PostModal from "@/Components/app/PostModal.vue";
import {ref} from "vue";
import {usePage} from "@inertiajs/vue3";
import AttachmentPreviewModal from "@/Components/app/AttachmentPreviewModal.vue";


defineProps({
  posts : Array
})
const showEditModel = ref(false)
const showAttachmentModal = ref(false)
const editPost = ref({})
const previewAttachmentsPost = ref({})
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
function  openAttachmentPreview(post,index){
  previewAttachmentsPost.value= {
    post,
    index
  };
  showAttachmentModal.value = true;
}
</script>

<template >
  <div class=" overflow-auto">

    <PostItem  v-for="post of posts" :key="post.id" :post="post"
               @editClick="openEditModel"
                @attachmentClick="openAttachmentPreview"
    />
    <PostModal  :post="editPost" v-model="showEditModel" @hide="onModulaHide"/>
    <AttachmentPreviewModal  v-model="showAttachmentModal"
                             :attachment="previewAttachmentsPost.post?.attachement || []"
                            v-model:index="previewAttachmentsPost.index"
    />
  </div>

</template>

<style scoped>

</style>