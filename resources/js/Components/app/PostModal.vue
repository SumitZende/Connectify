<script setup>

import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'

import {computed, ref, watch} from "vue";

import UserIPostHeader from "@/Components/app/UserIPostHeader.vue";
import { XMarkIcon,PaperClipIcon, BookmarkIcon, DocumentIcon,ArrowUturnLeftIcon} from '@heroicons/vue/24/solid'
import {useForm} from "@inertiajs/vue3";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import {isImage} from "@/healpers.js";


/**

 * {
 *  file:File,
 *  url:'',
 * }
 * @type {Ref<UnwrapRef<*[]>>}
 */
const attachmentFiles =ref([])
const emit = defineEmits(['update:modelValue','hide'])

const editor= ClassicEditor;
const editorConfig ={
  toolbar:[ 'heading', '|','bold', 'italic', 'link', '|','bulletedList', 'numberedList',
    'blockQuote', '|','indent', 'outdent'],

}

const props = defineProps({
  post:{
    type:Object,
    required:true
  },
  modelValue : Boolean
})

const form =useForm({

  body :'',
  attachments:[],
  deleted_file_ids:[],
  _method:'POST'
})

watch(()=> props.post, ()=>{
  console.log('this is triggered')
    form.body = props.post.body || ''
})

const show = computed({
  get :()=>props.modelValue,
  set:(value)=> emit('update:modelValue',value)
})

const computedAttachments = computed(()=>{
  return [...attachmentFiles.value,...(props.post.attachement || [])]
})

function closeModal() {
  show.value = false
  emit('hide')
  resetModal()
}
function  resetModal(){
  form.reset()
  attachmentFiles.value=[]
  props.post.attachement.forEach(file=>file.deleted=false)
}
function submit(){
  form.attachments = attachmentFiles.value.map(myFile => myFile.file)
  if(props.post.id){
    form._method = 'PUT'
    form.post(route('post.update',props.post.id),{
      preserveScroll : true,
      onSuccess:()=>{
        closeModal()
      }
    })
  }
  else{
    form.post(route('post.create'),{
      preserveScroll : true,
      onSuccess:()=>{
        closeModal()
      }
    })
  }

}
async function  onAttachmentChoose($event){
  console.log($event.target.files)
  for (const file of $event.target.files){
    const  myFile = {
      file,
      url:await readFile(file)
    }
    attachmentFiles.value.push(myFile)
  }
  $event.target.value = null;
  console.log(attachmentFiles.value)
}

async function readFile(file){
  return new Promise((res,rej)=>{
    if(isImage(file)){
      const reader = new FileReader();
      reader.onload=()=>{
        res(reader.result)
      }
      reader.onerror = rej
      reader.readAsDataURL(file)
    }else{
      res('null')
    }
  })
}
function  removeFile(myFile){
  if(myFile.file){
    attachmentFiles.value = attachmentFiles.value.filter(f => f !== myFile)
  }else{
    form.deleted_file_ids.push(myFile.id)
    myFile.deleted=true;
  }
}

function  undoDelete(myFile){
  myFile.deleted=false
  form.deleted_file_ids= form.deleted_file_ids.filter(id=>myFile.id !== id)
}
</script>

<template>
  <teleport to="body">
    <TransitionRoot appear :show="show" as="template">
      <Dialog as="div" @close="closeModal" class="relative z-10">
        <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100"
            leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-black/25" />
        </TransitionChild>

        <div class="fixed inset-0 overflow-y-auto">
          <div
              class="flex min-h-full items-center justify-center p-4 text-center"
          >
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0 scale-95"
                enter-to="opacity-100 scale-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100 scale-100"
                leave-to="opacity-0 scale-95"
            >
              <DialogPanel
                  class="w-full max-w-md transform overflow-hidden rounded bg-white text-left align-middle shadow-xl transition-all"
              >
                <DialogTitle
                    as="h3"
                    class="flex items-center justify-between py-3 px-4  font-medium bg-gray-200 leading-6 text-gray-900"
                >
                {{post.id ? 'Update Post' : 'Create Post '}}

                  <button class="w-8 h-8 rounded-full hover:bg-black/5 transition flex items-center justify-center">
                    <XMarkIcon class="w-4 h-4"
                                @click="closeModal"/>
                  </button>
                </DialogTitle>
                <div class="p-3 ">
                  <UserIPostHeader :post="post" :time="false" class="mb-4"/>
                  <ckeditor :editor="editor" v-model="form.body" :config="editorConfig"></ckeditor>


                  <div class="grid gap-3 my-5" :class="[
                      computedAttachments.length === 1 ? 'grid-cols-1' : 'grid-cols-2'
                  ]">

                    <template v-for="myFile of computedAttachments">
                      <div
                          class=" group aspect-square bg-blue-100 flex flex-col items-center justify-center text-gray-500 relative ">
                        <div v-if="myFile.deleted"
                             class="absolute left-0 bottom-0 right-0  z-10 py-2 px-3 text-sm bg-black text-white flex items-center justify-between cursor-pointer">
                          To be deleted
                          <ArrowUturnLeftIcon  @click="undoDelete(myFile)" class="h-4 w-4"/>
                        </div>
                        <button class=" absolute right-3 top-3 flex  items-center justify-center bg-black/20
                                        text-white  cursor-pointer rounded-full
                                         hover:bg-black/50 "
                                @click="removeFile(myFile)">
                          <XMarkIcon fill="none" class="w-5 h-5 "/>

                        </button>
                        <img  v-if="isImage(myFile.file || myFile)"
                              :src="myFile.url"
                              class="object-contain aspect-square"
                              alt=""
                              :class="myFile.deleted ? 'opacity-30': ''"/>
                        <div  v-else
                              class="flex flex-col justify-center items-center"
                              :class="myFile.deleted ? 'opacity-30': ''">
                          <document-icon class="w-12 h-12"/>
                          <small class="text-center">{{(myFile.file || myFile).name}}</small>
                        </div>
                      </div>
                    </template>
                  </div>

                </div>


                <div class=" flex gap-2 py-3 px-4 ">
                  <button
                      type="button"
                      class="flex items-center justify-center rounded-md bg-indigo-600 px-3 py-2
                      text-sm font-semibold text-white shadow-sm hover:bg-indigo-500
                      focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                      focus-visible:outline-indigo-600 w-full relative"
                     @click="submit">
                      <PaperClipIcon  class="w-4 h-4 mr-2"/>
                      Attach File
                      <input  @click.stop   @change="onAttachmentChoose" type="file" multiple class="top-0 right-0 bottom-0 left-0 absolute opacity-0 " >
                  </button>
                  <button
                      type="button"
                      class="flex items-center justify-center rounded-md bg-indigo-600 px-3 py-2
                      text-sm font-semibold text-white shadow-sm hover:bg-indigo-500
                      focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                      focus-visible:outline-indigo-600 w-full"
                                    @click="submit">
                  <bookmark-icon class="w-4 h-4 mr-2"/>
                   submit

                  </button>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </teleport>

</template>

