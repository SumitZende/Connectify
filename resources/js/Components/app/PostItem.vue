<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { PencilIcon,TrashIcon , EllipsisVerticalIcon} from '@heroicons/vue/20/solid'

import {ref} from "vue";
import UserIPostHeader from "@/Components/app/UserIPostHeader.vue";
import {router} from "@inertiajs/vue3";


const emit = defineEmits(['editClick'])
const props=defineProps({
  post:Object
})
function isImage(attachement){
  const  mime=attachement.mime.split('/')
  return mime[0].toLowerCase()==='image'
}

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
                    class="absolute right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md
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
        <div  v-if="!open || post.body.length <= 200 " v-html="post.body.substring(0,200)"/>
        <template v-if="post.body.length > 200">
          <DisclosurePanel>
            <div v-html="post.body"/>
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
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 mb-4">
      <template v-for="attachement of post.attachement">
        <div
            class=" group aspect-square bg-blue-100 flex flex-col items-center justify-center text-gray-500 relative ">
          <!--download button-->
          <button class=" opacity-0 group-hover:opacity-100 transition-all w-8 h-8 flex items-center justify-center text-gray-100
                        bg-gray-600 rounded absolute right-1 top-2 cursor-pointer hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor"
                 class="w-4 h-4 ">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
          </button>
        <!-- /download button/-->
          <img  v-if="isImage(attachement)"
                :src="attachement.url"
                class="object-cover aspect-square"
           alt=""/>
          <template v-else>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="w-6 h-6">
              <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"
                    class="w-12 h-12 "
              />
            </svg>
          <small>{{attachement.name}}</small>

          </template>

        </div>
      </template>
    </div>

<!--    reaction section-->
    <div class="flex gap-2">
      <button class=" flex gap-1 py-2 px-4 justify-center  bg-gray-100 hover:bg-gray-200 items-center flex-1   rounded-lg ">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6  hover:bg-gray-300">
          <path d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
        </svg>

        Like
      </button>
      <button class=" flex gap-1 py-2 px-4 justify-center bg-gray-100 hover:bg-gray-200 items-center flex-1   rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6  hover:bg-gray-300">
          <path fill-rule="evenodd" d="M12 2.25c-2.429 0-4.817.178-7.152.521C2.87 3.061 1.5 4.795 1.5 6.741v6.018c0 1.946 1.37 3.68 3.348 3.97.877.129 1.761.234 2.652.316V21a.75.75 0 0 0 1.28.53l4.184-4.183a.39.39 0 0 1 .266-.112c2.006-.05 3.982-.22 5.922-.506 1.978-.29 3.348-2.023 3.348-3.97V6.741c0-1.947-1.37-3.68-3.348-3.97A49.145 49.145 0 0 0 12 2.25ZM8.25 8.625a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Zm2.625 1.125a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm4.875-1.125a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z" clip-rule="evenodd" />
        </svg>
        comment
      </button>
    </div>
  </div>

</template>

<style scoped>

</style>