<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <ApplicationLogo class="block h-12 w-auto" />
            </div>

            <div class="mt-8 text-2xl">
                Welcome to your ToDo list!
            </div>

            <div class="mt-6 text-gray-500">
                It is an extremely simple to-do list for you to not forget about important stuff. Create new items, mark them done and undone,
                move items to another list and back. Finally, you can remove items whenever you want. Enjoy!
            </div>
        </div>

    </div>
</template>
