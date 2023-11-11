import { defineStore } from 'pinia'
import { ref } from 'vue';

export const useHeroStore = defineStore('Hero',()=>{

const HeroList = ref(
  {
    message1: "",
    message2: "", 
    message3: "", 
    message4: "",
    image: ""
  }
)

return { HeroList }

})