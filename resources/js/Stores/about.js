import { defineStore } from 'pinia'

export const useAbout = defineStore('About',()=>{

const AboutList = ref(
  {
    paragraph: {},
    image:""
  }
)

return{ AboutList }

})
