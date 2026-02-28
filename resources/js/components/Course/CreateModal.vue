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

const props = defineProps<{
    selectedBatchId: string | null;
}>();

const open = ref(false);

const form = useForm({
    name: '',
    batch_id: props.selectedBatchId ?? '',
});

watch(
    () => props.selectedBatchId,
    (batchId) => {
        form.batch_id = batchId ?? '';
    },
    { immediate: true },
);

const submit = () => {
    form.post(course.store().url, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('name');
            open.value = false;
        },
    });
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button size="sm" :disabled="!selectedBatchId">Create Program</Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <form @submit.prevent="submit" class="space-y-3">
                <DialogHeader>
                    <DialogTitle>Create program</DialogTitle>
                    <DialogDescription>
                        Add a course/program for the selected batch.
                    </DialogDescription>
                </DialogHeader>

                <div class="grid gap-3">
                    <Label for="course-create-name">Program Name</Label>
                    <Input
                        id="course-create-name"
                        v-model="form.name"
                        name="name"
                        type="text"
                        placeholder="e.g. BS Information Technology"
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
                    <Button type="submit" :disabled="form.processing || !selectedBatchId">
                        Save
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
