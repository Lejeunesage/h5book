<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ComposantUser from '@/Composables/UserComposant.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="A propos" />
    <AuthenticatedLayout>
        <main class="mt-[-20px]">
            <ComposantUser :niveau="'about'" :filesProfil="imageProfil" :covers="couverture" :lastImage="thisImage"
                :followin="userfollow" :followe="followers" :usersIdentifiant="users" :numberLik="numberLike"
                :allImg="getLastImgProfil" :lier="liaison" :information="informationPerson" :pays="allPays" />

            <section class="mt-4 mb-16 bg-white max-w-[90%] m-auto rounded">
                <div class="flex items-center justify-between py-3.5 px-5 border-b-[1px]">
                    <h2>
                        <span class="text-[14px] font-bold">A propos de </span>
                        <span class="text-[13px] font-medium text-gray-700"
                            v-if="$page.props.auth.user.id === users.id">vous</span>
                        <span class="text-[13px] font-medium text-gray-700" v-else>{{ users.name }}</span>
                    </h2>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center justify-between gap-6 px-5 py-4">
                        <div class="bg-sky-100 p-2.5 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="gray"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-user iw-18 ih-18 w-4 h-4">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <div class="basis-[85%]">
                            <h4 class="font-bold text-[13px]" v-if="$page.props.auth.user.id === users.id">Ma bibliographie
                            </h4>
                            <h4 class="font-bold text-[13px]" v-else>Sa bibliographie</h4>
                            <p class="text-[12px] max-h-[50px] overflow-y-auto" v-if="users.bibliography !== null"
                                v-html="users.bibliography"></p>
                            <p class="text-[12px] max-h-[250px] overflow-y-auto" v-else>Pas disponible !</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-6 px-5 py-4">
                        <div class="bg-sky-100 p-2.5 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="gray" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-1.5.75a3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0L3 16.5m15-3.379a48.474 48.474 0 0 0-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 0 1 3 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 0 1 6 13.12M12.265 3.11a.375.375 0 1 1-.53 0L12 2.845l.265.265Zm-3 0a.375.375 0 1 1-.53 0L9 2.845l.265.265Zm6 0a.375.375 0 1 1-.53 0L15 2.845l.265.265Z" />
                            </svg>
                        </div>
                        <div class="basis-[85%]">
                            <h4 class="font-bold text-[13px]" v-if="$page.props.auth.user.id === users.id">Votre date
                                d'anniversaire</h4>
                            <h4 class="font-bold text-[13px]" v-else>Sa date d'anniversaire</h4>
                            <p class="text-[12px]" v-if="users.date_of_birth !== null">Le {{ users.date_of_birth }}</p>
                            <p class="text-[12px]" v-else>Pas disponible !</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-6 px-5 py-4">
                        <div class="bg-sky-100 p-2.5 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="gray" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>
                        </div>
                        <div class="basis-[85%]">
                            <h4 class="font-bold text-[13px]" v-if="$page.props.auth.user.id === users.id">Votre pays</h4>
                            <h4 class="font-bold text-[13px]" v-else>Son pays</h4>
                            <p class="text-[12px]" v-if="informationPerson.name_pays !== null">{{ informationPerson.name_pays }}</p>
                            <p class="text-[12px]" v-else>Pas disponible !</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-6 px-5 py-4">
                        <div class="bg-sky-100 p-2.5 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="gray" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                        </div>
                        <div class="basis-[85%]">
                            <h4 class="font-bold text-[13px]" v-if="$page.props.auth.user.id === users.id">Votre numéro de
                                téléphone</h4>
                            <h4 class="font-bold text-[13px]" v-else>Son numéro de téléphone</h4>
                            <p class="text-[12px]" v-if="users.phone_number !== null">{{ informationPerson.country_code }} {{ users.phone_number }}</p>
                            <p class="text-[12px]" v-else>Pas disponible !</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-6 px-5 py-4">
                        <div class="bg-sky-100 p-2.5 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="gray"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-user iw-18 ih-18 w-4 h-4">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <div class="basis-[85%]">
                            <h4 class="font-bold text-[13px]" v-if="$page.props.auth.user.id === users.id">Votre sexe</h4>
                            <h4 class="font-bold text-[13px]" v-else>Son sexe</h4>
                            <p class="text-[12px]" v-if="users.gender !== null">
                                <span v-if="user.gender === 'M'">Masculin</span>
                                <span v-else-if="user.gender === 'F'">Féminin</span>
                            </p>
                            <p class="text-[12px]" v-else>Pas disponible !</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-6 px-5 py-4">
                        <div class="bg-sky-100 p-2.5 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="gray" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <div class="basis-[85%]">
                            <h4 class="font-bold text-[13px]" v-if="$page.props.auth.user.id === users.id">Votre adresse
                                électronique</h4>
                            <h4 class="font-bold text-[13px]" v-else>Son adresse électronique</h4>
                            <p class="text-[12px]" v-if="users.email !== null">
                                {{ users.email }}
                            </p>
                            <p class="text-[12px]" v-else>Pas disponible !</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-6 px-5 py-4">
                        <div class="bg-sky-100 p-2.5 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="gray" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                            </svg>
                        </div>
                        <div class="basis-[85%]">
                            <h4 class="font-bold text-[13px]">Inscrit</h4>
                            <p class="text-[12px]">
                               Depuis le {{ users.created_at.split("T")[0] }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
        following: Number,
        countLike: Number,
        follower: Number,
        cover: String,
        lImg: Array,
        profil: String,
        getLastImgProfil: Array,
        user: Array,
        liaison: Array,
        informationPerson: Array,
        allPays: Array,
    },

    data() {
        return {
            varBool: false,
            users: this.user,
            userfollow: this.following,
            followers: this.follower,
            numberLike: this.countLike,
            couverture: this.cover,
            imageProfil: this.profil,
            thisImage: this.lImg,
            changevar: false,
        }
    },

    methods: {
        editInfo()
        {
            this.changevar = true;
        },

        // Fonction pour afficher tous les amis de l'utilisateur connecté
        friend() {
            suggest.classList.remove("text-sky-600");
            suggest.classList.add("text-gray-600");
            amis.classList.remove("text-gray-600");
            amis.classList.add("text-sky-600");
            divAmis.classList.remove("hidden");
            divSuggest.classList.add("hidden");
        },

        // Fonction pour suggérer des amis à l'utilisateur connecté
        suggest() {
            amis.classList.remove("text-sky-600");
            amis.classList.add("text-gray-600");
            suggest.classList.remove("text-gray-600");
            suggest.classList.add("text-sky-600");
            divAmis.classList.add("hidden");
            divSuggest.classList.remove("hidden");
        },
    }
}

</script>