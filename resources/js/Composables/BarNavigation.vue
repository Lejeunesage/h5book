<script setup>
import { Link } from '@inertiajs/vue3';
import DropdownLink from '@/Components/DropdownLink.vue';
</script>
 
<template>
    <footer class="headerBg py-4 fixed bottom-0 right-0 left-0 z-40">
        <div class="w-[75%] mx-auto flex justify-between">
            <Link :href="route('accueil')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            </Link>
            <Link :href="route('myActivity', $page.props.auth.user.id)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            </Link>
            <Link>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
            </svg>
            </Link>
            <Link>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg>
            </Link>
            <span class="cursor-pointer" @click="menuBar">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white"
                    class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                </svg>
            </span>
        </div>
    </footer>
    <div v-if="boolModal" class="fixed inset-0 top-[48px] bottom-[59px] flex items-center justify-end bg-gray-900 bg-opacity-80 z-50">
        <div class="div w-1/2 h-full overflow-hidden transform transition-transform bg-sky-100"
            :class="{ 'translate-x-0': boolModal, 'translate-x-full': !boolModal }">

            <ul class="flex gap-4 p-4 flex-col mt-6">
                <!-- <DropdownLink :href="route('myActivity', $page.props.auth.user.id)"
                    class="shadow px-1 border-sky-100 border rounded flex gap-1 items-center bg-[#0389c9] text-white text-[11px]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    Accueil
                </DropdownLink>
                <DropdownLink :href="route('myActivity', $page.props.auth.user.id)"
                    class="shadow px-1 border-sky-100 border rounded flex gap-1 items-center bg-[#0389c9] text-white text-[11px]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    Profile
                </DropdownLink>
                <DropdownLink :href="route('myActivity', $page.props.auth.user.id)"
                    class="shadow px-1 border-sky-100 border rounded flex gap-1 items-center bg-[#0389c9] text-white text-[11px]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    Messageries
                </DropdownLink> -->
                <DropdownLink :href="route('logout')" method="post" as="button"
                    class="absolute bottom-4 w-[87%] shadow px-1 border-sky-100 border rounded flex gap-1 items-center bg-[#0389c9] text-white">
                    <svg data-slot="icon" fill="none" width="16" stroke-width="1.5" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15">
                        </path>
                    </svg>
                    <p class="text-[14px]">Déconnexion</p>
                </DropdownLink>
                <li></li>
            </ul>
        </div>
    </div>
</template>

<script>
export default
    {
        data() {
            return {
                boolModal: false,
            }
        },

        methods: {
            closeModal() {
                this.boolModal = !this.boolModal;
            },

            menuBar() {
                this.boolModal = !this.boolModal;
            }
        }
    }

</script>

<style scope>
 
 .div {
  position: relative;
  animation-name: example;
  animation-duration: .3s;
  right: 0px;
  animation-timing-function: linear;
}

@keyframes example {
  0%   {right: -200px;}
  50%  {right: -100px;}
  100% {right: 0px;}
}

.color {
    color: #f8f9fa;
}


/* Ajoutez ces styles pour la transition du menu */
.transition-transform {
    transition: transform 0.3s ease-in-out;
}

.translate-x-0 {
    transform: translateX(0);
}

.translate-x-full {
    transform: translateX(100%);
}
</style>


