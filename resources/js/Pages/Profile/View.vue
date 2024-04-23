<script setup>
import {computed, ref} from 'vue'
import {Tab, TabGroup, TabList, TabPanel, TabPanels} from '@headlessui/vue'
import {usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabItem from "@/Pages/Profile/Partials/TabItem.vue";
import Edit from "@/Pages/Profile/Edit.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {CameraIcon , XMarkIcon, PencilSquareIcon ,ArrowUpTrayIcon} from '@heroicons/vue/24/solid'
import { useForm } from '@inertiajs/vue3'

const imageForm = useForm({
  cover: null,
  avatar: null,
})

const  showNotification =ref('true')
const  coverImageSrc = ref('')
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
  user:{
    type:Object
  }
});

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
  imageForm.post(route('profile.updateCover'),{
    onSuccess:(user)=>{
      CancelCoverImage()
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
          v-show="showNotification && status === 'cover image updated'"
          class="my-2  py-2 px-3 font-medium text-sm bg-emerald-600 text-white">
        Cover Image Updated Successfully !!
      </div>
<!--      error message-->
      <div
          v-if="errors.cover"
          class="my-2  py-2 px-3 font-medium text-sm bg-red-400 text-white"
      >
        {{errors.cover}}
      </div>
      <!--    cover image-->
      <div class="group relative bg-white">

        <img :src=" coverImageSrc ||user.cover_url|| '/img/default_cover_image.jpg'"
             class="w-full  h-[200px] object-cover"  alt=""/>
        <div class="absolute top-2 right-2">
          <!-- upload image button-->
          <button class="flex bg-gray-50 hover:bg-gray-200  text-gray-800 px-2 py-1
                      text-xs items-center opacity-0 group-hover:opacity-100 cursor-pointer rounded"
                    v-if="!coverImageSrc">

            <camera-icon  fill="none" class="w-4 h-4 mr-2"/>
            upload cover image
            <input type="file"
                   class="absolute left-0 top-0 right-0 opacity-0"
                   @change="onCoverChange"/>
          </button>
          <div v-else class="flex gap-2 opacity-0 group-hover:opacity-100">
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
          <img src="https://cdn.iconscout.com/icon/free/png-256/free-avatar-370-456322.png?f=webp"
               class=" ml-[48px] w-[128px] h-[128px] -mt-[64px]"/>
          <div class="flex justify-between items-center flex-1 p-4">
            <h2 class="font-bold text-lg ">{{user.name}}</h2>
            <PrimaryButton v-if="isMyProfile">
             <PencilSquareIcon class="w-4 h-4"/>
            </PrimaryButton>
          </div>
        </div>
      </div>
      <div class="border-t-2">
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


