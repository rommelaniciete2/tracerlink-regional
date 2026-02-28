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

type StudentRow = {
    id: number;
    course_id: number;
    student_number: string;
    full_name: string;
    email: string;
};

const props = defineProps<{
    studentData: StudentRow;
    selectedCourseId: number | null;
}>();

const open = ref(false);

const form = useForm({
    course_id: props.studentData.course_id,
    student_number: props.studentData.student_number,
    full_name: props.studentData.full_name,
    email: props.studentData.email,
});

watch(
    () => open.value,
    (isOpen) => {
        if (isOpen) {
            form.course_id = props.selectedCourseId ?? props.studentData.course_id;
            form.student_number = props.studentData.student_number;
            form.full_name = props.studentData.full_name;
            form.email = props.studentData.email;
            form.clearErrors();
        }
    },
);

const submit = () => {
    form.put(student.update({ student: props.studentData.id }).url, {
        preserveScroll: true,
        onSuccess: () => {
            open.value = false;
        },
    });
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button size="sm" variant="outline">Edit</Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[500px]">
            <form @submit.prevent="submit" class="space-y-3">
                <DialogHeader>
                    <DialogTitle>Edit student</DialogTitle>
                    <DialogDescription>Update student details.</DialogDescription>
                </DialogHeader>

                <div class="grid gap-3">
                    <Label for="edit-student-number">Student Number</Label>
                    <Input
                        id="edit-student-number"
                        v-model="form.student_number"
                        name="student_number"
                        type="text"
                        maxlength="10"
                    />
                    <p v-if="form.errors.student_number" class="text-xs text-destructive">
                        {{ form.errors.student_number }}
                    </p>

                    <Label for="edit-student-full-name">Full Name</Label>
                    <Input
                        id="edit-student-full-name"
                        v-model="form.full_name"
                        name="full_name"
                        type="text"
                    />
                    <p v-if="form.errors.full_name" class="text-xs text-destructive">
                        {{ form.errors.full_name }}
                    </p>

                    <Label for="edit-student-email">Email</Label>
                    <Input
                        id="edit-student-email"
                        v-model="form.email"
                        name="email"
                        type="email"
                    />
                    <p v-if="form.errors.email" class="text-xs text-destructive">
                        {{ form.errors.email }}
                    </p>
                </div>

                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button type="submit" :disabled="form.processing">Update</Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
