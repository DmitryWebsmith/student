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
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
<!--                            <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">-->
<!--                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">-->
<!--                                    Дэшбоард-->
<!--                                </NavLink>-->
<!--                            </div>-->
                            <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('groups')" :active="route().current('groups')">
                                    Классы
                                </NavLink>
                            </div>
                            <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('categories')" :active="route().current('categories')">
                                    Категории
                                </NavLink>
                            </div>
                            <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('tests')" :active="route().current('tests')">
                                    Тесты
                                </NavLink>
                            </div>
                            <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('tasks')" :active="route().current('tasks')">
                                    Задачи
                                </NavLink>
                            </div>
                            <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('statistics')" :active="route().current('statistics')">
                                    Результаты
                                </NavLink>
                            </div>
                            <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('profile.edit')" :active="route().current('profile')">
                                    Профиль
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
