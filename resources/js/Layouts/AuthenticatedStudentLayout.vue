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
