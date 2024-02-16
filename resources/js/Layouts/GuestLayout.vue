<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="bg-gradient flex flex-col justify-center min-h-[100%]">
        <div class="ml-5 flex justify-center">
            <Link href="/">
            <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div class="flex justify-center items-center gap-5 ">

            <div class="hidden lg:block font-bold  text-center  m-5">
                <img src="storage/images/persona_smal.png" alt="">
            </div>

            <div class="bg-white w-[600px] rounded-xl mx-5 ">

                <slot />
            </div>
        </div>
    </div>
</template>
<style>
.bg-gradient {
    background: linear-gradient(to bottom right, #0389c9, #029ae1, #0389c9, #4e565a);
    height: 100vh;
    /* Ajuste la hauteur selon tes besoins */
}
</style>
