<script setup>

import {ref} from "vue";
import InputTextArea from "@/Components/app/InputTextArea.vue";
import {useForm} from "@inertiajs/vue3";

const  postcreating=ref(false)

const newPostForm = useForm({
  body:''
})
function  submit(){
  newPostForm.post(route('post.create'),{
    onSuccess:()=>{
      newPostForm.reset()
    }
  })
}
</script>

<template>
  <div class="p-4 bg-white rounded-lg border">
    <InputTextArea @click="postcreating = true"
         class="mb-3 w-full" rows="1"
        placeholder="Create Post here"
       v-model="newPostForm.body"
      />

    <div v-if="postcreating"
        class="flex gap-2 justify-between">
      <button type="button" class="rounded-md bg-indigo-600 px-3 py-2
                                   text-sm font-semibold text-white shadow-sm hover:bg-indigo-500
                                   focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                                   focus-visible:outline-indigo-600 relative">
        Attach File
        <input type="file" class="absolute top-0 bottom-0 right-0 left-0 opacity-0" />
      </button>
      <button @click="submit" type="submit" class="rounded-md bg-indigo-600 px-3 py-2
                                   text-sm font-semibold text-white shadow-sm hover:bg-indigo-500
                                   focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                                   focus-visible:outline-indigo-600">
        Submit
      </button>
    </div>
  </div>
</template>

<style scoped>

</style>