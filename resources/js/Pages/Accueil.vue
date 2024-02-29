<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Icon from '@/Components/Icons/Icon.vue'
import { Head, Link } from '@inertiajs/vue3';

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
    <section class="bg-white py-2 mt-[-10px] border-gray-300 border-b-[1px]">
      <div class="flex gap-3 overflow-x-auto whitespace-no-wrap w-[95%] m-auto">
        <div class="p-1 border-2 border-blue-200 flex-shrink-0 w-24 h-32 rounded-md shadow-md justify-center items-center"
          @click="openStatus">
          <div class="relative border-b rounded-md shadow-md flex flex-col justify-between items-center h-full gap-4">
            <img class="h-44 rounded aspect-square w-full object-cover" :src="img !== null
              ? `/storage/profilImage/${userInformation.file_profile}`
              : `/storage/images/account.png`
              " alt="image_de_l'utilisateur" />

            <div class="absolute top-16 bottom-0 flex flex-col items-center p-4 bg-[#0389c9] rounded-b">
              <span
                class="absolute top-[-18px] w-8 h-8 rounded-full flex items-center justify-center border-sky-600 border-2 bg-white opacity-90">
                <Icon name="plus" />
              </span>
              <p class="text-[9px] mt-[-5px] text-white text-center font-bold">Mettre à jour votre story</p>
            </div>
          </div>
        </div>
        <!-- <div class="p-2 border rounded bg-orange-400 flex-shrink-0 w-24 h-32 flex flex-col gap-y-1 shadow-md relative"
          v-for="(el, index) in 10">
          <span>
            <Icon name="sun" />
          </span>
          <div class="absolute bottom-2">
            <p class="text-[10px] text-white">Josephile Water</p>
            <p class="text-[10px] text-white">Actif</p>
          </div>
        </div> -->
        <div class="p-2 border rounded flex-shrink-0 w-24 h-32 flex flex-col gap-y-1 shadow-md relative"
          v-for="(el, i) in allStatus" @click="openViewStatut(i)">
          <span class="z-50 bg-gray-800 rounded-full w-5 h-5 flex justify-center items-center p-1">
            <Icon name="sun" />
          </span>
          <video v-if="el[0].video !== null" autoplay="false" controls :src="`/storage/statut/${el[0].video}`"
            class="h-32 absolute left-0 right-0 rounded top-0 bottom-0" alt="video_statut"></video>

          <p v-if="el[0].bgc" :class="el[0].bgc"
            class="absolute left-0 right-0 rounded top-0 bottom-0 object-cover h-32 flex justify-center items-center text-[9px] text-justify text-white p-1"
            v-html="el[0].body.split(' ').slice(0, 8).join(' ') + '...'"></p>

          <img v-if="el[0].image !== null" class="absolute left-0 right-0 rounded top-0 bottom-0 object-cover h-32"
            :src="`/storage/statut/${el[0].image}`" />
          <div class="absolute bottom-2">
            <p class="text-[9px] text-white" v-if="el[0].name.split(' ').length > 2">{{ el[0].name.split(' ').slice(0,
              2).join(' ') + '...' }}</p>
            <p class="text-[9px] text-white" v-else>{{ el[0].name.split(' ').slice(0, 2).join(' ') }}</p>
            <p class="text-[9px] text-white">Actif</p>
          </div>
        </div>
      </div>

      <div class="relative" v-if="chargementOne">
        <div :class="allStatus[elementIndexe][indexe].bgc !== null ? allStatus[elementIndexe][indexe].bgc : ''"
          class="fixed top-0 left-0 right-0 bottom-0 bg-gray-900 w-full flex flex-col gap-y-3 z-50">
        </div>
        <div class="fixed top-2 left-0 right-0 z-50 flex flex-col">
          <div class="flex items-center justify-start gap-x-1 px-2">
            <template v-for="(el, ind) in allStatus[elementIndexe]">
              <div class="border-gray-400 border-2 w-full rounded" v-if="indexe === ind"></div>
              <div class="border-white border-2 w-full rounded" v-else></div>
            </template>
          </div>
          <div class="flex items-center justify-between px-2 mt-2">
            <div class="flex gap-x-2 basis-[85%]">
              <img
                :src="allStatus[elementIndexe][0].image_profil !== null ? `/storage/profilImage/${allStatus[elementIndexe][0].image_profil}` : `/storage/images/account.png`"
                class="w-10 h-10 object-cover rounded" alt="image_utilisateur">
              <div class="flex flex-col">
                <Link class="text-[14px] text-white" :href="route('myActivity', allStatus[elementIndexe][0].idUser)">{{
                  allStatus[elementIndexe][0].name }}</Link>
                      <p class="text-[12px] text-white font-medium" v-if="allStatus[elementIndexe][indexe].diff_in_seconds <= 59">
                        il y a {{ allStatus[elementIndexe][indexe].diff_in_seconds }} s
                      </p>
                      <p class="text-[12px] text-white font-medium"
                        v-if="allStatus[elementIndexe][indexe].diff_in_minutes > 0 && allStatus[elementIndexe][indexe].diff_in_hours === 0">
                        il y a {{ allStatus[elementIndexe][indexe].diff_in_minutes }} min
                      </p>
                      <p class="text-[12px] text-white font-medium"
                        v-if="allStatus[elementIndexe][indexe].diff_in_hours > 0 && allStatus[elementIndexe][indexe].diff_in_days === 0">
                        il y a {{ allStatus[elementIndexe][indexe].diff_in_hours }} h
                      </p>
                      <p class="text-[12px] text-white font-medium"
                        v-if="allStatus[elementIndexe][indexe].diff_in_days > 0 && allStatus[elementIndexe][indexe].diff_in_weeks === 0">
                        il y a {{ allStatus[elementIndexe][indexe].diff_in_days }} j
                      </p>
                      <p class="text-[12px] text-white font-medium"
                        v-if="allStatus[elementIndexe][indexe].diff_in_months === 0 && allStatus[elementIndexe][indexe].diff_in_weeks > 0">
                        il y a {{ allStatus[elementIndexe][indexe].diff_in_weeks }} sem
                      </p>
                      <p class="text-[12px] text-white font-medium"
                        v-if="allStatus[elementIndexe][indexe].diff_in_months > 0 && allStatus[elementIndexe][indexe].diff_in_years === 0">
                        il y a {{ allStatus[elementIndexe][indexe].diff_in_months }} m
                      </p>
                      <p class="text-[12px] text-white font-medium" v-if="allStatus[elementIndexe][indexe].diff_in_years > 0">
                        il y a {{ allStatus[elementIndexe][indexe].diff_in_years }} a
                      </p>
              </div>
            </div>
            <span class="cursor-pointer p-1" @click="cacheStatut">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white"
                class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
              </svg>
            </span>
          </div>
          <div class="px-2 mt-4 flex flex-col h-96 relative">
            <div class="w-14 bg-transparent z-50 h-full absolute" @click="indexPrecedent"></div>
            <div class="w-14 bg-transparent z-50 h-full absolute right-0" @click="indexSuivant"></div>
            <img v-if="allStatus[elementIndexe][indexe].image !== null"
              :src="`/storage/statut/${allStatus[elementIndexe][indexe].image}`" class="w-full h-96 object-cover rounded"
              alt="image_statut" />

            <p v-if="allStatus[elementIndexe][indexe].bgc !== null && allStatus[elementIndexe][indexe].body"
              v-html="allStatus[elementIndexe][indexe].body" class="text-justify text-[14px] text-white max-h-96 overflow-y-auto"></p>
              
              <video autoplay="false" v-if="allStatus[elementIndexe][indexe].video !== null" controls
              :src="`/storage/statut/${allStatus[elementIndexe][indexe].video}`" class="h-96 w-full"
              alt="video_statut"></video>
            </div>
            <div class="px-2 mt-2 relative flex flex-col" v-if="allStatus[elementIndexe][indexe].bgc === null && allStatus[elementIndexe][indexe].body">
              <p v-html="allStatus[elementIndexe][indexe].body"
                class="mt-2 text-justify text-[14px] text-white max-h-[200px] overflow-y-auto"></p>
            </div>
          </div>
      </div>

      <transition>

        <div id="divStatus" class="hidden z-50 bg-white top-0 fixed bottom-0 left-0 right-0">
          <div class="relative text-gray-600 text-sm font-bold py-3 border-gray-300 border-b-[1px]">
            <div class="mx-auto w-[90%] flex items-center justify-between">
              <div class="flex items-center gap-2">
                <span class="cursor-pointer border-white border-[1px] bg-gray-300 rounded-full p-1" @click="openModalSt">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                  </svg>
                </span>
                <h4 class="text-[13px] text-gray-600">Mettre à jour votre story</h4>
              </div>
              <button class="text-gray-600 font-bold text-[13px]" id="button-3">
                Publier
              </button>
            </div>
          </div>

          <div class="relative flex flex-col gap-y-2">
            <div v-if="statModal"
              class="fixed top-0 left-0 right-0 bottom-0 bg-gray-900 opacity-90 w-full flex flex-col gap-y-3 z-50">
              <div
                class="w-[95%] m-auto rounded border-gray-400 border-[1px] h-[150px] py-4 px-1.5 flex flex-col gap-y-2 items-center justify-center bg-white">
                <div class="flex justify-center text-[12px] font-bold w-full rounded py-2 px-1">
                  Voulez-vous vraiment abandonner cette story ?</div>
                <div class="flex justify-between items-center text-[12px] font-bold rounded py-2 px-1 w-[85%] m-auto">
                  <button class="basis-[40%] text-white font-bold text-[12px] bg-[#0389c9] rounded py-1">Non,
                    continuer</button>
                  <button class="basis-[40%] text-white font-bold text-[12px] bg-red-600 rounded py-1"
                    @click="closeStatus">Oui, je le veux</button>
                </div>
              </div>
            </div>
            <div v-if="chargement"
              class="fixed top-0 left-0 right-0 bottom-0 bg-gray-900 opacity-90 w-full flex flex-col gap-y-3 z-50">
              <div
                class="w-[95%] m-auto rounded border-gray-400 border-[1px] h-[150px] py-4 px-1.5 flex flex-col gap-y-2 items-center justify-center bg-white">
                <div v-if="loader" class="flex justify-center"><span class="loader"></span></div>
                <div v-if="loader === false && errorMsg"
                  class="flex justify-center text-[12px] font-bold text-red-600 bg-red-300 w-full rounded py-2 px-1">
                  {{ errorMsg }}</div>
              </div>
            </div>
            <div v-if="choice" class="fixed top-11 left-0 right-0 bottom-0 w-full flex flex-col gap-y-3"
              :class="colorArrayOne[selectColor]">
              <div class="h-full flex items-center p-1">
                <textarea
                  class="min-w-full h-96 border-none text-white overflow-hidden focus:ring focus:ring-transparent cursor:text outline-none rounded-md text-center bg-transparent resize-none placeholder:text-white placeholder:text-[16px] text-[16px] placeholder:font-bold"
                  placeholder="Ecrivez quelque chose..." v-model="status"></textarea>
              </div>

              <button @click="selectColorStatus()"
                class="fixed bottom-24 right-3 bg-white w-8 h-8 flex justify-center items-center border-white border-[1px] text-white text-center text-[13px] p-2 rounded-full"><svg
                  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1"
                  x="0px" y="0px" viewBox="0 0 80 80" style="enable-background:new 0 0 80 80;" xml:space="preserve"
                  width="80" height="80">
                  <g>
                    <path style="fill:#F5C276;"
                      d="M39.999,77.5c-10.664-0.001-20.859-4.565-27.971-12.523C4.819,56.909,1.523,46.49,2.747,35.639   C4.645,18.805,18.198,5.005,34.976,2.827C36.646,2.61,38.337,2.5,40,2.5c16.174,0,30.474,10.302,35.584,25.634   c0.704,2.112,2.103,7.418-0.112,11.051c-1.17,1.918-3.219,3.116-6.089,3.562c-0.922,0.143-2.597,0.359-5.123,0.663   c-3.597,0.43-6.877,2.357-9.001,5.288c-2.152,2.97-2.941,6.585-2.222,10.18l0.431,2.153c0.812,4.055-0.225,8.216-2.843,11.417   S44.134,77.49,39.999,77.5L39.999,77.5z M37.585,55.5c-3.584,0-6.5,2.916-6.5,6.5s2.916,6.5,6.5,6.5s6.5-2.916,6.5-6.5   S41.169,55.5,37.585,55.5z" />
                    <path style="fill:#C29653;"
                      d="M40,3c15.958,0,30.067,10.164,35.11,25.292c0.682,2.046,2.041,7.178-0.065,10.632   c-1.09,1.787-3.021,2.906-5.739,3.328c-0.922,0.143-2.64,0.365-5.105,0.66c-3.734,0.447-7.141,2.449-9.347,5.492   c-2.202,3.038-3.043,6.891-2.307,10.571l0.431,2.154c0.782,3.907-0.217,7.918-2.74,11.002C47.715,75.216,43.983,76.991,40,77   c-10.523,0-20.582-4.503-27.599-12.356c-7.113-7.96-10.365-18.241-9.158-28.95C5.116,19.086,18.488,5.471,35.04,3.323   C36.69,3.109,38.358,3,40,3 M37.585,69c3.86,0,7-3.14,7-7s-3.14-7-7-7s-7,3.14-7,7S33.725,69,37.585,69 M40,2   c-1.674,0-3.371,0.108-5.089,0.331C17.844,4.547,4.178,18.481,2.25,35.583C-0.34,58.546,17.558,78,40,78   c8.991-0.021,15.721-8.251,13.958-17.067l-0.431-2.154c-1.431-7.157,3.545-14.006,10.792-14.874   c2.206-0.264,4.108-0.505,5.14-0.665c10.028-1.555,7.859-11.485,6.599-15.264C71.028,12.883,56.784,2,40,2L40,2z M37.585,68   c-3.314,0-6-2.686-6-6c0-3.314,2.686-6,6-6s6,2.686,6,6C43.585,65.314,40.898,68,37.585,68L37.585,68z" />
                  </g>
                  <g>
                    <circle style="fill:#F78F8F;" cx="18.585" cy="49" r="6.5" />
                    <path style="fill:#C74343;"
                      d="M18.585,43c3.308,0,6,2.692,6,6s-2.692,6-6,6s-6-2.692-6-6S15.276,43,18.585,43 M18.585,42   c-3.866,0-7,3.134-7,7c0,3.866,3.134,7,7,7c3.866,0,7-3.134,7-7C25.585,45.134,22.451,42,18.585,42L18.585,42z" />
                  </g>
                  <g>
                    <circle style="fill:#FFEEA3;" cx="18.585" cy="29" r="6.5" />
                    <g>
                      <path style="fill:#BA9B48;"
                        d="M18.585,23c3.308,0,6,2.692,6,6s-2.692,6-6,6s-6-2.692-6-6S15.276,23,18.585,23 M18.585,22    c-3.866,0-7,3.134-7,7s3.134,7,7,7c3.866,0,7-3.134,7-7S22.451,22,18.585,22L18.585,22z" />
                    </g>
                  </g>
                  <g>
                    <circle style="fill:#BAE0BD;" cx="34.585" cy="17" r="6.5" />
                    <g>
                      <path style="fill:#5E9C76;"
                        d="M34.585,11c3.308,0,6,2.692,6,6s-2.692,6-6,6s-6-2.692-6-6S31.276,11,34.585,11 M34.585,10    c-3.866,0-7,3.134-7,7s3.134,7,7,7c3.866,0,7-3.134,7-7S38.451,10,34.585,10L34.585,10z" />
                    </g>
                  </g>
                  <g>
                    <circle style="fill:#8BB7F0;" cx="54.585" cy="21" r="6.5" />
                    <g>
                      <path style="fill:#4E7AB5;"
                        d="M54.585,15c3.308,0,6,2.692,6,6s-2.692,6-6,6s-6-2.692-6-6S51.276,15,54.585,15 M54.585,14    c-3.866,0-7,3.134-7,7s3.134,7,7,7c3.866,0,7-3.134,7-7S58.451,14,54.585,14L54.585,14z" />
                    </g>
                  </g>
                </svg>
              </button>

              <div class="fixed bottom-4 w-full flex flex-col items-end gap-y-2 px-3">
                <label for="imageStatus"
                  class="w-8 h-8 flex justify-center items-center bg-white text-white text-center text-[13px] p-2 rounded-full"><svg
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black"
                    class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                  </svg>
                </label>
                <input type="file" class="hidden" id="imageStatus" @change="onChargementImag" multiple>
                <div class="flex items-center gap-x-1">
                  <button class="w-24 border-white border-[1px] text-white text-center text-[13px] p-1.5 rounded"
                    @click="publishImgStatutFirst()">Publier</button>
                  <img class="h-8 w-8 rounded aspect-square object-cover" :src="img !== null
                    ? `/storage/profilImage/${userInformation.file_profile}`
                    : `/storage/images/account.png`
                    " alt="image_de_l'utilisateur" />
                </div>
              </div>
            </div>

            <div v-else>
              <div class="fixed top-12 left-0 right-0 w-full" v-if="tableauImg.length > 0">
                <div class="h-full">
                  <img alt="image de statut" v-if="tableauImg[indexStatutImg].image"
                    :src="`/storage/statut/${tableauImg[indexStatutImg].image}`" class="w-full h-96 object-cover" />
                  <div v-else>
                    <video autoplay="false" controls :src="`/storage/statut/${tableauImg[indexStatutImg].video}`"
                      class="h-96 w-full" alt="video_statut"></video>
                  </div>
                  <span
                    class="cursor-pointer fixed z-50 top-14 right-[5px] border-gray-300 border-[1px] rounded-full bg-white p-1"
                    @click="closeImgStatut">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="black" class="w-3 h-3">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                  </span>
                </div>
              </div>
              <div class="fixed bottom-4 w-full flex flex-col items-end gap-y-4 px-3" v-if="tableauImg.length > 0">
                <div class="flex gap-3 overflow-x-auto whitespace-no-wrap w-full m-auto">
                  <div class="p-3 border rounded  flex-shrink-0 w-16 h-16 flex flex-col gap-y-1 shadow-md relative"
                    v-for="(el, index) in tableauImg" @click="chargeImgDeo(index)">
                    <div v-if="el.image" class="h-full">
                      <img alt="image de statut" :src="`/storage/statut/${el.image}`"
                        class="w-full h-full object-cover" />
                    </div>
                    <div v-else>
                      <img alt="image de statut" :src="`/storage/statut/images.jpg`" class="w-full h-full object-cover" />
                    </div>
                  </div>
                </div>
                <div class="w-full flex items-center gap-x-1">
                  <textarea @change="changeTextContenu" v-if="tableauImg[indexStatutImg].contenu == ''"
                    class="w-full h-20 border-gray-600 border-[1px] text-gray-700 overflow-hidden focus:ring focus:ring-transparent cursor:text outline-none rounded p-1 bg-transparent resize-none placeholder:text-gray-700 placeholder:text-[12px] text-[12px] placeholder:font-bold"
                    placeholder="Ecrivez quelque chose..." id="contenuStatut"></textarea>
                  <textarea @change="changeTextContenu" v-else
                    class="w-full h-20 border-gray-600 border-[1px] text-gray-700 overflow-hidden focus:ring focus:ring-transparent cursor:text outline-none rounded p-1 bg-transparent resize-none placeholder:text-gray-700 placeholder:text-[12px] text-[12px] placeholder:font-bold"
                    placeholder="Ecrivez quelque chose..."
                    id="contenuStatut">{{ tableauImg[indexStatutImg].contenu }}</textarea>
                </div>
                <div class="flex items-center gap-x-1">
                  <button class="w-24 bg-[#0389c9] text-white text-center text-[13px] p-1.5 rounded"
                    @click="publishImgStatut()">Publier</button>
                  <img class="h-8 w-8 rounded aspect-square object-cover" :src="img !== null
                    ? `/storage/profilImage/${userInformation.file_profile}`
                    : `/storage/images/account.png`
                    " alt="image_de_l'utilisateur" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>

    </section>

    <!-- Creation de post -->
    <section class="bg-white mt-2 mb-3">
      <div class="w-full p-2 flex flex-col gap-2">
        <div class="flex items-center gap-2 border-gray-300">
          <div class="aspect-square rounded-full">
            <img class="rounded-full aspect-square w-[35px] object-cover" :src="img !== null
              ? `/storage/profilImage/${userInformation.file_profile}`
              : `/storage/images/account.png`
              " alt="image_de_l'utilisateur" />
          </div>
          <h3 class="text-[12px] font-extrabold text-gray-600 py-1.5 px-2 rounded-full border basis-[85%] bg-gray-100"
            @click="showModalPublication">
            A quoi vous pensez ?
          </h3>
        </div>

        <div id="divPost" class="hidden z-40 bg-white top-[62px] fixed bottom-0 left-0 right-0 rounded-l-lg rounded-r-lg">
          <div class="relative text-gray-600 text-sm font-bold py-3 border-gray-300 border-b-[1px] mb-2">
            <div class="mx-auto w-[90%] flex items-center justify-between">
              <div class="flex items-center gap-2">
                <span class="cursor-pointer border-gray-300 border-[1px] bg-gray-300 rounded p-1"
                  @click="closeModalPublication">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                  </svg>
                </span>
                <h4 class="text-[13px]">Créer un post</h4>
              </div>
              <button class="text-sky-500 font-bold text-[13px]" id="button-3" @click="publishPost('button-3')">
                Publier
              </button>
            </div>
          </div>

          <div class="mx-auto w-[95%] overflow-y-auto h-[500px]">
            <div class="w-full p-1 relative">
              <template v-if="selectedColorIndex !== null">
                <div class="h-64 flex items-center p-5" :class="`${colorArray[selectedColorIndex]}`">
                  <ul class='absolute right-2 top-2'>
                    <li @click="closeTextarea"
                      class="cursor-pointer flex item-center justify-center bg-white border shadow rounded-full w-[23px] aspect-radio">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
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
                <li v-for="(color, index) in colorArray" :key="index" class="aspect-square rounded-full w-[20px]"
                  :class="`${color}`" :id="'li-' + index" @click="openTextarea(index)"></li>
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
                <img :src="`/storage/post_images_videos/${nameImg}`" class="object-cover h-48 w-full rounded-lg"
                  alt="image_post" />
              </div>
              <div v-if="nameImg !== null && valeur === 'video'" class="mt-2">
                <video preload="auto" controls autoplay :src="`/storage/post_images_videos/${nameImg}`"
                  class="h-48 w-full rounded-lg" alt="video_post"></video>
              </div>
              <span
                class="cursor-pointer absolute top-[5px] right-[5px] border-gray-300 border-[1px] bg-gray-300 rounded-full p-1"
                @click="closeVisual">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black"
                  class="w-3 h-3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
              </span>
            </div>

            <p id="paragraph" class="my-2 hidden bg-red-200 text-red-600 font-bold p-1 rounded"></p>

            <button class="mt-4 w-full bg-[#0c7fb9] text-white text-center text-[13px] p-2 rounded-lg" id="button-1"
              type="button" @click="publishPost('button-1')">
              PUBLIER
            </button>
          </div>
        </div>
      </div>

    </section>

    <!-- Contenu principal de la page -->
    <section class="mb-20">
      <div class="bg-white" v-if="myTables.length > 0">
        <div class="bg-white py-1">
          <div class="flex flex-col gap-y-2">
            <div v-for="(item, index) in myTables.slice(0, 4)" :key="index" class="border-b-[1px] pb-2 shadow-sm my-1">
              <div v-if="item.creator_name">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2 px-2">
                    <img :src="item.image_user !== null
                      ? `/storage/profilImage/${item.image_user}`
                      : `/storage/images/account.png`
                      " alt="image_de_profil" class="rounded-full w-[35px] h-[35px] object-cover" />
                    <div class="flex flex-col">
                      <h3 class="text-[12px] flex flex-wrap items-center gap-x-2 font-bold text-gray-700"
                        v-if="item.tagged_names !== null && $page.props.auth.user.id == item.tagged_names.split('-')[0]">
                        <Link :href="route('myActivity', item.user_id)" class="text-[12px]">{{
                          item.creator_name }}</Link>
                        <p class="text-[12px] flex flex-wrap items-center gap-x-1" v-if="item.tagged_names !== null"><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                          </svg>
                          <Link :href="route('myActivity', item.tagged_names.split('-')[0])">{{
                            item.tagged_names.split('-')[1]
                          }}</Link>
                        </p>
                      </h3>
                      <h3 class="text-[12px] flex flex-wrap items-center gap-x-2 font-bold text-gray-700" v-else>
                        <Link :href="route('myActivity', item.user_id)">{{ item.creator_name
                        }}</Link>
                        <p class="text-[12px] flex flex-wrap items-center gap-x-1" v-if="item.tagged_names !== null"><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                          </svg>
                          <Link :href="route('myActivity', item.tagged_names.split('-')[0])">{{
                            item.tagged_names.split('-')[1]
                          }}</Link>
                        </p>
                      </h3>
                      <p class="text-[12px] text-gray-600 font-medium" v-if="item.diff_in_seconds <= 59">
                        il y a {{ item.diff_in_seconds }} s
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_minutes > 0 && item.diff_in_hours === 0">
                        il y a {{ item.diff_in_minutes }} min
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_hours > 0 && item.diff_in_days === 0">
                        il y a {{ item.diff_in_hours }} h
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_days > 0 && item.diff_in_weeks == 0">
                        il y a {{ item.diff_in_days }} j
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_months === 0 && item.diff_in_weeks > 0">
                        il y a {{ item.diff_in_weeks }} sem
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_months > 0 && item.diff_in_years === 0">
                        il y a {{ item.diff_in_months }} m
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium" v-if="item.diff_in_years > 0">
                        il y a {{ item.diff_in_years }} a
                      </p>
                    </div>
                  </div>
                  <div class="relative basis-[2%] mr-2">
                    <span class="cursor-pointer" v-if="item.video !== null || item.image !== null"
                      @click="transitionFunction(index)">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                      </svg>
                    </span>
                    <span v-else-if="item.user_id === $page.props.auth.user.id" class="cursor-pointer"
                      @click="transitionFunction(index)">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                      </svg>
                    </span>
                    <transition>
                      <div :id="'posts-' + index" v-if="item.image !== null"
                        class="allPosts hidden w-[150px] absolute right-0 top-6 bg-gray-300 rounded">
                        <ul class="cursor-pointer">
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="saveImage(item, index)">
                            Enrégistrer cette image
                          </li>
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="deletePost(item, index)" v-if="item.user_id === $page.props.auth.user.id">
                            Supprimer le post
                          </li>
                        </ul>
                      </div>
                      <div :id="'posts-' + index" v-else-if="item.video !== null"
                        class="allPosts z-50 hidden w-[150px] absolute right-0 top-6 bg-gray-300 rounded">
                        <ul class="cursor-pointer">
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="saveImage(item, index)">
                            Enrégistrer cette vidéo
                          </li>
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="deletePost(item, index)" v-if="item.user_id === $page.props.auth.user.id">
                            Supprimer le post
                          </li>
                        </ul>
                      </div>
                      <div :id="'posts-' + index" v-else-if="item.user_id === $page.props.auth.user.id"
                        class="allPosts hidden w-[140px] absolute right-0 top-6 bg-gray-300 rounded">
                        <ul class="cursor-pointer">
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="deletePost(item, index)">
                            Supprimer le post
                          </li>
                        </ul>
                      </div>
                    </transition>
                  </div>
                </div>
                <div class="mt-[10px]">
                  <p v-if="item.bgc !== null && item.body.trim().split(/\s+/).length <= 30" class="text-[13px]"
                    :class="item.bgc + ' py-8 px-2 flex items-center justify-center h-[280px] overflow-y-auto text-white'"
                    v-html="item.body"></p>
                  <div v-else-if="item.body !== null">
                    <p v-if="item.body.trim().split(/\s+/).length <= 30" class="text-[13px] w-[97%] mx-auto px-2"
                      v-html="item.body"></p>
                    <p v-else class="text-[13px] w-[97%] mx-auto px-2"
                      v-html="item.body.trim().split(' ').slice(0, 30).join(' ') + ' ...'"></p>
                    <Link v-if="item.body.trim().split(/\s+/).length > 30"
                      :href="route('postUser', [item.id, item.user_id])"
                      class="text-[12px] font-bold w-[95%] mx-auto px-3 text-sky-600">Voir plus</Link>
                  </div>
                  <Link :href="route('postUser', [item.id, item.user_id])"><img v-if="item.image !== null"
                    :src="`/storage/post_images_videos/${item.image}`" alt="image_de_profil"
                    class="w-full h-96 object-cover" /></Link>
                  <div class="mt-2" v-if="item.video">
                    <video controls :src="`/storage/post_images_videos/${item.video}`" class="h-[400px] w-full rounded-lg"
                      alt="video_post"></video>
                  </div>
                </div>
                <div :class="item.likes > 0 ? '' : 'hidden'"
                  class="mt-[1px] px-1 cursor-pointer hover:bg-sky-100 border-gray-300 border-b-[1px] font-bold">
                  <span :id="'likePost-' + index" v-if="item.trueVariable && item.likes > 1"
                    class="text-gray-600 text-[12px]">Vous et {{ item.likes - 1 }}
                    autre(s) personne(s) ont aimé cette
                    publication.</span>
                  <span :id="'likePost-' + index" v-else-if="item.trueVariable && item.likes == 1"
                    class="text-gray-600 text-[12px]">Vous avez aimé cette
                    publication.</span>
                  <span :id="'likePost-' + index" v-else-if="item.likes == 1" class="text-gray-600 text-[12px]">{{
                    item.likes
                  }} personne a aimé cette
                    publication.</span>
                  <span :id="'likePost-' + index" v-else class="text-gray-600 text-[12px]">{{ item.likes }}
                    personne(s) ont
                    aimé cette publication.</span>
                </div>
                <div class="mt-2 flex justify-between items-center w-[95%] mx-auto">
                  <span class="basis-[48%] flex justify-center p-1 cursor-pointer gap-2 items-center"
                    @click="clickLikePost(item, `${'likePost-' + index}`)">
                    <span v-if="item.trueVariable === false" class="flex gap-2 items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="gray" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                      </svg>
                      <span class="text-gray-600 text-[12px] font-bold">{{ item.likes }} j'aime(s)</span>
                    </span>
                    <span v-else class="flex gap-2 items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="#0080FF" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="#0080FF" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                      </svg>
                      <span class="text-sky-500 text-[12px] font-bold">{{ item.likes }} j'aime(s)</span>
                    </span>
                  </span>
                  <Link :href="route('postUser', [item.id, item.user_id])"
                    class="basis-[48%] flex justify-center p-1 cursor-pointer gap-2 items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="gray"
                    class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                  </svg>
                  <span class="text-gray-600 text-[12px] font-bold">{{ item.comments }}
                    commentaire(s)</span>
                  </Link>
                </div>
              </div>

              <div v-else-if="item.file_profile">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2 px-2">
                    <img :src="`/storage/profilImage/${item.file_profile}`" alt="image_de_profil"
                      class="rounded-full w-[35px] h-[35px] object-cover" />
                    <div class="flex flex-col">
                      <Link :href="route('myActivity', item.user_id)" class="font-bold text-gray-700 text-[12px]">{{
                        item.name }} <span class="text-[11px]">a changé sa photo de profil</span></Link>
                      <p class="text-[12px] text-gray-600 font-medium" v-if="item.diff_in_seconds <= 59">
                        il y a {{ item.diff_in_seconds }} s
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_minutes > 0 && item.diff_in_hours === 0">
                        il y a {{ item.diff_in_minutes }} min
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_hours > 0 && item.diff_in_days === 0">
                        il y a {{ item.diff_in_hours }} h
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_days > 0 && item.diff_in_weeks == 0">
                        il y a {{ item.diff_in_days }} j
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_months === 0 && item.diff_in_weeks > 0">
                        il y a {{ item.diff_in_weeks }} sem
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_months > 0 && item.diff_in_years === 0">
                        il y a {{ item.diff_in_months }} m
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium" v-if="item.diff_in_years > 0">
                        il y a {{ item.diff_in_years }} a
                      </p>
                    </div>
                  </div>
                  <div class="relative basis-[2%] mr-2">
                    <span class="cursor-pointer" @click="transitionFunctionOne(index)">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                      </svg>
                    </span>
                    <transition>
                      <div :id="'index-' + index"
                        class="allClick hidden w-[140px] absolute right-0 top-6 bg-gray-300 rounded">
                        <ul class="cursor-pointer">
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px]" @click="enregistrerImage(item, index)">
                            Enrégistrer cette image
                          </li>
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px]" @click="deleteImage(item, index)"
                            v-if="item.user_id === $page.props.auth.user.id">
                            Supprimer l'image
                          </li>
                        </ul>
                      </div>
                    </transition>
                  </div>
                </div>
                <div class="mt-2">
                  <Link :href="route('postProfil', [item.idUser, item.id])">
                  <img :src="`/storage/profilImage/${item.file_profile}`" alt="image_de_profil"
                    class="w-full h-96 object-cover" />
                  </Link>
                </div>
                <div :class="item.likes > 0 ? '' : 'hidden'"
                  class="mt-[1px] px-1 cursor-pointer hover:bg-sky-100 border-gray-300 border-b-[1px] font-bold">
                  <span :id="'like-' + index" v-if="item.trueVariable && item.likes > 1"
                    class="text-gray-600 text-[12px]">Vous et {{ item.likes - 1 }}
                    autre(s) personne(s) ont aimé cette
                    photo.</span>
                  <span :id="'like-' + index" v-else-if="item.trueVariable && item.likes == 1"
                    class="text-gray-600 text-[12px]">Vous avez aimé cette
                    photo.</span>
                  <span :id="'like-' + index" v-else-if="item.likes == 1" class="text-gray-600 text-[12px]">{{ item.likes
                  }}
                    personne a aimé cette
                    photo.</span>
                  <span :id="'like-' + index" v-else class="text-gray-600 text-[12px]">{{ item.likes }}
                    personne(s) ont aimé
                    cette photo.</span>
                </div>
                <div class="mt-1 flex justify-between items-center w-[95%] mx-auto">
                  <span class="basis-[48%] flex justify-center p-1 cursor-pointer gap-2 items-center"
                    @click="clickLike(item, `${'like-' + index}`)">
                    <span v-if="item.trueVariable === false" class="flex gap-2 items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="gray" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                      </svg>
                      <span class="text-gray-600 text-[12px] font-bold">{{ item.likes }} j'aime(s)</span>
                    </span>
                    <span v-else class="flex gap-2 items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="#0080FF" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="#0080FF" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                      </svg>
                      <span class="text-sky-500 text-[12px] font-bold">{{ item.likes }} j'aime(s)</span>
                    </span>
                  </span>
                  <Link class="basis-[48%] flex justify-center p-1 cursor-pointer gap-2 items-center"
                    :href="route('postProfil', [item.idUser, item.id])">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="gray"
                    class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                  </svg>
                  <span class="text-gray-600 text-[12px] font-bold">{{ item.comments }}
                    commentaire(s)</span>
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-if="friends.length > 0" class="border-gray-300 border-y-[1px] py-2">
          <div class="flex flex-start m-auto w-[95%]">
            <Link :href="route('abonnements', $page.props.auth.user.uuid)"
              class="text-[12px] w-[35%] flex items-center justify-center gap-1 bg-[#0c7fb9] p-1 rounded text-white">
            Suggestions
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-3 h-3">
              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            </Link>
          </div>
          <div class="overflow-x-auto whitespace-no-wrap mt-2 w-[95%] m-auto">
            <div class="flex justify-start gap-4">
              <div class="flex-shrink-0 w-32 flex flex-col gap-y-1" v-for="(element, index) in friends.slice(0, 10)"
                :key="index">
                <Link :href="route('myActivity', element.id)" class="flex flex-col gap-1">
                <img class="aspect-square w-32 h-[180px] object-cover rounded" :src="element.image !== null
                  ? `/storage/profilImage/${element.image}`
                  : `/storage/images/account.png`
                  " alt="" />
                <h3 class="text-[12px] text-center truncate">{{ element.name }}</h3>
                </Link>
                <div class="basis-full">
                  <button
                    class="w-full rounded py-1.5 px-5 bg-[#0389c9] text-white hover:text-sky-500 hover:bg-white font-bold text-[9px]"
                    @click="followingAction(element.id, index)">Suivre</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-2 bg-white py-1">
          <div class="flex flex-col gap-y-2">
            <div v-for="(item, index) in myTables.slice(4, 10)" :key="index" class="border-b-[1px] pb-2 shadow-sm my-1">
              <div v-if="item.creator_name">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2 px-2">
                    <img :src="item.image_user !== null
                      ? `/storage/profilImage/${item.image_user}`
                      : `/storage/images/account.png`
                      " alt="image_de_profil" class="rounded-full w-[35px] h-[35px] object-cover" />
                    <div class="flex flex-col">
                      <h3 class="text-[12px] flex flex-wrap items-center gap-x-2 font-bold text-gray-700"
                        v-if="item.tagged_names !== null && $page.props.auth.user.id == item.tagged_names.split('-')[0]">
                        <Link :href="route('myActivity', item.user_id)" class="text-[12px]">{{
                          item.creator_name }}</Link>
                        <p class="text-[12px] flex flex-wrap items-center gap-x-1" v-if="item.tagged_names !== null"><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                          </svg>
                          <Link :href="route('myActivity', item.tagged_names.split('-')[0])">{{
                            item.tagged_names.split('-')[1]
                          }}</Link>
                        </p>
                      </h3>
                      <h3 class="text-[12px] flex flex-wrap items-center gap-x-2 font-bold text-gray-700" v-else>
                        <Link :href="route('myActivity', item.user_id)">{{ item.creator_name
                        }}</Link>
                        <p class="text-[12px] flex flex-wrap items-center gap-x-1" v-if="item.tagged_names !== null"><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                          </svg>
                          <Link :href="route('myActivity', item.tagged_names.split('-')[0])">{{
                            item.tagged_names.split('-')[1]
                          }}</Link>
                        </p>
                      </h3>
                      <p class="text-[12px] text-gray-600 font-medium" v-if="item.diff_in_seconds <= 59">
                        il y a {{ item.diff_in_seconds }} s
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_minutes > 0 && item.diff_in_hours === 0">
                        il y a {{ item.diff_in_minutes }} min
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_hours > 0 && item.diff_in_days === 0">
                        il y a {{ item.diff_in_hours }} h
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_days > 0 && item.diff_in_weeks == 0">
                        il y a {{ item.diff_in_days }} j
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_months === 0 && item.diff_in_weeks > 0">
                        il y a {{ item.diff_in_weeks }} sem
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_months > 0 && item.diff_in_years === 0">
                        il y a {{ item.diff_in_months }} m
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium" v-if="item.diff_in_years > 0">
                        il y a {{ item.diff_in_years }} a
                      </p>
                    </div>
                  </div>
                  <div class="relative basis-[2%] mr-2">
                    <span class="cursor-pointer" v-if="item.video !== null || item.image !== null"
                      @click="transitionFunction((index + 4))">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                      </svg>
                    </span>
                    <span v-else-if="item.user_id === $page.props.auth.user.id" class="cursor-pointer"
                      @click="transitionFunction((index + 4))">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                      </svg>
                    </span>
                    <transition>
                      <div :id="'posts-' + (index + 4)" v-if="item.image !== null"
                        class="allPosts hidden w-[150px] absolute right-0 top-6 bg-gray-300 rounded">
                        <ul class="cursor-pointer">
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="saveImage(item, (index + 4))">
                            Enrégistrer cette image
                          </li>
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="deletePost(el, (index + 4))" v-if="item.user_id === $page.props.auth.user.id">
                            Supprimer le post
                          </li>
                        </ul>
                      </div>
                      <div :id="'posts-' + (index + 4)" v-else-if="item.video !== null"
                        class="allPosts z-50 hidden w-[150px] absolute right-0 top-6 bg-gray-300 rounded">
                        <ul class="cursor-pointer">
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="saveImage(item, (index + 4))">
                            Enrégistrer cette vidéo
                          </li>
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="deletePost(item, (index + 4))" v-if="item.user_id === $page.props.auth.user.id">
                            Supprimer le post
                          </li>
                        </ul>
                      </div>
                      <div :id="'posts-' + (index + 4)" v-else-if="item.user_id === $page.props.auth.user.id"
                        class="allPosts hidden w-[140px] absolute right-0 top-6 bg-gray-300 rounded">
                        <ul class="cursor-pointer">
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="deletePost(item, (index + 4))">
                            Supprimer le post
                          </li>
                        </ul>
                      </div>
                    </transition>
                  </div>
                </div>
                <div class="mt-[10px]">
                  <!-- {{ item.body.trim() }} -->
                  <p v-if="item.bgc !== null && item.body.trim().split(/\s+/).length <= 30" class="text-[13px]"
                    :class="item.bgc + ' py-8 px-2 flex items-center justify-center h-[280px] overflow-y-auto text-white'"
                    v-html="item.body"></p>
                  <div v-else-if="item.body !== null">
                    <p v-if="item.body.trim().split(/\s+/).length <= 30" class="text-[13px] w-[97%] mx-auto px-2"
                      v-html="item.body"></p>
                    <p v-else class="text-[13px] w-[97%] mx-auto px-2"
                      v-html="item.body.trim().split(' ').slice(0, 30).join(' ') + ' ...'"></p>
                    <Link v-if="item.body.trim().split(/\s+/).length > 30"
                      :href="route('postUser', [item.id, item.user_id])"
                      class="text-[12px] font-bold w-[95%] mx-auto px-3 text-sky-600">Voir plus</Link>
                  </div>
                  <Link :href="route('postUser', [item.id, item.user_id])"><img v-if="item.image !== null"
                    :src="`/storage/post_images_videos/${item.image}`" alt="image_de_profil"
                    class="w-full h-96 object-cover" /></Link>
                  <div class="mt-2" v-if="item.video">
                    <video controls :src="`/storage/post_images_videos/${item.video}`" class="h-[400px] w-full rounded-lg"
                      alt="video_post"></video>
                  </div>
                </div>
                <div :class="item.likes > 0 ? '' : 'hidden'"
                  class="mt-[1px] px-1 cursor-pointer hover:bg-sky-100 border-gray-300 border-b-[1px] font-bold">
                  <span :id="'likePost-' + (index + 4)" v-if="item.trueVariable && item.likes > 1"
                    class="text-gray-600 text-[12px]">Vous et {{ item.likes - 1 }}
                    autre(s) personne(s) ont aimé cette
                    publication.</span>
                  <span :id="'likePost-' + (index + 4)" v-else-if="item.trueVariable && item.likes == 1"
                    class="text-gray-600 text-[12px]">Vous avez aimé cette
                    publication.</span>
                  <span :id="'likePost-' + (index + 4)" v-else-if="item.likes == 1" class="text-gray-600 text-[12px]">{{
                    item.likes
                  }} personne a aimé cette
                    publication.</span>
                  <span :id="'likePost-' + (index + 4)" v-else class="text-gray-600 text-[12px]">{{ item.likes }}
                    personne(s) ont
                    aimé cette publication.</span>
                </div>
                <div class="mt-2 flex justify-between items-center w-[95%] mx-auto">
                  <span class="basis-[48%] flex justify-center p-1 cursor-pointer gap-2 items-center"
                    @click="clickLikePost(item, `${'likePost-' + (index + 4)}`)">
                    <span v-if="item.trueVariable === false" class="flex gap-2 items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="gray" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                      </svg>
                      <span class="text-gray-600 text-[12px] font-bold">{{ item.likes }} j'aime(s)</span>
                    </span>
                    <span v-else class="flex gap-2 items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="#0080FF" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="#0080FF" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                      </svg>
                      <span class="text-sky-500 text-[12px] font-bold">{{ item.likes }} j'aime(s)</span>
                    </span>
                  </span>
                  <Link :href="route('postUser', [item.id, item.user_id])"
                    class="basis-[48%] flex justify-center p-1 cursor-pointer gap-2 items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="gray"
                    class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                  </svg>
                  <span class="text-gray-600 text-[12px] font-bold">{{ item.comments }}
                    commentaire(s)</span>
                  </Link>
                </div>
              </div>

              <div v-else-if="item.file_profile">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2 px-2">
                    <img :src="`/storage/profilImage/${item.file_profile}`" alt="image_de_profil"
                      class="rounded-full w-[35px] h-[35px] object-cover" />
                    <div class="flex flex-col">
                      <Link :href="route('myActivity', item.user_id)" class="font-bold text-gray-700 text-[12px]">{{
                        item.name }} <span class="text-[11px]">a changé sa photo de profil</span></Link>
                      <p class="text-[12px] text-gray-600 font-medium" v-if="item.diff_in_seconds <= 59">
                        il y a {{ item.diff_in_seconds }} s
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_minutes > 0 && item.diff_in_hours === 0">
                        il y a {{ item.diff_in_minutes }} min
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_hours > 0 && item.diff_in_days === 0">
                        il y a {{ item.diff_in_hours }} h
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_days > 0 && item.diff_in_weeks == 0">
                        il y a {{ item.diff_in_days }} j
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_months === 0 && item.diff_in_weeks > 0">
                        il y a {{ item.diff_in_weeks }} sem
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_months > 0 && item.diff_in_years === 0">
                        il y a {{ item.diff_in_months }} m
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium" v-if="item.diff_in_years > 0">
                        il y a {{ item.diff_in_years }} a
                      </p>
                    </div>
                  </div>
                  <div class="relative basis-[2%] mr-2">
                    <span class="cursor-pointer" @click="transitionFunctionOne((index + 4))">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                      </svg>
                    </span>
                    <transition>
                      <div :id="'index-' + (index + 4)"
                        class="allClick hidden w-[140px] absolute right-0 top-6 bg-gray-300 rounded">
                        <ul class="cursor-pointer">
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px]"
                            @click="enregistrerImage(item, (index + 4))">
                            Enrégistrer cette image
                          </li>
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px]" @click="deleteImage(item, (index + 4))"
                            v-if="item.user_id === $page.props.auth.user.id">
                            Supprimer l'image
                          </li>
                        </ul>
                      </div>
                    </transition>
                  </div>
                </div>
                <div class="mt-2">
                  <Link :href="route('postProfil', [item.idUser, item.id])">
                  <img :src="`/storage/profilImage/${item.file_profile}`" alt="image_de_profil"
                    class="w-full h-96 object-cover" />
                  </Link>
                </div>
                <div :class="item.likes > 0 ? '' : 'hidden'"
                  class="mt-[1px] px-1 cursor-pointer hover:bg-sky-100 border-gray-300 border-b-[1px] font-bold">
                  <span :id="'like-' + (index + 4)" v-if="item.trueVariable && item.likes > 1"
                    class="text-gray-600 text-[12px]">Vous et {{ item.likes - 1 }}
                    autre(s) personne(s) ont aimé cette
                    photo.</span>
                  <span :id="'like-' + (index + 4)" v-else-if="item.trueVariable && item.likes == 1"
                    class="text-gray-600 text-[12px]">Vous avez aimé cette
                    photo.</span>
                  <span :id="'like-' + (index + 4)" v-else-if="item.likes == 1" class="text-gray-600 text-[12px]">{{
                    item.likes
                  }}
                    personne a aimé cette
                    photo.</span>
                  <span :id="'like-' + (index + 4)" v-else class="text-gray-600 text-[12px]">{{ item.likes }}
                    personne(s) ont aimé
                    cette photo.</span>
                </div>
                <div class="mt-1 flex justify-between items-center w-[95%] mx-auto">
                  <span class="basis-[48%] flex justify-center p-1 cursor-pointer gap-2 items-center"
                    @click="clickLike(item, `${'like-' + (index + 4)}`)">
                    <span v-if="item.trueVariable === false" class="flex gap-2 items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="gray" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                      </svg>
                      <span class="text-gray-600 text-[12px] font-bold">{{ item.likes }} j'aime(s)</span>
                    </span>
                    <span v-else class="flex gap-2 items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="#0080FF" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="#0080FF" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                      </svg>
                      <span class="text-sky-500 text-[12px] font-bold">{{ item.likes }} j'aime(s)</span>
                    </span>
                  </span>
                  <Link class="basis-[48%] flex justify-center p-1 cursor-pointer gap-2 items-center"
                    :href="route('postProfil', [item.idUser, item.id])">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="gray"
                    class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                  </svg>
                  <span class="text-gray-600 text-[12px] font-bold">{{ item.comments }}
                    commentaire(s)</span>
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-if="myTables.length > 12 && friends.length > 15" class="border-gray-300 border-y-[1px] py-2">
          <div class="flex flex-start m-auto w-[95%]">
            <Link :href="route('abonnements', $page.props.auth.user.uuid)"
              class="text-[12px] w-[35%] flex items-center justify-center gap-1 bg-[#0c7fb9] p-1 rounded text-white">
            Suggestions
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-3 h-3">
              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            </Link>
          </div>
          <div class="overflow-x-auto whitespace-no-wrap mt-2 w-[95%] m-auto">
            <div class="flex justify-start gap-4">
              <div class="flex-shrink-0 w-32 flex flex-col gap-y-1" v-for="(element, index) in friends.slice(10, 15)"
                :key="index">
                <Link :href="route('myActivity', element.id)" class="flex flex-col gap-1">
                <img class="aspect-square w-32 h-[180px] object-cover rounded" :src="element.image !== null
                  ? `/storage/profilImage/${element.image}`
                  : `/storage/images/account.png`
                  " alt="" />
                <h3 class="text-[12px] text-center truncate">{{ element.name }}</h3>
                </Link>
                <div class="basis-full">
                  <button
                    class="w-full rounded py-1.5 px-5 bg-[#0389c9] text-white hover:text-sky-500 hover:bg-white font-bold text-[9px]"
                    @click="followingAction(element.id, index)">Suivre</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-2 bg-white py-1">
          <div class="flex flex-col gap-y-2">
            <div v-for="(item, index) in myTables.slice(10, myTables.length)" :key="index"
              class="border-b-[1px] pb-2 shadow-sm my-1">
              <div v-if="item.creator_name">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2 px-2">
                    <img :src="item.image_user !== null
                      ? `/storage/profilImage/${item.image_user}`
                      : `/storage/images/account.png`
                      " alt="image_de_profil" class="rounded-full w-[35px] h-[35px] object-cover" />
                    <div class="flex flex-col">
                      <h3 class="text-[12px] flex flex-wrap items-center gap-x-2 font-bold text-gray-700"
                        v-if="item.tagged_names !== null && $page.props.auth.user.id == item.tagged_names.split('-')[0]">
                        <Link :href="route('myActivity', item.user_id)" class="text-[12px]">{{
                          item.creator_name }}</Link>
                        <p class="text-[12px] flex flex-wrap items-center gap-x-1" v-if="item.tagged_names !== null"><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                          </svg>
                          <Link :href="route('myActivity', item.tagged_names.split('-')[0])">{{
                            item.tagged_names.split('-')[1]
                          }}</Link>
                        </p>
                      </h3>
                      <h3 class="text-[12px] flex flex-wrap items-center gap-x-2 font-bold text-gray-700" v-else>
                        <Link :href="route('myActivity', item.user_id)">{{ item.creator_name
                        }}</Link>
                        <p class="text-[12px] flex flex-wrap items-center gap-x-1" v-if="item.tagged_names !== null"><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                          </svg>
                          <Link :href="route('myActivity', item.tagged_names.split('-')[0])">{{
                            item.tagged_names.split('-')[1]
                          }}</Link>
                        </p>
                      </h3>
                      <p class="text-[12px] text-gray-600 font-medium" v-if="item.diff_in_seconds <= 59">
                        il y a {{ item.diff_in_seconds }} s
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_minutes > 0 && item.diff_in_hours === 0">
                        il y a {{ item.diff_in_minutes }} min
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_hours > 0 && item.diff_in_days === 0">
                        il y a {{ item.diff_in_hours }} h
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_days > 0 && item.diff_in_weeks == 0">
                        il y a {{ item.diff_in_days }} j
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_months === 0 && item.diff_in_weeks > 0">
                        il y a {{ item.diff_in_weeks }} sem
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_months > 0 && item.diff_in_years === 0">
                        il y a {{ item.diff_in_months }} m
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium" v-if="item.diff_in_years > 0">
                        il y a {{ item.diff_in_years }} a
                      </p>
                    </div>
                  </div>
                  <div class="relative basis-[2%] mr-2">
                    <span class="cursor-pointer" v-if="item.video !== null || item.image !== null"
                      @click="transitionFunction((index + 10))">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                      </svg>
                    </span>
                    <span v-else-if="item.user_id === $page.props.auth.user.id" class="cursor-pointer"
                      @click="transitionFunction((index + 10))">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                      </svg>
                    </span>
                    <transition>
                      <div :id="'posts-' + (index + 10)" v-if="item.image !== null"
                        class="allPosts hidden w-[150px] absolute right-0 top-6 bg-gray-300 rounded">
                        <ul class="cursor-pointer">
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="saveImage(item, (index + 10))">
                            Enrégistrer cette image
                          </li>
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="deletePost(item, (index + 10))" v-if="item.user_id === $page.props.auth.user.id">
                            Supprimer le post
                          </li>
                        </ul>
                      </div>
                      <div :id="'posts-' + (index + 10)" v-else-if="item.video !== null"
                        class="allPosts z-50 hidden w-[150px] absolute right-0 top-6 bg-gray-300 rounded">
                        <ul class="cursor-pointer">
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="saveImage(item, (index + 10))">
                            Enrégistrer cette vidéo
                          </li>
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="deletePost(item, (index + 10))" v-if="item.user_id === $page.props.auth.user.id">
                            Supprimer le post
                          </li>
                        </ul>
                      </div>
                      <div :id="'posts-' + (index + 10)" v-else-if="item.user_id === $page.props.auth.user.id"
                        class="allPosts hidden w-[140px] absolute right-0 top-6 bg-gray-300 rounded">
                        <ul class="cursor-pointer">
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px] text-center"
                            @click="deletePost(item, (index + 10))">
                            Supprimer le post
                          </li>
                        </ul>
                      </div>
                    </transition>
                  </div>
                </div>
                <div class="mt-[10px]">
                  <p v-if="item.bgc !== null && item.body.trim().split(/\s+/).length <= 30" class="text-[13px]"
                    :class="item.bgc + ' py-8 px-2 flex items-center justify-center h-[280px] overflow-y-auto text-white'"
                    v-html="item.body"></p>
                  <div v-else-if="item.body !== null">
                    <p v-if="item.body.trim().split(/\s+/).length <= 30" class="text-[13px] w-[97%] mx-auto px-2"
                      v-html="item.body"></p>
                    <p v-else class="text-[13px] w-[97%] mx-auto px-2"
                      v-html="item.body.trim().split(' ').slice(0, 30).join(' ') + ' ...'"></p>
                    <Link v-if="item.body.trim().split(/\s+/).length > 30"
                      :href="route('postUser', [item.id, item.user_id])"
                      class="text-[12px] font-bold w-[95%] mx-auto px-3 text-sky-600">Voir plus</Link>
                  </div>
                  <Link :href="route('postUser', [item.id, item.user_id])"><img v-if="item.image !== null"
                    :src="`/storage/post_images_videos/${item.image}`" alt="image_de_profil"
                    class="w-full h-96 object-cover" /></Link>
                  <div class="mt-2" v-if="item.video">
                    <video controls :src="`/storage/post_images_videos/${item.video}`" class="h-[400px] w-full rounded-lg"
                      alt="video_post"></video>
                  </div>
                </div>
                <div :class="item.likes > 0 ? '' : 'hidden'"
                  class="mt-[1px] px-1 cursor-pointer hover:bg-sky-100 border-gray-300 border-b-[1px] font-bold">
                  <span :id="'likePost-' + (index + 10)" v-if="item.trueVariable && item.likes > 1"
                    class="text-gray-600 text-[12px]">Vous et {{ item.likes - 1 }}
                    autre(s) personne(s) ont aimé cette
                    publication.</span>
                  <span :id="'likePost-' + (index + 10)" v-else-if="item.trueVariable && item.likes == 1"
                    class="text-gray-600 text-[12px]">Vous avez aimé cette
                    publication.</span>
                  <span :id="'likePost-' + (index + 10)" v-else-if="item.likes == 1" class="text-gray-600 text-[12px]">{{
                    item.likes
                  }} personne a aimé cette
                    publication.</span>
                  <span :id="'likePost-' + (index + 10)" v-else class="text-gray-600 text-[12px]">{{ item.likes }}
                    personne(s) ont
                    aimé cette publication.</span>
                </div>
                <div class="mt-2 flex justify-between items-center w-[95%] mx-auto">
                  <span class="basis-[48%] flex justify-center p-1 cursor-pointer gap-2 items-center"
                    @click="clickLikePost(item, `${'likePost-' + (index + 10)}`)">
                    <span v-if="item.trueVariable === false" class="flex gap-2 items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="gray" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                      </svg>
                      <span class="text-gray-600 text-[12px] font-bold">{{ item.likes }} j'aime(s)</span>
                    </span>
                    <span v-else class="flex gap-2 items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="#0080FF" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="#0080FF" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                      </svg>
                      <span class="text-sky-500 text-[12px] font-bold">{{ item.likes }} j'aime(s)</span>
                    </span>
                  </span>
                  <Link :href="route('postUser', [item.id, item.user_id])"
                    class="basis-[48%] flex justify-center p-1 cursor-pointer gap-2 items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="gray"
                    class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                  </svg>
                  <span class="text-gray-600 text-[12px] font-bold">{{ item.comments }}
                    commentaire(s)</span>
                  </Link>
                </div>
              </div>

              <div v-else-if="item.file_profile">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2 px-2">
                    <img :src="`/storage/profilImage/${item.file_profile}`" alt="image_de_profil"
                      class="rounded-full w-[35px] h-[35px] object-cover" />
                    <div class="flex flex-col">
                      <Link :href="route('myActivity', item.user_id)" class="font-bold text-gray-700 text-[12px]">{{
                        item.name }} <span class="text-[11px]">a changé sa photo de profil</span></Link>
                      <p class="text-[12px] text-gray-600 font-medium" v-if="item.diff_in_seconds <= 59">
                        il y a {{ item.diff_in_seconds }} s
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_minutes > 0 && item.diff_in_hours === 0">
                        il y a {{ item.diff_in_minutes }} min
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_hours > 0 && item.diff_in_days === 0">
                        il y a {{ item.diff_in_hours }} h
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_days > 0 && item.diff_in_weeks == 0">
                        il y a {{ item.diff_in_days }} j
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_months === 0 && item.diff_in_weeks > 0">
                        il y a {{ item.diff_in_weeks }} sem
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium"
                        v-if="item.diff_in_months > 0 && item.diff_in_years === 0">
                        il y a {{ item.diff_in_months }} m
                      </p>
                      <p class="text-[12px] text-gray-600 font-medium" v-if="item.diff_in_years > 0">
                        il y a {{ item.diff_in_years }} a
                      </p>
                    </div>
                  </div>
                  <div class="relative basis-[2%] mr-2">
                    <span class="cursor-pointer" @click="transitionFunctionOne((index + 10))">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                      </svg>
                    </span>
                    <transition>
                      <div :id="'index-' + (index + 10)"
                        class="allClick hidden w-[140px] absolute right-0 top-6 bg-gray-300 rounded">
                        <ul class="cursor-pointer">
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px]"
                            @click="enregistrerImage(item, (index + 10))">
                            Enrégistrer cette image
                          </li>
                          <li class="py-2 px-1.5 hover:bg-gray-200 text-[12px]" @click="deleteImage(item, (index + 10))"
                            v-if="item.user_id === $page.props.auth.user.id">
                            Supprimer l'image
                          </li>
                        </ul>
                      </div>
                    </transition>
                  </div>
                </div>
                <div class="mt-2">
                  <Link :href="route('postProfil', [item.idUser, item.id])">
                  <img :src="`/storage/profilImage/${item.file_profile}`" alt="image_de_profil"
                    class="w-full h-96 object-cover" />
                  </Link>
                </div>
                <div :class="item.likes > 0 ? '' : 'hidden'"
                  class="mt-[1px] px-1 cursor-pointer hover:bg-sky-100 border-gray-300 border-b-[1px] font-bold">
                  <span :id="'like-' + (index + 10)" v-if="item.trueVariable && item.likes > 1"
                    class="text-gray-600 text-[12px]">Vous et {{ item.likes - 1 }}
                    autre(s) personne(s) ont aimé cette
                    photo.</span>
                  <span :id="'like-' + (index + 10)" v-else-if="item.trueVariable && item.likes == 1"
                    class="text-gray-600 text-[12px]">Vous avez aimé cette
                    photo.</span>
                  <span :id="'like-' + (index + 10)" v-else-if="item.likes == 1" class="text-gray-600 text-[12px]">{{
                    item.likes
                  }}
                    personne a aimé cette
                    photo.</span>
                  <span :id="'like-' + (index + 10)" v-else class="text-gray-600 text-[12px]">{{ item.likes }}
                    personne(s) ont aimé
                    cette photo.</span>
                </div>
                <div class="mt-1 flex justify-between items-center w-[95%] mx-auto">
                  <span class="basis-[48%] flex justify-center p-1 cursor-pointer gap-2 items-center"
                    @click="clickLike(item, `${'like-' + (index + 10)}`)">
                    <span v-if="item.trueVariable === false" class="flex gap-2 items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="gray" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                      </svg>
                      <span class="text-gray-600 text-[12px] font-bold">{{ item.likes }} j'aime(s)</span>
                    </span>
                    <span v-else class="flex gap-2 items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="#0080FF" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="#0080FF" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                      </svg>
                      <span class="text-sky-500 text-[12px] font-bold">{{ item.likes }} j'aime(s)</span>
                    </span>
                  </span>
                  <Link class="basis-[48%] flex justify-center p-1 cursor-pointer gap-2 items-center"
                    :href="route('postProfil', [item.idUser, item.id])">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="gray"
                    class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                  </svg>
                  <span class="text-gray-600 text-[12px] font-bold">{{ item.comments }}
                    commentaire(s)</span>
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="bg-white mt-3 flex flex-col gap-y-4 items-center py-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="gray"
          class="w-10 h-10">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
        </svg>
        <p class="basis-full text-[12px] font-bold text-gray-700">Pas de contenu !</p>
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
  props: {
    follow: Array,
    getLastImgProfil: Array,
    mergesTab: Array,
    img: Array,
    statuts: Array,
    countStatus: Number,
  },

  data() {
    return {
      myTables: this.mergesTab,
      allStatus: this.statuts,
      userInformation: this.getLastImgProfil,
      friends: this.follow,

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
      selectColor: 0,
      colorArrayOne: [
        "bg-gradient-to-r from-cyan-500 to-blue-500",
        "bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500",
        "bg-green-500",
        "bg-gradient-to-t from-gray-700 to-lime-700",
        "bg-blue-500",
        "bg-red-500",
        "bg-gradient-to-r from-gray-700 to-lime-700",
        "bg-gradient-to-t from-gray-700 to-rose-400",
        "bg-gradient-to-t from-gray-700 to-rose-700",
        "bg-gradient-to-br from-gray-700 to-pink-400",
        "bg-sky-500",
        "bg-orange-500",
        "bg-orange-600",
        "bg-gradient-to-br from-gray-700 to-slate-400",
        "bg-gradient-to-br from-gray-700 to-sky-800",
        "bg-gradient-to-br from-gray-700 to-sky-400",
        "bg-gradient-to-br from-gray-700 to-fuchsia-400",
        "bg-gradient-to-br from-gray-700 to-rose-200",
        "bg-yellow-600",
        "bg-amber-600",
        "bg-pink-600",
      ], // TAbleau de couleur
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
      status: '',
      choice: true,
      chargement: false,
      chargementOne: false,
      loader: false,
      errorMsg: false,
      statModal: false,
      indexStatutImg: 0,
      elementIndexe: 0,
      indexe: 0,

      tableauImg: [],
    }
  },

  watch: {
    publish(newValue, oldValue) {
      if (newValue !== null) {
        if (newValue.trim().split(/\s+/).length >= 30) {
          this.selectedColorIndex = null;
          this.imageInput = true;
        } else if (this.nameImg !== null || photos.value !== '') {
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
    indexPrecedent() {
      this.indexe -= 1;
      if(this.indexe < 0)
      {
          this.indexe = 0;
          if(this.elementIndexe >= 1)
          {
          this.elementIndexe -= 1;
        } else {
          this.elementIndexe = this.countStatus - 1;
          this.indexe = this.allStatus[this.elementIndexe].length - 1;
        }
      }
    },

    indexSuivant() {
      this.indexe += 1;
      if(this.indexe === this.allStatus[this.elementIndexe].length)
      {
        this.indexe = 0;
        this.elementIndexe += 1;
        if(this.elementIndexe === this.countStatus)
        {
          this.indexe = 0;
          this.elementIndexe = 0;
        }
      }
    },

    cacheStatut() {
      this.chargementOne = false;
      this.indexe = 0;
      this.elementIndexe = 0;
    },

    openViewStatut(index) {
      this.chargementOne = !this.chargementOne;
      this.elementIndexe = index;
    },

    publishImgStatutFirst() {
      this.chargement = true;
      this.loader = true;
      axios.post(route("publishStatutFirst"), {
        contenu: this.status,
        select: this.colorArrayOne[this.selectColor]
      }).then(response => {
        if (!response.data.error) {
          window.location.href = window.location.href;
        } else {
          this.loader = false;
          this.errorMsg = response.data.error;
        }
      })
    },

    publishImgStatut() {
      this.chargement = true;
      this.loader = true;
      axios.post(route("publishStatut"), {
        tableau: this.tableauImg
      }).then(response => {
        if (!response.data.error) {
          window.location.href = window.location.href;
        } else {
          this.loader = false;
          this.errorMsg = response.data.error;
        }
      })
    },

    changeTextContenu() {
      this.tableauImg[this.indexStatutImg].contenu = contenuStatut.value;
    },

    closeImgStatut() {
      if (this.tableauImg.length > 1) {
        axios.delete(route("imgStatut", {
          tableau: this.tableauImg[this.indexStatutImg]
        })).then(response => {
          if (response.data.success) {
            this.tableauImg.splice(this.indexStatutImg, 1);
            this.indexStatutImg = 0;
          }
        })
      } else {
        this.openModalSt();
      }
    },

    chargeImgDeo(index) {
      this.indexStatutImg = index;
    },

    onChargementImag() {
      this.chargement = true;
      this.loader = true;

      let formData = new FormData();
      // Récupérer les fichiers sélectionnés
      let files = imageStatus.files;
      // Ajouter chaque fichier au FormData
      for (let i = 0; i < files.length; i++) {
        formData.append("myStatut[]", files[i]);
      }

      axios
        .post(route("statutImag"), formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          if (!response.data.error) {
            this.tableauImg = response.data.success;
            this.chargement = false;
            this.loader = false;
            this.errorMsg = false;
            this.choice = false;
          } else {
            this.loader = false;
            this.errorMsg = response.data.error;
          }
        });
    },

    selectColorStatus(index) {
      this.selectColor += 1;

      if (this.selectColor > (this.colorArrayOne.length - 1)) {
        this.selectColor = 0;
      }
    },

    openModalSt() {
      this.statModal = true;
    },

    closeStatus() {
      axios.delete(route("allImgSta", {
        statusImg: this.tableauImg
      })).then(response => {
        if (response.data.success) {
          // this.selectColor = 0;
          // this.status = '';
          // this.choice = true;
          // this.chargement = false;
          // this.loader = false;
          // this.errorMsg = false;
          // this.statModal = false;
          // this.indexStatutImg = 0;
          // this.tableauImg = [];

          // divStatus.classList.add("hidden");
          window.location.href = window.location.href;
        }
      })
    },

    openStatus() {
      divStatus.classList.remove("hidden");
    },

    // Fonction pour supprimer une image de profil
    // By KolaDev
    deleteImage(el, index) {
      document.getElementById(`index-${index}`).classList.add("hidden");
      axios
        .delete(
          route("deleteImageUser", {
            image: el,
          })
        )
        .then((response) => {
          if (response.data.success) {
            window.location.href = window.location.href;
          }
        });
    },

    enregistrerImage(el, index) {
      axios
        .get(
          route("enregistrerImage", {
            image: el,
          }),
          {
            responseType: "blob",
          }
        )
        .then((response) => {
          let url = window.URL.createObjectURL(
            new Blob([response.data], { type: "application/octet-stream" })
          );
          // Création d'un lien de téléchargement
          let link = document.createElement("a");
          link.href = url;
          // Ajout de l'attribut download avec pour nom de téléchargement el.file_profile
          link.setAttribute("download", el.file_profile);
          // Ajout du lien dans le body de la page
          document.body.appendChild(link);
          // Clique automatique du lien
          link.click();
          // Suppression du lien créé
          document.body.removeChild(link);
          document.getElementById(`index-${index}`).classList.add("hidden");
        });
    },

    transitionFunctionOne(index) {
      document.querySelectorAll(".allPosts").forEach(el => {
        el.classList.add("hidden");
      })
      document.querySelectorAll(".allClick").forEach(el => {
        if (el.id === `index-${index}`) {
          if (document.getElementById(`index-${index}`).className.includes("hidden")) {
            document.getElementById(`index-${index}`).classList.remove("hidden");
          } else {
            document.getElementById(`index-${index}`).classList.add("hidden");
          }
        } else {
          el.classList.add("hidden")
        }
      })
    },


    // Fonction pour supprimer une publication
    // By KolaDev
    deletePost(el, index) {
      document.getElementById(`posts-${index}`).classList.add("hidden");
      axios
        .delete(
          route("deletePost", {
            image: el,
          })
        )
        .then((response) => {
          if (response.data.success) {
            window.location.href = window.location.href;
          }
        });
    },

    // Fonction pour télécharger une image ou une vidéo d'un post
    // By KolaDev
    saveImage(el, index) {
      axios
        .get(
          route("enregistrerImage", {
            image: el,
          }),
          {
            responseType: "blob",
          }
        )
        .then((response) => {
          let url = window.URL.createObjectURL(
            new Blob([response.data], { type: "application/octet-stream" })
          );
          // Création d'un lien de téléchargement
          let link = document.createElement("a");
          link.href = url;
          // Ajout de l'attribut download avec pour nom de téléchargement nom
          let nom = el.image !== null ? el.image : el.video;
          link.setAttribute("download", nom);
          // Ajout du lien dans le body de la page
          document.body.appendChild(link);
          // Clique automatique du lien
          link.click();
          // Suppression du lien créé
          document.body.removeChild(link);
          document.getElementById(`posts-${index}`).classList.add("hidden");
        });
    },

    transitionFunction(index) {
      document.querySelectorAll(".allClick").forEach(el => {
        el.classList.add("hidden");
      })
      document.querySelectorAll(".allPosts").forEach(el => {
        if (el.id === `posts-${index}`) {
          if (document.getElementById(`posts-${index}`).className.includes("hidden")) {
            document.getElementById(`posts-${index}`).classList.remove("hidden");
          } else {
            document.getElementById(`posts-${index}`).classList.add("hidden");
          }
        } else {
          el.classList.add("hidden")
        }
      })
    },

    // Fonction pour suivre un utilisateur
    // By KolaDev
    followingAction(id, index) {
      axios.post(route("followingUser"), {
        id: id
      }).then(response => {
        if (response.data.success) {
          setTimeout(() => {
            this.friends.splice(index, 1);
          }, 1000)
        }
      })
    },

    // By KolaDev
    clickLike(el, element) {
      axios
        .post(route("addLikeFile"), {
          image: el,
        })
        .then((response) => {
          if (response.data.success) {
            this.alFil(el, element);
          }
        });
    },

    // By KolaDev
    alFil(el, element) {
      axios
        .post(route("allFilPro"), {
          table: el,
        })
        .then((response) => {
          if (response.data.success) {
            if (response.data.countLike > 0) {
              document.getElementById(`${element}`).parentElement.classList.remove("hidden");
            } else {
              document.getElementById(`${element}`).parentElement.classList.add("hidden");
            }
            document.getElementById(`${element}`).innerHTML = response.data.success;
            if (response.data.variableTrue) {
              document.getElementById(`${element}`).parentElement.nextElementSibling.children[0].children[0].innerHTML = `
                  <span class="flex gap-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#0080FF" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="#0080FF" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                    </svg>
                    <span class="text-sky-500 font-bold text-[12px]">${response.data.countLike} j'aime(s)</span>
                  </span>`
            } else {
              document.getElementById(`${element}`).parentElement.nextElementSibling.children[0].children[0].innerHTML = `
                  <span class="flex gap-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="gray" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                    </svg>
                    <span class="text-gray-600 text-[12px]">${response.data.countLike} j'aime(s)</span>
                  </span>`

            }
          }
        });
    },

    // By KolaDev
    clickLikePost(el, element) {
      axios
        .post(route("addLikePost"), {
          image: el,
        })
        .then((response) => {
          if (response.data.success) {
            this.alFilPost(el, element);
          }
        });
    },

    // By KolaDev
    alFilPost(el, element) {
      axios
        .post(route("allFilProPost"), {
          table: el,
        })
        .then((response) => {
          if (response.data.success) {
            if (response.data.countLike > 0) {
              document.getElementById(`${element}`).parentElement.classList.remove("hidden");
            } else {
              document.getElementById(`${element}`).parentElement.classList.add("hidden");
            }
            document.getElementById(`${element}`).innerHTML = response.data.success;
            if (response.data.variableTrue) {
              document.getElementById(`${element}`).parentElement.nextElementSibling.children[0].children[0].innerHTML = `
              <span class="flex gap-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#0080FF" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="#0080FF" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                </svg>
                <span class="text-sky-500 font-bold text-[12px]">${response.data.countLike} j'aime(s)</span>
              </span>`
            } else {
              document.getElementById(`${element}`).parentElement.nextElementSibling.children[0].children[0].innerHTML = `
              <span class="flex gap-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="gray" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                </svg>
                <span class="text-gray-600 text-[12px]">${response.data.countLike} j'aime(s)</span>
              </span>`

            }
          }
        });
    },

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
      if (this.nameImg !== null) {
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
      // window.location.href = `/postProfil/${user_id}/${id}`;
      console.log(user_id);
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
}</style>
