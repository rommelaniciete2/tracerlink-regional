<script setup lang="ts">
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import student from '@/routes/student';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const props = defineProps<{
    selectedCourseId: number | null;
}>();

const open = ref(false);

const form = useForm({
    course_id: props.selectedCourseId ?? '',
    student_number: '',
    full_name: '',
    email: '',
});

watch(
    () => props.selectedCourseId,
    (courseId) => {
        form.course_id = courseId ?? '';
    },
    { immediate: true },
);

const submit = () => {
    form.post(student.store().url, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('student_number', 'full_name', 'email');
            open.value = false;
        },
    });
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button size="sm" :disabled="!selectedCourseId">Create Student</Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[500px]">
            <form @submit.prevent="submit" class="space-y-3">
                <DialogHeader>
                    <DialogTitle>Create student</DialogTitle>
                    <DialogDescription>
                        Add a student to the selected course.
                    </DialogDescription>
                </DialogHeader>

                <div class="grid gap-3">
                    <Label for="student-number">Student Number</Label>
                    <Input
                        id="student-number"
                        v-model="form.student_number"
                        name="student_number"
                        type="text"
                        maxlength="10"
                        placeholder="10-digit student number"
                    />
                    <p v-if="form.errors.student_number" class="text-xs text-destructive">
                        {{ form.errors.student_number }}
                    </p>

                    <Label for="student-full-name">Full Name</Label>
                    <Input
                        id="student-full-name"
                        v-model="form.full_name"
                        name="full_name"
                        type="text"
                        placeholder="e.g. Juan Dela Cruz"
                    />
                    <p v-if="form.errors.full_name" class="text-xs text-destructive">
                        {{ form.errors.full_name }}
                    </p>

                    <Label for="student-email">Email</Label>
                    <Input
                        id="student-email"
                        v-model="form.email"
                        name="email"
                        type="email"
                        placeholder="e.g. juan@example.com"
                    />
                    <p v-if="form.errors.email" class="text-xs text-destructive">
                        {{ form.errors.email }}
                    </p>
                </div>

                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button type="submit" :disabled="form.processing || !selectedCourseId">
                        Save
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
