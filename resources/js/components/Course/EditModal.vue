<script setup lang="ts">
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import course from '@/routes/course';
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

type Course = {
    id: number;
    name: string;
    batch_id: string;
};

const props = defineProps<{
    courseData: Course;
    selectedBatchId: string | null;
}>();

const open = ref(false);

const form = useForm({
    name: props.courseData.name,
    batch_id: props.courseData.batch_id,
});

watch(
    () => open.value,
    (isOpen) => {
        if (isOpen) {
            form.name = props.courseData.name;
            form.batch_id = props.selectedBatchId ?? props.courseData.batch_id;
            form.clearErrors();
        }
    },
);

const submit = () => {
    form.put(course.update({ course: props.courseData.id }).url, {
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
        <DialogContent class="sm:max-w-[425px]">
            <form @submit.prevent="submit" class="space-y-3">
                <DialogHeader>
                    <DialogTitle>Edit program</DialogTitle>
                    <DialogDescription>
                        Update the program name for this batch.
                    </DialogDescription>
                </DialogHeader>

                <div class="grid gap-3">
                    <Label for="course-edit-name">Program Name</Label>
                    <Input
                        id="course-edit-name"
                        v-model="form.name"
                        name="name"
                        type="text"
                    />
                    <p v-if="form.errors.name" class="text-xs text-destructive">
                        {{ form.errors.name }}
                    </p>
                    <p v-if="form.errors.batch_id" class="text-xs text-destructive">
                        {{ form.errors.batch_id }}
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
