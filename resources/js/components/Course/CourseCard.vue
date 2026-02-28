<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import {
    Card,
    CardAction,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import DeleteModal from '@/components/Course/DeleteModal.vue';
import EditModal from '@/components/Course/EditModal.vue';
import student from '@/routes/student';

type Course = {
    id: number;
    name: string;
    batch_id: string;
};

const props = defineProps<{
    courseData: Course;
    selectedBatchId: string | null;
}>();

const openStudents = () => {
    router.get(
        student.index.url({
            query: { course: props.courseData.id },
        }),
    );
};
</script>

<template>
    <Card class="cursor-pointer transition hover:border-primary/50" @click="openStudents">
        <CardHeader>
            <CardTitle>{{ props.courseData.name }}</CardTitle>
            <CardDescription>Program</CardDescription>
            <CardAction class="flex gap-2" @click.stop>
                <EditModal
                    :course-data="props.courseData"
                    :selected-batch-id="selectedBatchId"
                />
                <DeleteModal :course-data="props.courseData" />
            </CardAction>
        </CardHeader>
        <CardContent>
            <p class="text-sm text-muted-foreground">Manage this program.</p>
        </CardContent>
    </Card>
</template>
