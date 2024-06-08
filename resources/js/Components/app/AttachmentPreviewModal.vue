<script setup>

import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'

import {computed} from "vue";


import { XMarkIcon,ChevronRightIcon,ChevronLeftIcon} from '@heroicons/vue/24/solid'
import {isImage} from "@/healpers.js";
import {DocumentTextIcon} from "@heroicons/vue/20/solid/index.js";




const emit = defineEmits(['update:modelValue','update:index','hide'])



const props = defineProps({
  attachment:{
    type:Array,
    required:true
  },
  index :Number,
  modelValue : Boolean
})

const show = computed({
  get :()=>props.modelValue,
  set:(value)=> emit('update:modelValue',value)
})

const currentIndex = computed({
  get :()=>props.index,
  set:(value)=> emit('update:index',value)
})

const attachement=computed(()=>{
  return props.attachment[currentIndex.value]
})

function closeModal() {
  show.value = false
  emit('hide')

}

function prev(){
  if(currentIndex.value === 0) return
    currentIndex.value --;
}
function  next(){
  if(currentIndex.value === props.attachment.length-1) return
  currentIndex.value ++;
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
              class="h-screen w-screen"
          >
            <TransitionChild
                as="template"
                class="w-full h-full"
                enter="duration-300 ease-out"
                enter-from="opacity-0 scale-95"
                enter-to="opacity-100 scale-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100 scale-100"
                leave-to="opacity-0 scale-95"
            >
              <DialogPanel
                  class="flex flex-col w-full transform overflow-hidden
                   bg-slate-800 text-left align-middle shadow-xl transition-all select-none"
              >
                <button @click="closeModal"
                        class="absolute right-3 top-3 z-20  w-8 h-8 rounded-full
                  hover:bg-black/5 transition flex items-center justify-center">
                  <XMarkIcon class="w-8 h-8 text-gray-100"/>
                </button>
                <div class=" relative group  h-full bg-slate-800 ">

                  <div @click="prev"
                       class="absolute opacity-0 group-hover:opacity-100 text-gray-100
                              cursor-pointer flex items-center w-16 h-full left-0 ">
                    <ChevronLeftIcon class="w-16"/>
                  </div>
                  <div @click="next"
                       class="absolute opacity-0 group-hover:opacity-100 text-gray-100
                              cursor-pointer flex items-center w-16 h-full right-0 ">
                    <ChevronRightIcon class="w-16"/>
                  </div>
                  <div class="w-full h-full p-3
                                flex items-center justify-center ">
                    <img  v-if="isImage(attachement)"
                          :src="attachement.url"
                          class="max-w-full max-h-full"
                          alt=""/>
                    <div v-else class="p-32 flex flex-col justify-center items-center">
                      <DocumentTextIcon  class="w-25 h-35 text-gray-100 "/>
                      <small class="text-gray-100">{{attachement.name}}</small>
                    </div>
                  </div>
                </div>

              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </teleport>

</template>

