<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ToDoListElement from '@/Components/ToDoListElement.vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    tasks: {
        type: Object,
        default: () => ({}),
    },
    statuses: Array,
    urgentLimit: Number,
});

const regular = computed( () => {
    if (!props.tasks.length) return []
        return props.tasks.filter( task => 
            props.statuses[task.status_id].name === 'regular'
        )
    });

const urgent = computed( () => {
    if (!props.tasks.length) return []
        return props.tasks.filter( task => 
            props.statuses[task.status_id].name === 'urgent'
        )
    });

const form = useForm({
    name: '',
});

const submit = () => {
    form.post(route('tasks.store'), {
        preserveScroll: true,
        onSuccess: () => form.name = '',
    });
};


</script>

<template>
    <app-layout title="Tasks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
        </template>
         <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <!-- All posts goes here -->
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div>
                                <div class="grid grid-flow-row grid-cols-3 gap-4">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <div class="flex items-center">
                                            <div class="p-2 ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                                <a>ToDos ({{ regular.length }})</a>
                                            </div>
                                        </div>
                                        <div class="ml-12 m-2">
                                            <div class="mt-2 text-sm text-gray-500">
                                                <ol class="list-disc">
                                                    <li v-for="task in regular" v-bind:key="task.id">
                                                        <ToDoListElement :task="task" :statuses="statuses"></ToDoListElement>
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                        <div class="ml-8 m-2">
                                            <form @submit.prevent="submit">
                                                <div>
                                                    <InputLabel for="name" value="Name" />
                                                    <TextInput
                                                        id="name"
                                                        v-model="form.name"
                                                        type="text"
                                                        class="mt-1 block w-full"
                                                        required
                                                        autofocus
                                                        autocomplete="name"
                                                    />
                                                    <InputError class="mt-2" :message="form.errors.name" />
                                                </div>

                                                <div class="flex items-center justify-end mt-4">
                                                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                        Create
                                                    </PrimaryButton>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <div class="flex items-center">
                                            <div class="p-2 ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                                <a>Urgent ToDos</a>
                                                <a :style="{ color: urgent.length > urgentLimit ? 'Red' : 'Black' }"> ({{ urgent.length }})</a>
                                            </div>
                                        </div>

                                        <div class="ml-12 m-2">
                                            <div class="mt-2 text-sm text-gray-500">
                                                <ol class="list-disc">
                                                    <li v-for="task in urgent" v-bind:key="task.id">
                                                        <ToDoListElement :task="task" :statuses="statuses"></ToDoListElement>
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>