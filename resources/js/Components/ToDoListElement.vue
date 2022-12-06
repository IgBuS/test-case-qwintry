<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    task: Object,
    statuses: Array,
});

const isVisible = ref(false)

const toggle = () => {
    isVisible.value = !isVisible.value
};


const completeForm = useForm({
    completed: props.task.completed,
    status_id: props.task.status_id,
});

const statusForm = useForm({
    status_id: props.task.status_id,
});

const deleteForm = useForm();


const deleteTask = () => {
    if (confirm("Are you sure you want to remove the item?")) {
        deleteForm.delete(route('tasks.destroy', props.task), {
        preserveScroll: true,
    });
    }
}


const doneTask = () => {
    completeForm
    .transform((data) => ({
        ...data,
        completed: !props.task.completed,
    }))
    .patch(route("tasks.update", props.task), {
        preserveScroll: true,
    });
    }

const moveTask = (status) => {
    statusForm
    .transform((data) => ({
        ...data,
        status_id: status.id,
    }))
    .patch(route("tasks.update", props.task), {
        preserveScroll: true,
    });
    }

</script>

<template>
    <a href="#" v-if="(props.task.completed)" class="line-through ..." @click="toggle">{{props.task.name}}</a>
    <a href="#" v-else @click="toggle">{{props.task.name}}</a>
        <div class="text-blue-600" v-if="isVisible" >
            <a href="#" @click="doneTask()">[{{props.task.completed ? "undone" : "done"}}] </a>
            <a href="#" @click="deleteTask()">[remove]</a>
            <template v-for="status in props.statuses">
                <div v-if="(status.id !== props.task.status_id)" >
                    <a href="#" @click="moveTask(status)">[move to {{status.name}}]</a>
                </div>
            </template>
        </div>
</template>
