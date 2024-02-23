
<script setup>
import Icon from "@/Components/Icons/Icon.vue";
import { Head, Link } from "@inertiajs/vue3";

</script>
<template>
    <header class="headerBg py-2.5 sticky top-0 z-50">
        <div class="mx-auto w-[90%] flex justify-between items-center">
            <Link :href="route('accueil')" class="basis-[70%] flex items-center gap-">
                <Icon name="logo_bleu" />
            </Link>
            
            <div class="flex gap-4 basis-[10%]">
                <div class="flex items-center gap-2">
                    <!-- Utilisez un bouton pour l'icône de la loupe -->
                    <button @click="toggleSearch" class="focus:outline-none">
    
                        <div v-if="!bool">
                            <svg  class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        </div>
    
                        <div v-if="bool">
                            <svg  data-slot="icon" width="25" fill="white" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path
                                d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z">
                            </path>
                        </svg>
                        </div>
    
                    </button>
    
                    <!-- Input avec v-if pour le rendre visible ou non -->
                    <input v-if="bool" type="text"
                        class=" headerBg py-1 rounded-lg placeholder:text-white placeholder:text-sm outline-none border-white focus:border-white focus:border-sky-600 color"
                        placeholder="Recherchez un proche...">
                </div>
    
                <div class="basis-[5%] " :style="{ display: bool ? 'none' : 'flex' }">
                    <ul class="flex gap-5 justify-end items-center">
                        <li v-if="dark" @click="darkMode">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="cursor-pointer feather feather-sun icon-light stroke-width-3 iw-16 ih-16">
                                <circle cx="12" cy="12" r="5"></circle>
                                <line x1="12" y1="1" x2="12" y2="3"></line>
                                <line x1="12" y1="21" x2="12" y2="23"></line>
                                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                                <line x1="1" y1="12" x2="3" y2="12"></line>
                                <line x1="21" y1="12" x2="23" y2="12"></line>
                                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                            </svg>
                        </li>
                        <li v-else @click="darkMode">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="cursor-pointer feather feather-moon icon-light stroke-width-3 iw-16 ih-16">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                            </svg>
                        </li>
                        <!-- <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="cursor-pointer feather feather-grid icon-light stroke-width-3 iw-16 ih-16">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </li> -->
                    </ul>
                </div>
</div>
        </div>
    </header>
</template>

<script>
export default {
    data() {
        return {
            bool: false,
            dark: false
        };
    },
    methods: {
        toggleSearch() {
            this.bool = !this.bool;
        },

        darkMode() {
            this.dark = !this.dark;
        }
    }
};
</script>

<style scope>
.color {
    color: #f8f9fa;
}

.headerBg {
    background-color: #0389c9;
}</style>
