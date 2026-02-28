<script setup lang="ts">
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import Create from '@/components/Student/Create.vue';
import Table from '@/components/Student/Table.vue';
import batch from '@/routes/batch';
import course from '@/routes/course';
import student from '@/routes/student';
import { BreadcrumbItem } from '@/types';

type Course = {
    id: number;
    name: string;
    batch_id: string;
};

type StudentRow = {
    id: number;
    course_id: number;
    student_number: string;
    full_name: string;
    email: string;
};

const props = defineProps<{
    courses: Course[];
    selectedCourseId: number | null;
    students: StudentRow[];
}>();

const selectedCourse = computed(() =>
    props.courses.find((course) => course.id === props.selectedCourseId),
);

const onCourseChange = (event: Event) => {
    const target = event.target as HTMLSelectElement;
    const courseId = target.value;

    if (!courseId) {
        router.get(student.index.url(), {}, { preserveScroll: true });
        return;
    }

    router.get(
        student.index.url({
            query: { course: Number(courseId) },
        }),
        {},
        { preserveScroll: true },
    );
};

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    {
        title: 'Batches',
        href: batch.index(),
    },
    {
        title: 'Courses',
        href: selectedCourse.value
            ? course.index({ query: { batch: selectedCourse.value.batch_id } })
            : course.index(),
    },
    {
        title: 'Students',
        href: props.selectedCourseId
            ? student.index({ query: { course: props.selectedCourseId } })
            : student.index(),
    },
    {
        title: selectedCourse.value?.name || 'Current Course',
        href: '',
    },
]);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 p-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center lg:justify-">
                <div class="flex items-center gap-3">
                    <select
                        class="h-9 rounded-md border bg-background px-3 text-sm"
                        :value="selectedCourseId ?? ''"
                        :disabled="courses.length === 0"
                        @change="onCourseChange"
                    >
                        <option
                            v-for="courseItem in courses"
                            :key="courseItem.id"
                            :value="courseItem.id"
                        >
                            {{ courseItem.name }}
                        </option>
                    </select>
                    <Create :selected-course-id="selectedCourseId" />
                </div>
            </div>

            <Table :students="students" :selected-course-id="selectedCourseId" />
        </div>
    </AppLayout>
</template>
