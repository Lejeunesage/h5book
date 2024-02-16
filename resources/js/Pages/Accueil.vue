<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Icon from '@/Components/Icons/Icon.vue'
import { Head } from '@inertiajs/vue3';

import { ref } from 'vue';

// State
const isDropdownOpen = ref(false);

// Dropdown options
const dropdownOptions = ref(['Option 1', 'Option 2', 'Option 3']);

// Methods
const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const selectOption = (option) => {
    // Handle option selection logic here
    console.log(`Selected: ${option}`);
    isDropdownOpen.value = false; // Close the dropdown after selection
};
</script>

<template>
    <Head title="Accueil" />

    <AuthenticatedLayout>
        <!-- Status -->
        <section class="flex gap-3 mt-[-10px] bg-white  overflow-hidden">
            <div class="p-2 border-2 rouded-md border-blue-200 w-40 h-44 rounded-md shadow-md  justify-center items-center">
                <div
                    class="p-4 border-b bg-[#0c7fb9] rounded-md shadow-md flex flex-col justify-center items-center h-full gap-3">
                    <span class="w-12 h-12 rounded-full flex items-center justify-center bg-white opacity-50">
                        <Icon name="plus" />
                    </span>
                    <p class="text-sm text-white">Ajouter</p>
                </div>
            </div>

            <div class="p-2 borde bg-orange-400  w-40 h-44 rounded-md shadow-md  justify-center items-center relative">
                <span>
                    <Icon name="sun" />
                </span>
                <div class="absolute bottom-2">
                    <p class="text-sm text-white">Josephile Water</p>
                    <p class="text-sm text-white">Actif</p>
                </div>
            </div>

            <div class="p-2 borde bg-red-400  w-40 h-44 rounded-md shadow-md  justify-center items-center relative">
                <div class="absolute bottom-2">
                    <p class="text-sm text-white">Josephile Water</p>
                    <p class="text-sm text-white">Actif</p>
                </div>
            </div>

        </section>

        <!-- Creation de post -->
        <section class="bg-white mt-2 mb-3">

            <div class="w-full p-4 flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <div class="aspect-square rounded-full">
                        <img class="rounded-full aspect-square w-[35px]" :src="imageProfil !== null
                            ? `/storage/profilImage/${imageProfil}`
                            : `/storage/images/account.png`
                            " alt="" />
                    </div>
                    <h3 class="text-[12px] font-extrabold text-gray-600 py-1.5 px-2 rounded-full border basis-[85%] bg-gray-100"
                        @click="showModalPublication">
                        A quoi vous pensez ?
                    </h3>

                </div>

                <div id="divPost"
                    class="hidden z-40 bg-white top-[62px] fixed bottom-0 left-0 right-0 rounded-l-lg rounded-r-lg">
                    <div class="relative text-gray-600 text-sm font-bold py-3 border-gray-300 border-b-[1px] mb-2">
                        <div class="mx-auto w-[90%] flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="cursor-pointer border-gray-300 border-[1px] bg-gray-300 rounded p-1"
                                    @click="closeModalPublication">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 19.5 8.25 12l7.5-7.5" />
                                    </svg>
                                </span>
                                <h4 class="text-[13px]">Créer un post</h4>
                            </div>
                            <button class="text-sky-500 font-bold text-[13px]" id="button-3"
                                @click="publishPost('button-3')">
                                Publier
                            </button>
                        </div>
                    </div>

                    <div class="mx-auto w-[95%] overflow-y-auto h-[600px]">
                        <div class="w-full p-1 relative">
                            <template v-if="selectedColorIndex !== null">
                                <div class="h-64 flex items-center p-5" :class="`${colorArray[selectedColorIndex]}`">
                                    <ul class='absolute right-2 top-2'>
                                        <li @click="closeTextarea"
                                            class="cursor-pointer flex item-center justify-center bg-white border shadow rounded-full w-[23px] aspect-radio">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                                            </svg>
                                        </li>
                                    </ul>
                                    <textarea
                                        class="min-w-full text-white overflow-hidden focus:ring focus:ring-transparent cursor:text border-none outline-none rounded-md text-center bg-transparent resize-none placeholder:text-white placeholder:text-[13px] text-[13px] placeholder:font-bold"
                                        placeholder="Ecrivez quelque chose..." v-model="publish"></textarea>
                                </div>
                            </template>
                            <template v-else>
                                <textarea rows="4"
                                    class="rounded min-w-full resize-none focus:ring focus:ring-transparent border-none bg-gray-200 placeholder:font-bold placeholder:text-[13px] text-[13px]"
                                    placeholder="Ecrivez quelque chose..." v-model="publish"></textarea>
                            </template>
                        </div>

                        <div class="flex items-center gap-1 justify-between px-2" v-if="imageInput === false">
                            <ul class="flex flex-wrap gap-1">
                                <li v-for="(color, index) in colorArray" :key="index"
                                    class="aspect-square rounded-full w-[20px]" :class="`${color}`" :id="'li-' + index"
                                    @click="openTextarea(index)"></li>
                            </ul>
                        </div>

                        <div class="mt-2">
                            <form>
                                <label for="photos" class="cursor-pointer text-[13px] font-bold">Photos/Vidéos</label>
                                <input type="file" class="hidden" id="photos" @change="imageIn()" />
                            </form>
                        </div>

                        <div id="loader" class="hidden flex justify-center"><span class="loader"></span></div>

                        <div class="relative" v-if="nameImg">
                            <div v-if="nameImg !== null && valeur === 'image'" class="mt-2">
                                <img :src="`/storage/post_images_videos/${nameImg}`"
                                    class="object-cover h-[400px] w-full rounded-lg" alt="image_post" />
                            </div>
                            <div v-if="nameImg !== null && valeur === 'video'" class="mt-2">
                                <video preload="auto" controls autoplay :src="`/storage/post_images_videos/${nameImg}`"
                                    class="object-cover h-[400px] w-full rounded-lg" alt="video_post"></video>
                            </div>
                            <span
                                class="cursor-pointer absolute top-[5px] right-[5px] border-gray-300 border-[1px] bg-gray-300 rounded-full p-1"
                                @click="closeVisual">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="black" class="w-3 h-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </span>
                        </div>

                        <p id="paragraph" class="my-2 hidden bg-red-200 text-red-600 font-bold p-1 rounded"></p>

                        <button class="mt-4 w-full bg-[#0c7fb9] text-white text-center text-[13px] p-2 rounded-lg"
                            id="button-1" type="button" @click="publishPost('button-1')">
                            PUBLIER
                        </button>
                    </div>
                </div>
            </div>
        </section>

    </AuthenticatedLayout>
