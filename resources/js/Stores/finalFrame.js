import { defineStore } from 'pinia'
import { ref } from 'vue';

export const useFinalFrameStore = defineStore('finalFrame',()=>{

  const finalFrameList = ref(
    {
      message1: "",
      message2: "", 
      image: ""
    }
  )

  return { finalFrameList }
})
