<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import batch from '@/routes/batch';
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

type Batch = {
    id: string;
    name: string;
};

const props = defineProps<{
    batchData: Batch;
}>();

const open = ref(false);
const currentYear = new Date().getFullYear();

const form = useForm({
    name: props.batchData.name,
});

watch(
    () => open.value,
    (isOpen) => {
        if (isOpen) {
            form.name = props.batchData.name;
            form.clearErrors();
        }
    },
);

const nextYear = computed(() => {
    const startYear = Number(form.name);

    if (!Number.isInteger(startYear) || form.name.length !== 4) {
        return '';
    }

    return String(startYear + 1);
});

const submit = () => {
    form.put(batch.update({ batch: props.batchData.id }).url, {
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
                    <DialogTitle>Edit batch</DialogTitle>
                    <DialogDescription>
                        Update the batch start year.
                    </DialogDescription>
                </DialogHeader>

                <div class="grid gap-3">
                    <Label for="batch-edit-year">Start Year</Label>
                    <Input
                        id="batch-edit-year"
                        v-model="form.name"
                        name="name"
                        type="number"
                        min="2022"
                        :max="currentYear"
                        placeholder="e.g. 2020"
                    />
                    <p v-if="nextYear" class="text-xs text-muted-foreground">
                        Result: {{ form.name }}-{{ nextYear }}
                    </p>
                    <p v-if="form.errors.name" class="text-xs text-destructive">
                        {{ form.errors.name }}
                    </p>
                </div>

                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button type="submit" :disabled="form.processing">
                        Update
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
