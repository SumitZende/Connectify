<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: false,

});

const  emits= defineEmits(['update:modelValue']);
const props= defineProps({
  placeholder:String,
  autoResize:{
    type  :Boolean,
    default :true
  }
})

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
    adjustHeight()
});


defineExpose({ focus: () => input.value.focus() });

function onInputChange($event){
  emits('update:modelValue', $event.target.value)
  adjustHeight()
}

function adjustHeight(){
  if(props.autoResize){
    input.value.style.height = 'auto';
    input.value.style.height = input.value.scrollHeight + 'px';
  }
}
</script>

<template>
    <textarea
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        v-model="model"
        @input="onInputChange"
        ref="input"
        :placeholder="placeholder"
    ></textarea>
</template>
