<script setup lang="ts">
import { ref } from 'vue';
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

type StudentRow = {
    id: number;
    course_id: number;
    student_number: string;
    full_name: string;
    email: string;
};

const props = defineProps<{
    studentData: StudentRow;
}>();

const open = ref(false);
const form = useForm({});

const submit = () => {
    form.delete(student.destroy({ student: props.studentData.id }).url, {
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
            <Button size="sm" variant="destructive">Delete</Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <form @submit.prevent="submit" class="space-y-3">
                <DialogHeader>
                    <DialogTitle>Delete student</DialogTitle>
                    <DialogDescription>
                        This action cannot be undone.
                    </DialogDescription>
                </DialogHeader>

                <p class="text-sm">
                    Delete <strong>{{ studentData.full_name }}</strong
                    >?
                </p>

                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button
                        type="submit"
                        variant="destructive"
                        :disabled="form.processing"
                    >
                        Delete
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
