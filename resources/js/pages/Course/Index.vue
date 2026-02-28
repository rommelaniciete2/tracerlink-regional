<script setup lang="ts">
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import CreateModal from '@/components/Course/CreateModal.vue';
import CourseCard from '@/components/Course/CourseCard.vue';
import batch from '@/routes/batch';
import course from '@/routes/course';
import { BreadcrumbItem } from '@/types';

type Batch = {
    id: string;
    name: string;
};

type Course = {
    id: number;
    name: string;
    batch_id: string;
};

const props = defineProps<{
    batches: Batch[];
    selectedBatchId: string | null;
    courses: Course[];
}>();

const selectedBatch = computed(() =>
    props.batches.find((batch) => batch.id === props.selectedBatchId),
);

const selectedBatchYear = computed(() => {
    if (!selectedBatch.value) {
        return '';
    }

    const startYear = Number(selectedBatch.value.name);

    if (!Number.isInteger(startYear)) {
        return selectedBatch.value.name;
    }

    return `${startYear}-${startYear + 1}`;
});

const formatBatchYear = (value: string) => {
    const startYear = Number(value);

    if (!Number.isInteger(startYear)) {
        return value;
    }

    return `${startYear}-${startYear + 1}`;
};

const onBatchChange = (event: Event) => {
    const target = event.target as HTMLSelectElement;
    const batchId = target.value;

    if (!batchId) {
        router.get(course.index.url(), {}, { preserveScroll: true });
        return;
    }

    router.get(
        course.index.url({
            query: { batch: batchId },
        }),
        {},
        { preserveScroll: true },
    );
};

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    {
        title: 'Batch',
        href: batch.index(),
    },
    {
        title: selectedBatch.value?.name || 'Batch',
        href: '',
    },
]);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 p-4">
            <div class="flex flex-col gap-3 sm:flex-row  lg:justify-end">
                <div class="flex items-center gap-3">
                    <CreateModal :selected-batch-id="selectedBatchId" />
                </div>
            </div>

            <div class="grid gap-4 lg:grid-cols-3">
                <CourseCard
                    v-for="courseItem in courses"
                    :key="courseItem.id"
                    :course-data="courseItem"
                    :selected-batch-id="selectedBatchId"
                />
            </div>

            <p v-if="courses.length === 0" class="text-sm text-muted-foreground flex justify-center">
                No programs in this batch yet.
            </p>
        </div>
    </AppLayout>
</template>