</template>

<style>
.loader {
    width: 30px;
    height: 30px;
    border: 5px dotted rgb(129, 33, 33);
    border-radius: 50%;
    display: inline-block;
    position: relative;
    box-sizing: border-box;
    animation: rotation 2s linear infinite;
}

@keyframes rotation {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>

<script>
export default {
    data() {
        return {
            varBool1: false,
            textTextareColor: [ // Tableau contenant les couleur de text dans le textarea
                "text-black",
                "text-white",
                "text-gray-400",
                "text-gray-800",
                "text-red-400",
                "text-red-900",
                "text-lime-50"
            ],
            colorArray: [
                "bg-gradient-to-r from-cyan-500 to-blue-500",
                "bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500",
                "bg-gradient-to-r from-gray-700 to-lime-700",
                "bg-gradient-to-t from-gray-700 to-lime-700",
                "bg-gradient-to-t from-gray-700 to-rose-400",
                "bg-gradient-to-t from-gray-700 to-rose-700",
                "bg-gradient-to-br from-gray-700 to-pink-400",
                "bg-gradient-to-br from-gray-700 to-slate-400",
                "bg-gradient-to-br from-gray-700 to-sky-800",
                "bg-gradient-to-br from-gray-700 to-sky-400",
                "bg-gradient-to-br from-gray-700 to-fuchsia-400",
                "bg-gradient-to-br from-gray-700 to-rose-200",
            ], // TAbleau de couleur
            selectedColorIndex: null, // Indice de l'élément li affichant le tableau de couleur sélectionner

            publish: "",
            imageInput: false,
            nameImg: null,
            valeur: null,

        }
    },

watch: {
  publish(newValue, oldValue) { 
    if(newValue !== null)
    {
      if(newValue.trim().split(/\s+/).length >= 30)
      {
        this.selectedColorIndex = null;
        this.imageInput = true;
      } else if(this.nameImg !== null || photos.value !== '')
      {
        this.imageInput = true;
        this.selectedColorIndex = null;
      }
       else {
        this.imageInput = false;
      }
    }
  }
},

    methods: {
        imageIn() {
      this.imageInput = true;
      let myDataFile = photos.files[0];
      let formData = new FormData();
        this.selectedColorIndex = null;
      loader.classList.remove("hidden");
      formData.append("myCover", myDataFile);
      axios
        .post(route("post.storeImgDeo"), formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          loader.classList.add("hidden");
          if (!response.data.error) {
            this.nameImg = response.data.nameImg;
            this.valeur = response.data.valeur;
            paragraph.classList.add("hidden");
            paragraph.innerHTML = "";
          } else {
            photos.value = "";
            paragraph.classList.remove("hidden");
            paragraph.innerHTML = response.data.error;
          }
        });
    },

    closeVisual() {
      axios
        .delete(
          route("post.deleteImgDeo", {
            nameImg: this.nameImg,
          })
        )
        .then((response) => {
          this.imageInput = !this.imageInput;
          this.nameImg = null;
          photos.value = "";
        });
    },

    // By KolaDev
    publishPost(element, identifiant = null) {
      if (photos.value === "") {
        if (this.publish.trim() !== "") {
          document.getElementById(`${element}`).setAttribute("disabled", "");
          axios
            .post(route("createPost"), {
              tag: identifiant,
              publish: this.publish,
              bgc: this.colorArray[this.selectedColorIndex],
            })
            .then((response) => {
              if (response.data.message) {
                paragraph.classList.add("hidden");
                paragraph.innerHTML = "";
                window.location.href = window.location.href;
              } else {
                document.getElementById(`${element}`).removeAttribute("disabled");
                paragraph.classList.remove("hidden");
                paragraph.innerHTML = "Une erreur est survenue !!!";
              }
            });
        }
      } else {
        if (this.nameImg !== null) {
          document.getElementById(`${element}`).setAttribute("disabled", "");
          axios
            .post(route("createPostTwo"), {
              tag: identifiant,
              publish: this.publish,
              fichier: this.nameImg,
              value: this.valeur,
            })
            .then((response) => {
              if (response.data.message) {
                paragraph.classList.add("hidden");
                paragraph.innerHTML = "";
                window.location.href = window.location.href;
              } else {
                document.getElementById(`${element}`).removeAttribute("disabled");
                paragraph.classList.remove("hidden");
                paragraph.innerHTML = "Une erreur est survenue !!!";
              }
            });
        }
      }
    },

// By KolaDev
// Fonction pour cacher le modal de création de post
closeModalPublication() {
  this.publish = null;
  photos.value = "";
  this.imageInput = false;
  this.selectedColorIndex = null;
  divPost.classList.add("hidden");
  if(this.nameImg !== null)
  {
    axios
      .delete(
        route("post.deleteImgDeo", {
          nameImg: this.nameImg,
        })
      )
      .then((response) => {
        this.nameImg = null;
      });
  }
},

    // By KolaDev
    // Fonction pour afficher le modal de création de post
    showModalPublication() {
      divPost.classList.remove("hidden");
    },

    // By KolaDev
    viewPostProfil(user_id, id) {
      window.location.href = `/postProfil/${user_id}/${id}`;
    },

    /**
     * Permet d'ouvrir un
     * textarea sur commande pour créer
     * un post en attribuant une valer à la
     * variable selectedColorIndex
     *
     * @param {*} _index
     */
    openTextarea(_index) {
      this.selectedColorIndex = _index; // Met à jour l'indice de l'élément li sélectionné
    },

    /**
     * Permet de cacher le textarea
     * afficher sur demande
     * en attribuant à nouveau la valeur
     * null à notre variable selectedColorIndex
     */
    closeTextarea() {
      this.selectedColorIndex = null;
    },

        action() {
            this.varBool1 = !this.varBool1;
        }
    }
}

</script>

<style scope>
.v-enter-active {
    transition: all 0.8s;
}

.v-leave-active {
    transition: all 0.5s;
}

.v-enter-from {
    opacity: 0;
    transform: translateY(-20px);
}

.v-enter-to {
    opacity: 1;
    transform: translateY(0px);
}

.v-leave-from {
    transform: translateY(0px);
}

.v-leave-to {
    transform: translateY(-10px);
    opacity: 0;
}
</style>
