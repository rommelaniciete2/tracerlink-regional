<script setup lang="ts">
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import {
    Card,
    CardAction,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import BatchDeleteModal from '@/components/Batch/BatchDeleteModal.vue';
import BatchEditModal from '@/components/Batch/BatchEditModal.vue';
import course from '@/routes/course';

type Batch = {
    id: string;
    name: string;
};

const props = defineProps<{
    batchData: Batch;
}>();

const displayYear = computed(() => {
    const startYear = Number(props.batchData.name);

    if (!Number.isInteger(startYear)) {
        return props.batchData.name;
    }

    return `${startYear}-${startYear + 1}`;
});

const openCourses = () => {
    router.get(
        course.index.url({
            query: { batch: props.batchData.id },
        }),
    );
};
</script>

<template>
    <Card class="w-full cursor-pointer transition hover:border-primary/50" @click="openCourses">
        <CardHeader>
            <CardTitle>Batch</CardTitle>
            <CardDescription>Academic Year</CardDescription>
            <CardAction class="flex gap-2" @click.stop>
                <BatchEditModal :batch-data="batchData" />
                <BatchDeleteModal :batch-data="batchData" />
            </CardAction>
        </CardHeader>

        <CardContent>
            <div class="flex items-center justify-center py-1">
                <h2 class="text-2xl font-bold">{{ displayYear }}</h2>
            </div>
        </CardContent>
    </Card>
</template>
