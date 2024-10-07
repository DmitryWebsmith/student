<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Navigation Links -->
                            <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('student.dashboard')" :active="route().current('student.dashboard')">
                                    Кабинет
                                </NavLink>
                            </div>
                            <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('student.statistics')" :active="route().current('student.statistics')">
                                    Результаты
                                </NavLink>
                            </div>
                            <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <a
                                    class='inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
                                    target="_blank"
                                    href="https://textai.su/">
                                    Уроки с нейронкой
                                </a>
                            </div>
                            <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('logout')">
                                    Выход
                                </NavLink>
                            </div>
                        </div>
                    </div>
                </div>

            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
