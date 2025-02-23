<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import AdminNavLink from '@/Components/AdminNavLink.vue';
import { ref } from 'vue';
const sidebarOpen = ref(false); // Control the sidebar visibility

</script>

<template>
    <AdminAuthenticatedLayout>
        <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside
            :class="[
            'bg-white shadow-md fixed md:relative md:translate-x-0 transition-transform duration-300',
            sidebarOpen ? 'translate-x-0' : '-translate-x-full'
            ]"
            class="w-60 h-full z-30 md:block"
        >
            <nav class="mt-10">
            <ul>
                <li class="hover:bg-gray-200">
                    <AdminNavLink :href="route('studentCPanel')" :active="route().current('studentCPanel')">
                    <i class="fas fa-tasks mr-2"></i>
                    Student Access Controls
                    </AdminNavLink>
                </li>
                <li class="hover:bg-gray-200">
                    <AdminNavLink :href="route('class_controls')" :active="route().current('class_controls')">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Class Controls
                    </AdminNavLink>
                </li>
                <li class="hover:bg-gray-200">
                    <AdminNavLink :href="route('classfees')" :active="route().current('classfees')">
                    <i class="fas fa-tasks mr-2"></i>
                    Monthly Payments
                    </AdminNavLink>
                </li>
                <li class="hover:bg-gray-200">
                    <AdminNavLink :href="route('advancedFilters')" :active="route().current('advancedFilters')">
                    <i class="fas fa-tasks mr-2"></i>
                    Advanced Student Filters
                    </AdminNavLink>
                </li>
                <li class="hover:bg-gray-200">
                    <AdminNavLink :href="route('extraLessons')" :active="route().current('extraLessons')">
                    <i class="fas fa-tasks mr-2"></i>
                    Extra Lessons
                    </AdminNavLink>
                </li>
                <li class="hover:bg-gray-200">
                    <AdminNavLink :href="route('resourcespayments')" :active="route().current('resourcespayments')">
                    <i class="fas fa-tasks mr-2"></i>
                    Resource Payments
                    </AdminNavLink>
                </li>
                <li class="hover:bg-gray-200">
                    <AdminNavLink :href="route('resourceControls')" :active="route().current('resourceControls')">
                    <i class="fas fa-tasks mr-2"></i>
                    Resource Controls
                    </AdminNavLink>
                </li>
            </ul>
            </nav>
        </aside>
    
        <div class="flex-1 min-h-screen">
            <!-- Main Content -->
            <main>
                <slot />
            </main>
        </div>
        </div>
    </AdminAuthenticatedLayout>
</template>

  