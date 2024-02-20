<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <section class="bg-white">
        <div>
        </div>
        <div class="relative h-[200px] z-0">
            <img :src="couverture !== null ? `/storage/coverImage/${couverture}` : `/storage/images/account.png`"
                class="object-cover h-[200px] w-full" alt="image_de_couverture">
            <button v-if="$page.props.auth.user.id === usersIdentifiant.id"
                class="absolute text-[12px] top-4 right-4 bg-white border-none colorblue font-bold py-1.5 px-2 rounded-lg "
                @click="action">
                <svg class="w-5" data-slot="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true">
                    <path
                        d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM11.5 15.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z">
                    </path>
                </svg>
            </button>
            <transition>
                <div v-if="varBool1" class="absolute top-[50px] right-4 bg-white w-[170px] rounded z-40">
                    <ul>
                        <li class="py-2.5 px-2 border-gray-200 border-b-[1px] cursor-pointer">
                            <form>
                                <label class="text-gray-700 text-[12px] flex items-center gap-2" for="file"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" stroke="gray" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-image icon-font-light iw-16 ih-16">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>Choisir une photo</label>
                                <input type="file" id="file" class="hidden" @change="inputFile">
                            </form>
                        </li>
                        <li class="text-gray-700 text-[12px] flex items-center gap-2 py-2.5 px-2 cursor-pointer"
                            @click="deleteCover"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-trash-2 icon-font-light iw-16 ih-16">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                </path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>Supprimer la photo</li>
                    </ul>
                </div>
            </transition>
        </div>
        <div class="mt-[-70px] flex flex-col items-center gap-4 py-5 z-50">
            <div class="h-[110px] w-[110px] rounded-full border-white border-[6px] z-30">
                <div v-if="fileProfil === null"><img :src="`/storage/images/account.png`"
                        class="object-cover h-[100px] w-[100px] rounded-full" alt="image_de_profil"></div>
                <Link :href="route('postProfil', [usersIdentifiant.id, allImgs.id])" v-else><img
                    :src="`/storage/profilImage/${fileProfil}`" class="object-cover h-[100px] w-[100px] rounded-full"
                    alt="image_de_profil"></Link>
            </div>
            <div class="flex flex-col items-center mt-[-15px]">
                <h2 class="font-bold text-gray-600 text-[14px]">{{ usersIdentifiant.name }}</h2>
                <p class="text-[12px] text-gray-600">{{ usersIdentifiant.email }}</p>
            </div>
            <div class="flex gap-4 mt-[-10px]">
                <div class="flex items-center gap-1 px-4">
                    <p class="font-bold">{{ followin }}</p>
                    <Link :href="route('abonnements', usersIdentifiant.uuid)" class="mt-[1px] text-[13px] text-gray-500">
                    Abonnement(s)</Link>
                </div>
                <div class="flex items-center gap-1 px-4">
                    <p class="font-bold">{{ followe }}</p>
                    <Link :href="route('abonnees', usersIdentifiant.uuid)" class="mt-[1px] text-[13px] text-gray-500">
                    Abonné(s)
                    </Link>
                </div>
            </div>
            <div class="mt-[-5px]">
                <button @click="openModal" v-if="$page.props.auth.user.id === usersIdentifiant.id"
                    class="headerBg rounded-lg color py-1.5 px-3 hover:bg-[#f8f9fa] hover:text-sky-500 font-bold hover:border-sky-500 border-[1px] text-[12px]">Modifier
                    votre profil</button>
            </div>
            <div class="mt-[-10px] flex flex-start w-[90%] mx-auto gap-2"
                v-if="$page.props.auth.user.id !== usersIdentifiant.id">
                <button v-if="liee.length === 0" @click="followPerson(usersIdentifiant.id)"
                    class="headerBg rounded-lg w-[35%] color py-1.5 px-3 hover:bg-[#f8f9fa] hover:text-sky-500 font-bold hover:border-sky-500 border-[1px] text-[12px]">Suivre</button>
                <button v-else-if="liee.length > 0" @click="unFollowPerson(liee[0].user_id)"
                    class="bg-[#fc6949] rounded-lg w-[35%] color py-1.5 px-3 hover:bg-[#f8f9fa] hover:text-sky-500 font-bold hover:border-sky-500 border-[1px] text-[12px]">Ne
                    plus suivre</button>
                <button
                    class="bg-sky-200 text-gray-700 rounded-lg w-[62%] py-1.5 px-3  border-[1px] text-[12px] flex items-center justify-center gap-x-1"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                    </svg>
                    <span>Envoyer un message</span></button>
            </div>
        </div>
    </section>
    <div class="bg-white px-2 py-4 mt-[13px]">
        <div class="flex gap-1 items-center mx-auto w-[97%] flex-wrap">
            <Link :href="route('about', usersIdentifiant.uuid)"
                :class="niveau === 'about' ? 'basis-[30%] flex justify-center items-center gap-2 bg-sky-100 py-1 px-2 rounded text-[12px] text-sky-800' : 'basis-[30%] flex justify-center items-center gap-2 bg-sky-100 py-1 px-2 rounded text-[12px]'">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-info iw-14 ih-14">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>A propos</Link>
            <Link :href="route('showImage', usersIdentifiant.id)"
                :class="niveau === 'photos' ? 'basis-[30%] flex justify-center items-center gap-2 bg-sky-100 py-1 px-2 rounded text-[12px] text-sky-800' : 'basis-[30%] flex justify-center items-center gap-2 bg-sky-100 py-1 px-2 rounded text-[12px]'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            Photos</Link>
            <Link v-if="$page.props.auth.user.id === usersIdentifiant.id" :href="route('myActivity', usersIdentifiant.id)"
                :class="niveau === 'activity' ? 'basis-[35%] flex justify-center items-center gap-2 bg-sky-100 py-1 px-2 rounded text-[12px] text-sky-800' : 'basis-[35%] flex justify-center items-center gap-2 bg-sky-100 py-1 px-2 rounded text-[12px]'">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-list iw-14 ih-14">
                <line x1="8" y1="6" x2="21" y2="6"></line>
                <line x1="8" y1="12" x2="21" y2="12"></line>
                <line x1="8" y1="18" x2="21" y2="18"></line>
                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                <line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>Votre journal</Link>
            <Link v-else :href="route('myActivity', usersIdentifiant.id)"
                :class="niveau === 'activity' ? 'basis-[35%] flex justify-center items-center gap-2 bg-sky-100 py-1 px-2 rounded text-[12px] text-sky-800' : 'basis-[35%] flex justify-center items-center gap-2 bg-sky-100 py-1 px-2 rounded text-[12px]'">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-list iw-14 ih-14">
                <line x1="8" y1="6" x2="21" y2="6"></line>
                <line x1="8" y1="12" x2="21" y2="12"></line>
                <line x1="8" y1="18" x2="21" y2="18"></line>
                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                <line x1="3" y1="18" x2="3.01" y2="18"></line>
            </svg>Son journal</Link>
        </div>
    </div>

    <div v-if="variable" class="w-full h-full bg-gray-900 bg-opacity-80 top-0 fixed sticky-0 z-50" @click="closeModal">
    </div>
    <transition>
        <div v-if="variable" class="fixed top-0 bg-white h-full overflow-y-auto w-full z-50">
            <div class="relative">
                <h4 class="border-gray-300 border-b-[1px] text-gray-600 text-[13px] font-bold py-6 px-3.5">Modifier vos
                    informations
                </h4>
                <span class="cursor-pointer absolute top-[25px] right-[10px] border-gray-300 border-[1px] bg-gray-300"
                    @click="closeModal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="black" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </span>
            </div>
            <section class="w-[90%] mx-auto">
                <div class="flex items-center gap-2 py-3 border-gray-300 border-b-[1px]">
                    <span class="bg-sky-100 rounded p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="gray" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-image iw-16 ih-16">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                    </span>
                    <p class="text-[13px] text-gray-600">Modifier votre photo de profil</p>
                </div>
                <div class="flex items-center gap-2 py-2.5 w-[88%] mx-auto">
                    <img :src="fileProfil === null ? `/storage/images/account.png` : `/storage/profilImage/${fileProfil}`"
                        class="object-cover h-[40px] w-[40px] rounded-lg" alt="image_de_profil">
                    <p class="text-[12px] text-sky-600 cursor-pointer font-bold" @click="chooseFile">Modifier la photo</p>
                </div>
            </section>

            <section class="mb-20">
                <form class="w-[90%] mx-auto mt-4 flex flex-col gap-y-6" @submit.prevent="saveInformation">
                    <div class="flex flex-col gap-y-2">
                        <h4 class="font-bold text-[13px] border-gray-300 border-b-[1px] text-gray-700 pb-2">Ma bibliographie
                        </h4>
                        <div class="flex items-center justify-between gap-1">
                            <div class="bg-sky-100 p-2.5 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="gray"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-user iw-18 ih-18 w-4 h-4">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="basis-[85%]">
                                <textarea v-model="bibliography"
                                    class="text-[12px] max-h-[55px] w-full focus:ring-0 focus:ring-transparent border-x-[0px] border-t-[0px] border-gray-300 border-b-[1px] overflow-y-auto px-1"
                                    placeholder="Ma bibliographie">{{ information.bibliography }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <h4 class="font-bold text-[13px] border-gray-300 border-b-[1px] text-gray-700 pb-2">Ma date de
                            naissance
                        </h4>
                        <div class="flex items-center justify-between gap-1">
                            <div class="bg-sky-100 p-2.5 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="gray" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-1.5.75a3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0L3 16.5m15-3.379a48.474 48.474 0 0 0-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 0 1 3 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 0 1 6 13.12M12.265 3.11a.375.375 0 1 1-.53 0L12 2.845l.265.265Zm-3 0a.375.375 0 1 1-.53 0L9 2.845l.265.265Zm6 0a.375.375 0 1 1-.53 0L15 2.845l.265.265Z" />
                                </svg>
                            </div>
                            <div class="basis-[85%]">
                                <input
                                    class="text-[12px] w-full focus:ring-0 focus:ring-transparent border-x-[0px] border-t-[0px] border-gray-300 border-b-[1px] overflow-y-auto px-1"
                                    type="date" v-model="date">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <h4 class="font-bold text-[13px] border-gray-300 border-b-[1px] text-gray-700 pb-2">Mon adresse
                            électronique
                        </h4>
                        <div class="flex items-center justify-between gap-1">
                            <div class="bg-sky-100 p-2.5 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="gray" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <div class="basis-[85%]">
                                <input type="email" required
                                    class="text-[12px] w-full focus:ring-0 focus:ring-transparent border-x-[0px] border-t-[0px] border-gray-300 border-b-[1px] overflow-y-auto px-1"
                                    placeholder="Mon adresse électronique" v-model="email">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <h4 class="font-bold text-[13px] border-gray-300 border-b-[1px] text-gray-700 pb-2">Mon sexe
                        </h4>
                        <div class="flex items-center justify-between gap-1">
                            <div class="bg-sky-100 p-2.5 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="gray"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-user iw-18 ih-18 w-4 h-4">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="basis-[85%] flex justify-between">
                                <label for="masculin"
                                    class="border-gray-200 border-[1px] text-[13px] p-2 flex justify-between items-center rounded bg-sky-100 basis-[45%]">Masculin
                                    : <input type="radio" id="masculin" name="sexe"
                                        :checked="sexe === 'M' ? true : false"></label>
                                <label for="feminin"
                                    class="border-gray-200 border-[1px] text-[13px] p-2 flex justify-between items-center rounded bg-sky-100 basis-[45%]">Féminin
                                    : <input type="radio" id="feminin" name="sexe"
                                        :checked="sexe === 'F' ? true : false"></label>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <h4 class="font-bold text-[13px] border-gray-300 border-b-[1px] text-gray-700 pb-2">Mon pays
                        </h4>
                        <div class="flex items-center justify-between gap-1">
                            <div class="bg-sky-100 p-2.5 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="gray" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                </svg>
                            </div>
                            <div class="basis-[85%]">
                                <input
                                    class="text-[12px] w-full focus:ring-0 focus:ring-transparent border-x-[0px] border-t-[0px] border-gray-300 border-b-[1px] overflow-y-auto px-1"
                                    placeholder="Mon pays" v-model="namePays" list="listPays">
                                <datalist id="listPays">
                                    <option :value="el.name_pays" v-for="(el, index) in pays">{{ el.name_pays }}</option>
                                </datalist>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <h4 class="font-bold text-[13px] border-gray-300 border-b-[1px] text-gray-700 pb-2">Votre numéro de
                            téléphone
                        </h4>
                        <div class="flex items-center justify-between gap-1">
                            <div class="bg-sky-100 p-2.5 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="gray" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                            </div>
                            <div class="basis-[85%]">
                                <input
                                    class="text-[12px] w-full focus:ring-0 focus:ring-transparent border-x-[0px] border-t-[0px] border-gray-300 border-b-[1px] overflow-y-auto px-1"
                                    placeholder="Mon numéro de téléphone" v-model="phone" type="number">
                            </div>
                        </div>
                    </div>
                    <div id="errorMsg" class="flex justify-center items-center hidden">
                    </div>
                    <div class="flex justify-end">
                        <button class="text-[12px] bg-sky-600 text-white font-bold py-2 px-3.5 rounded-lg">Sauvegarder ces
                            informations</button>
                    </div>
                </form>
            </section>
        </div>
    </transition>

    <div v-if="variable1" class="w-full h-full bg-gray-900 bg-opacity-80 top-0 fixed sticky-0 z-50" @click="closeModal">
    </div>
    <div v-if="variable1" class="fixed top-0 bg-white h-full w-full z-50">
        <div class="relative">
            <h4 class="border-gray-300 border-b-[1px] text-gray-600 text-sm font-bold py-6 px-3.5">Choisir une photo
            </h4>
            <span class="cursor-pointer absolute top-[25px] right-[10px] border-gray-300 border-[1px] bg-gray-300"
                @click="closeModal1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black"
                    class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </span>
        </div>
        <section class="w-[90%] mx-auto">
            <form @submit.prevent="upload" class="relative h-full">
                <input v-if="nameImg === null" type="file" id="profilFile" @change="imageProfil"
                    class="w-full mt-4 cursor-pointer py-1.5 border-gray-300 border-[1px] rounded-lg px-2" required>

                <div id="loaders" class="hidden flex my-2 justify-center"><span class="loader"></span></div>
                <div id="paragraphs"
                    class="hidden flex my-4 justify-center font-bold bg-red-200 text-[14px] p-1 rounded text-red-500"></div>

                <div v-if="nameImg" class="mt-4 shadow-2xl border rounded-lg py-4 px-2">
                    <div class="font-bold text-gray-600 text-[12px]">Rendu de l'image</div>
                    <div class="relative mt-2">
                        <img :src="`/storage/profilImage/${nameImg}`" class="object-cover h-[250px] w-full rounded-lg"
                            alt="image_de_profil">
                        <span
                            class="cursor-pointer absolute top-[5px] right-[5px] border-gray-300 border-[1px] bg-gray-300 rounded-full p-1"
                            @click="closeVisual">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="black" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div
                    class="fixed left-0 bottom-14 right-0 flex justify-end items-center border-gray-300 border-t-[1px] py-4 px-3.5">
                    <button class="bg-sky-600 text-white text-[12px] font-bold py-2 px-3.5 rounded-lg">Charger l'image
                    </button>
                </div>
            </form>

        </section>
    </div>
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
        niveau: String,
        followin: Number,
        followe: Number,
        numberLik: Number,
        covers: String,
        filesProfil: String,
        lastImage: Array,
        usersIdentifiant: Array,
        allImg: Array,
        lier: Array,
        information: Array,
        pays: Array,
    },
    data() {
        return {
            varBool1: false,
            couverture: this.covers,
            lastImg: this.lastImage,
            variable: false,
            variable1: false,
            nameImg: null,
            fileProfil: this.filesProfil,
            allImgs: this.allImg,
            liee: this.lier,
            email: this.information.email,
            bibliography: this.information.bibliography ?? '',
            sexe: this.information.gender ?? '',
            namePays: this.information.name_pays ?? '',
            phone: this.information.phone_number ?? '',
            date: this.information.date_of_birth,
        }
    },

    methods: {
        /**
         * Fonction pour sauvegarder les informations de l'utilisateur
         * By KolaDev
         */
        saveInformation() {
            errorMsg.classList.add("hidden");
            let tabPays = {};
            if (this.phone !== '' && this.namePays.trim() === '') {
                errorMsg.classList.remove("hidden");
                errorMsg.innerHTML = `<p class="text-[12px] text-red-500 bg-red-200 font-bold p-1.5 rounded-lg text-center w-full">Vous devez précisez le pays !</p>`;
            } else {
                if (masculin.checked) {
                    this.sexe = 'M';
                }

                if (feminin.checked) {
                    this.sexe = 'F';
                }

                if (this.namePays.trim() !== '') {
                    this.pays.forEach(el => {
                        if (el.name_pays === this.namePays) {
                            tabPays = el;
                        }
                    })
                }

                axios.post(route("saveInfoUser"), {
                    bibliography: this.bibliography,
                    tableauPays: tabPays,
                    sexe: this.sexe,
                    phone: this.phone,
                    date: this.date,
                    email: this.email

                }).then(response => {
                    if (response.data.success) {
                        window.location.href = window.location.href;
                    } else {
                        errorMsg.classList.remove("hidden");
                        errorMsg.innerHTML = `<p class="text-[12px] text-red-500 bg-red-200 font-bold p-1.5 rounded-lg text-center w-full">${response.data.error}</p>`;
                    }
                })
            }


        },

        // Fonction pour suivre un utilisateur
        // By KolaDev
        followPerson(id) {
            axios.post(route("followingUser"), {
                id: id
            }).then(response => {
                if (response.data.success) {
                    window.location.href = window.location.href;
                }
            })
        },

        // Fonction pour se désabonner d'un utilisateur
        // By KolaDev
        unFollowPerson(id) {
            axios.delete(route("unsubscribe", {
                id: id
            })).then(response => {
                if (response.data.success) {
                    window.location.href = window.location.href;
                }
            })
        },

        // Fonction pour afficher toutes les actions que l'utilisateur peut mener sur l'image de sa couverture
        action() {
            this.varBool1 = !this.varBool1;
        },

        // Fonction charger l'image de couverture
        // By KolaDev
        inputFile() {
            let myDataFile = file.files[0];
            let formData = new FormData();
            formData.append("myCover", myDataFile);
            axios.post(route("galleryUser.storeCover"), formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            }).then(response => {
                if (response.data.success) {
                    this.lastImgCover();
                }
            })
            this.varBool1 = !this.varBool1;
        },

        // Fonction pour récupérer la dernière image de couverture de l'utilisateur
        lastImgCover() {
            axios.get(route("lastImgCover")).then(response => {
                this.couverture = response.data.cover;
                this.lastImg = response.data.getLastImg;
                this.fileProfil = response.data.profil;
                this.allImgs = response.data.getLastImgProfil;
            })
        },

        // Fonction pour supprimer l'image de couverture
        // By KolaDev
        deleteCover() {
            this.varBool1 = !this.varBool1;
            axios.delete(route("deleteCover", {
                tableau: this.lastImg
            })).then(response => {
                if (response.data.success) {
                    this.lastImgCover();
                }
            })
        },

        // Fonction pour afficher le modal
        // By KolaDev
        openModal() {
            this.variable = !this.variable;
        },

        // Fonction pour cacher le modal
        // By KolaDev
        closeModal() {
            errorMsg.classList.add("hidden");
            this.variable = false;
        },

        // Fonction pour afficher le modal de chargement d'image
        // By KolaDev
        chooseFile() {
            this.variable = !this.variable;
            this.variable1 = !this.variable1;
        },

        // Fonction pour fermer le modal de chargement d'image
        // By KolaDev
        closeModal1() {
            paragraphs.classList.remove("hidden");
            paragraphs.innerHTML = '';
            this.variable1 = false;
            if (this.nameImg) {
                this.closeVisual();
            }
        },

        // Fonction pour ajouter l'image dans la bdd
        // By KolaDev
        upload() {
            axios.post(route("uploadImgUser", {
                nameImg: this.nameImg
            })).then(response => {
                if (response.data.success) {
                    this.nameImg = null;
                    this.variable = !this.variable;
                    this.variable1 = !this.variable1;
                    this.lastImgCover();
                }
            })
        },

        // Fonction pour charger l'image
        // By KolaDev
        imageProfil() {
            loaders.classList.remove("hidden");
            let myDataFile = profilFile.files[0];
            let formData = new FormData();
            formData.append("myPicture", myDataFile);
            axios.post(route("galleryUser.store"), formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            }).then(response => {
                loaders.classList.add("hidden");
                if (response.data.success) {
                    paragraphs.classList.add("hidden");
                    paragraphs.innerHTML = '';
                    profilFile.value = null;
                    this.nameImg = response.data.nameImg;
                } else {
                    paragraphs.classList.remove("hidden");
                    paragraphs.innerHTML = response.data.error;
                }
            })
        },

        // Fonction pour supprimer l'image
        // By KolaDev
        closeVisual() {
            axios.delete(route("deleteImage", {
                nameImg: this.nameImg
            })).then(response => {
                if (response.data.success) {
                    this.nameImg = null;
                }
            })
        }
    }
}

</script>

<style scope>
body {
    background-color: #e4e7e9e5;
}

.bgColor {
    background-color: #f8f9fa;
}

.colorblue {
    color: #0389c9
}

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