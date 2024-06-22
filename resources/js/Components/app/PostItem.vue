<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { PencilIcon,TrashIcon , EllipsisVerticalIcon ,HandThumbUpIcon,ChatBubbleBottomCenterTextIcon,DocumentTextIcon,
         ArrowDownTrayIcon } from '@heroicons/vue/20/solid'


import UserIPostHeader from "@/Components/app/UserIPostHeader.vue";
import {router} from "@inertiajs/vue3";
import {isImage} from '@/healpers.js'

const emit = defineEmits(['editClick','attachmentClick'])
const props=defineProps({
  post:Object
})


function  openEditModel(){
  emit('editClick',props.post)
}
function  deletePost(){
  if(window.confirm("Are you sure you want to delete this post ?")){
    router.delete(route('post.destroy',props.post),{
      preserveScroll : true,
    })
  }
}

function openAttachment(ind){
  emit("attachmentClick",props.post, ind )
}
</script>

<template>

  <div class="bg-white border rounded-[10px] p-4 shadow mb-4" >
<!--    //header section-->
    <div class="flex items-center justify-between mb-3" >
      <UserIPostHeader :post="post"/>
      <div class="justify-self-end">
            <Menu as="div" class="relative inline-block text-left">
              <div>
                <MenuButton
                    class="w-8 h-8 rounded-full hover:bg-black/5 transition flex items-center justify-center"
                >

                  <EllipsisVerticalIcon
                      class="w-5 h-5"
                      aria-hidden="true"
                  />
                </MenuButton>
              </div>

              <transition
                  enter-active-class="transition duration-100 ease-out"
                  enter-from-class="transform scale-95 opacity-0"
                  enter-to-class="transform scale-100 opacity-100"
                  leave-active-class="transition duration-75 ease-in"
                  leave-from-class="transform scale-100 opacity-100"
                  leave-to-class="transform scale-95 opacity-0"
              >
                <MenuItems
                    class="absolute z-20 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md
                    bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                >
<!--                  edit menu option-->
                  <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                      <button
                          @click="openEditModel"
                          :class="[
                  active ? 'bg-indigo-500 text-white' : 'text-gray-900',
                  'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                ]"
                      >
                        <PencilIcon

                            :active="active"
                            class="mr-2 h-5 w-5 "
                            aria-hidden="true"
                        />
                        Edit
                      </button>

                    </MenuItem>
                  </div>
<!--                  delete menu option-->
                  <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                      <button
                          @click="deletePost"
                          :class="[
                  active ? 'bg-indigo-500 text-white' : 'text-gray-900',
                  'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                ]"
                      >
                        <TrashIcon

                            :active="active"
                            class="mr-2 h-5 w-5 "
                            aria-hidden="true"
                        />
                        Delete
                      </button>
                    </MenuItem>
                  </div>
                </MenuItems>
              </transition>
            </Menu>
      </div>
    </div>
<!--    body section-->
    <div class="mb-3">
      <Disclosure v-slot="{ open }">
        <div class="ck-content-output"   v-if="!open" v-html="post.body.substring(0,200)"/>
        <template   v-if="post.body.length > 200">
          <DisclosurePanel>
            <div class="ck-content-output" v-html="post.body"/>
          </DisclosurePanel>
          <div class="flex justify-end">
            <DisclosureButton class="text-blue-500 hover:underline">
              {{open ?'Read less':'Read More'}}
            </DisclosureButton>
          </div>
        </template>
      </Disclosure>
    </div>
<!--    attachment section-->
    <div class="grid  gap-3 mb-4" :class="[
        post.attachement.length===1 ? 'grid-cols-1' : 'grid-cols-2'
    ]" >

      <template v-for="(attachement,ind) of post.attachement.slice(0,4)">
        <div  @click="openAttachment(ind)"
            class=" group aspect-square bg-blue-100 flex flex-col items-center justify-center
            text-gray-500 relative cursor-pointer">
          <div class="absolute left-0 top-0 right-0 bottom-0 z-10 bg-black/60 text-white
                                    flex items-center justify-center text-2xl"
               v-if="ind === 3 && post.attachement.length > 4">
            +{{post.attachement.length - ind}}more

          </div>
          <!--  download button-->
          <a :href="route('post.download',attachement)"
             class=" z-10 opacity-0 group-hover:opacity-100 transition-all w-8 h-8 flex items-center justify-center text-gray-100
                        bg-gray-600 rounded absolute right-1 top-2  hover:bg-gray-800"
             @click.stop
          >
            <arrow-down-tray-icon  class="w-4 h-4 "/>
          </a>
        <!--  /download button/ -->
          <img  v-if="isImage(attachement)"
                :src="attachement.url"
                class="object-contain aspect-square"
           alt=""/>
          <div v-else class="flex flex-col justify-center items-center">
           <DocumentTextIcon  class="w-12 h-12 "/>
            <small>{{attachement.name}}</small>
          </div>
        </div>
      </template>
    </div>

<!--    reaction section-->
    <div class="flex gap-2">
      <button class=" flex gap-1 py-2 px-4 justify-center  bg-gray-100 hover:bg-gray-200 items-center flex-1   rounded-lg ">
        <HandThumbUpIcon class="w-6 h-6  hover:bg-gray-300"/>

        Like
      </button>
      <button class=" flex gap-1 py-2 px-4 justify-center bg-gray-100 hover:bg-gray-200 items-center flex-1   rounded-lg">
        <ChatBubbleBottomCenterTextIcon class="w-6 h-6  hover:bg-gray-300"/>
        comment
      </button>
    </div>
  </div>

</template>

<style scoped>

</style>