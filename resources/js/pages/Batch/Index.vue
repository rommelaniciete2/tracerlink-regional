<script setup lang="ts">
import BatchCard from '@/components/Batch/BatchCard.vue';
import BatchCreate from '@/components/Batch/BatchCreate.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import batch from '@/routes/batch';
import { BreadcrumbItem } from '@/types';
import { Calendar } from 'lucide-vue-next';
import {
    Empty,
    EmptyDescription,
    EmptyHeader,
    EmptyMedia,
    EmptyTitle,
} from '@/components/ui/empty';

type Batch = {
    id: string;
    name: string;
};

defineProps<{
    batches: Batch[];
}>();

const breadcrumb: BreadcrumbItem[] = [
    {
        title: 'Batches',
        href: batch.index(),
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumb">
        <div class="flex flex-1 flex-col gap-4 p-4">
            <section>
                <div>
                    <BatchCreate />
                </div>
            </section>
            <div class="grid gap-4 lg:grid-cols-3">
                <BatchCard
                    v-for="batch in batches"
                    :key="batch.id"
                    :batch-data="batch"
                />
            </div>
            <div
                v-if="batches.length === 0"
                class="flex justify-center text-sm text-muted-foreground"
            >
                <Empty>
                    <EmptyHeader>
                        <EmptyMedia variant="icon">
                            <Calendar />
                        </EmptyMedia>
                        <EmptyTitle>No Batch Yet</EmptyTitle>
                        <EmptyDescription>
                            You haven't created any batch yet. Get started by
                            creating your first batch.
                        </EmptyDescription>
                    </EmptyHeader>
                </Empty>
            </div>
        </div>
    </AppLayout>
</template>
