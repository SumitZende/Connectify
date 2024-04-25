<script setup>
import {computed, ref} from 'vue'
import {Tab, TabGroup, TabList, TabPanel, TabPanels} from '@headlessui/vue'
import {usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabItem from "@/Pages/Profile/Partials/TabItem.vue";
import Edit from "@/Pages/Profile/Edit.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {CameraIcon , XMarkIcon, PencilSquareIcon ,ArrowUpTrayIcon,CheckCircleIcon} from '@heroicons/vue/24/solid'
import { useForm } from '@inertiajs/vue3'

const imageForm = useForm({
  cover: null,
  avatar: null,
})

const  showNotification =ref('true')
const  coverImageSrc = ref('')
const  avatarImageSrc = ref('')
const  isMyProfile = computed(()=>authUser && authUser.id === props.user.id);
const authUser = usePage().props.auth.user;
const  props= defineProps({
  errors: Object,
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
  success: {
    type: String,
  },
  user:{
    type:Object
  }
});
//cover-image action
function onCoverChange(event){
  imageForm.cover = event.target.files[0]
  if(imageForm.cover){
    const reader = new FileReader()
    reader.onload=()=>{

      coverImageSrc.value = reader.result;
    }
    reader.readAsDataURL(imageForm.cover)
  }
}
function CancelCoverImage(){
  imageForm.cover = null;
  coverImageSrc.value = null;
}
function  SubmitCoverImage(){
  imageForm.post(route('profile.updateImages'),{
    onSuccess:(user)=>{
      CancelCoverImage()
      setTimeout(()=>{
        showNotification.value = false
      },3000)
    },
  })
}

//avatar action
function onAvatarChange(event){
  imageForm.avatar = event.target.files[0]
  if(imageForm.avatar){
    const reader = new FileReader()
    reader.onload=()=>{

      avatarImageSrc.value = reader.result;
    }
    reader.readAsDataURL(imageForm.avatar)
  }
}
function CancelAvatarImage(){
  imageForm.avatar = null;
  avatarImageSrc.value = null;
}
function  SubmitAvatarImage(){
  imageForm.post(route('profile.updateImages'),{
    onSuccess:(user)=>{
      CancelAvatarImage()
      setTimeout(()=>{
        showNotification.value = false
      },3000)
    },
  })
}
</script>
<template>
  <AuthenticatedLayout>
    <div class="max-w-[768px] mx-auto  h-full overflow-auto ">
<!--      success message-->
      <div
          v-show="showNotification && success "
          class="my-2  py-2 px-3 font-medium text-sm bg-emerald-600 text-white">
          {{success}}
      </div>
<!--      error message-->
      <div
          v-if="errors.cover"
          class="my-2  py-2 px-3 font-medium text-sm bg-red-400 text-white"
      >
        {{errors.cover}}
      </div>
      <!--    cover image-->
      <div class="group/cover relative bg-white">
        <img :src=" coverImageSrc ||user.cover_url|| '/img/default_cover_image.jpg'"
             class="w-full  h-[200px] object-cover"  alt=""/>
        <div class="absolute top-2 right-2">
          <!-- upload image button-->
          <button class="flex bg-gray-50 hover:bg-gray-200  text-gray-800 px-2 py-1
                      text-xs items-center opacity-0 group-hover/cover:opacity-100 cursor-pointer rounded"
                    v-if="!coverImageSrc">

            <camera-icon  fill="none" class="w-4 h-4 mr-2"/>
            upload cover image
            <input type="file"
                   class="absolute left-0 top-0 right-0 opacity-0 cursor-pointer"
                   @change="onCoverChange"/>
          </button>
          <div v-else class="flex gap-2 opacity-0 group-hover/cover:opacity-100">
            <!--          cancel-image-->
            <button class=" flex  bg-gray-50 hover:bg-gray-200  text-gray-800 px-2 py-1
                      text-xs items-center  cursor-pointer rounded"
                    @click="CancelCoverImage">
              <XMarkIcon fill="none" class="w-4 h-4 mr-2"/>
              cancel
            </button>
<!--            submit button-->
            <button class="flex bg-gray-800 hover:bg-gray-900  text-gray-100 px-2 py-1
                          text-xs items-center cursor-pointer rounded"
                    @click="SubmitCoverImage">
              <ArrowUpTrayIcon  fill="none" class="w-4 h-4 mr-2"/>
              submit

            </button>
          </div>
        </div>

        <!--      Avatar image-->
        <div class="flex">
          <div class="relative group/avatar
                      flex justify-center items-center
                      -mt-[64px] ml-[48px]  w-[128px] h-[128px]
                       rounded-full ">
            <img :src=" avatarImageSrc || user.avatar_url || '/img/default_avatar.webp'"
                 class="w-full h-full object-cover rounded-full" alt=""/>
              <!-- upload image button-->
              <button class="absolute top-0 left-0 bottom-0 right-0
                              flex justify-center items-center
                              bg-black/50  text-gray-300 rounded-full
                              opacity-0 group-hover/avatar:opacity-100 "
                      v-if="!avatarImageSrc">

                <camera-icon  fill="none" class="w-8 h-8"/>
                <input type="file"
                       class="absolute top-0 left-0 bottom-0 right-0
                              flex justify-center items-center
                             rounded-full opacity-0 cursor-pointer"
                       @change="onAvatarChange"/>
              </button>
              <div v-else class="absolute top-1 right-0 flex gap-2 flex-col">
                <!--          cancel-image-->
                <button class="w-7 h-7 flex items-center justify-center bg-red-500/80
                                text-white rounded-full"
                        @click="CancelAvatarImage">
                  <XMarkIcon fill="none" class="w-5 h-5 "/>

                </button>
                <!--            submit button-->
                <button class="w-7 h-7 flex items-center justify-center bg-emerald-500/80
                                text-white rounded-full"
                        @click="SubmitAvatarImage">
                  <CheckCircleIcon  fill="none" class="w-6 h-6 "/>


                </button>
              </div>
          </div>
          <div class="flex justify-between items-center flex-1 p-4">
            <h2 class="font-bold text-lg ">{{user.name}}</h2>
            <PrimaryButton v-if="isMyProfile">
             <PencilSquareIcon class="w-4 h-4"/>
            </PrimaryButton>
          </div>
        </div>
      </div>
      <div class="border-t-2">
<!--      tab option-->
        <div>
          <TabGroup>
            <TabList class=" flex bg-white">
              <Tab  v-if="isMyProfile" v-slot="{ selected }" as="template" >
                <TabItem text="About"  :selected="selected"/>
              </Tab>
              <Tab v-slot="{ selected }" as="template" >
                <TabItem text="Posts"  :selected="selected"/>
              </Tab>
              <Tab v-slot="{ selected }" as="template" >
                <TabItem text="Followers"  :selected="selected"/>
              </Tab>
              <Tab v-slot="{ selected }" as="template" >
                <TabItem text="Following"  :selected="selected"/>
              </Tab>
              <Tab v-slot="{ selected }" as="template" >
                <TabItem text="Photos"  :selected="selected"/>
              </Tab>
            </TabList>
<!--            tab-content-->
            <TabPanels class="mt-2">
              <TabPanel  v-if="isMyProfile" >
                <Edit  :must-verify-email="mustVerifyEmail" :status="status"/>
              </TabPanel>
              <TabPanel  class="bg-white p-3 shadow">
                Post Content
              </TabPanel>
              <TabPanel  class="bg-white p-3 shadow">
                Followers
              </TabPanel>
              <TabPanel  class="bg-white p-3 shadow">
                Following
              </TabPanel>
              <TabPanel  class="bg-white p-3 shadow">
                Photos
              </TabPanel>
            </TabPanels>
          </TabGroup>
        </div>
      </div>

    </div>
  </AuthenticatedLayout>
</template>


