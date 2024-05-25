<script setup>

import {ref} from "vue";
import InputTextArea from "@/Components/app/InputTextArea.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import PostModal from "@/Components/app/PostModal.vue";

const authUser =usePage().props.auth.user
const  showModel=ref(false)
const newPost = ref({
  id: null,
  body :'',
  user : authUser
})


function  showCreatePostModel(){
  showModel.value = true
}

</script>

<template>
  <div class="p-4 bg-white rounded-lg border">
    <div   @click="showCreatePostModel"
         class="py-2 px-3 border-2 border-gray-200 text-gray-500 rounded-md  mb-3 w-full"

      >Create Post here
      </div>

<!--    <div  class="flex gap-2 justify-between">-->
<!--      <button type="button" class="rounded-md bg-indigo-600 px-3 py-2-->
<!--                                   text-sm font-semibold text-white shadow-sm hover:bg-indigo-500-->
<!--                                   focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2-->
<!--                                   focus-visible:outline-indigo-600 relative">-->
<!--        Attach File-->
<!--        <input type="file" class="absolute top-0 bottom-0 right-0 left-0 opacity-0" />-->
<!--      </button>-->
<!--      <button @click="submit" type="submit" class="rounded-md bg-indigo-600 px-3 py-2-->
<!--                                   text-sm font-semibold text-white shadow-sm hover:bg-indigo-500-->
<!--                                   focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2-->
<!--                                   focus-visible:outline-indigo-600">-->
<!--        Submit-->
<!--      </button>-->
<!--    </div>-->

    <PostModal  :post="newPost" v-model="showModel"/>
  </div>
</template>

<style scoped>

</style>