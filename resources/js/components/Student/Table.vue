<script setup lang="ts">
import Delete from '@/components/Student/Delete.vue';
import Edit from '@/components/Student/Edit.vue';

type StudentRow = {
    id: number;
    course_id: number;
    student_number: string;
    full_name: string;
    email: string;
};

defineProps<{
    students: StudentRow[];
    selectedCourseId: number | null;
}>();
</script>

<template>
    <div class="overflow-hidden rounded-lg border">
        <table class="w-full text-sm">
            <thead class="bg-muted/40 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium">Student Number</th>
                    <th class="px-4 py-3 font-medium">Full Name</th>
                    <th class="px-4 py-3 font-medium">Email</th>
                    <th class="px-4 py-3 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="studentItem in students"
                    :key="studentItem.id"
                    class="border-t"
                >
                    <td class="px-4 py-3">{{ studentItem.student_number }}</td>
                    <td class="px-4 py-3">{{ studentItem.full_name }}</td>
                    <td class="px-4 py-3">{{ studentItem.email }}</td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-2">
                            <Edit
                                :student-data="studentItem"
                                :selected-course-id="selectedCourseId"
                            />
                            <Delete :student-data="studentItem" />
                        </div>
                    </td>
                </tr>
                <tr v-if="students.length === 0">
                    <td class="px-4 py-4 text-muted-foreground" colspan="4">
                        No students for this course yet.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
