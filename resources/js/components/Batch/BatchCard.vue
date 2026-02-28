<script setup lang="ts">
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { Calendar, ChevronRight, BookOpen } from 'lucide-vue-next';
import {
    Card,
    CardAction,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import BatchDeleteModal from '@/components/Batch/BatchDeleteModal.vue';
import BatchEditModal from '@/components/Batch/BatchEditModal.vue';
import course from '@/routes/course';

type Batch = {
    id: string;
    name: string;
};

const props = defineProps<{
    batchData: Batch;
}>();

const displayYear = computed(() => {
    const startYear = Number(props.batchData.name);

    if (!Number.isInteger(startYear)) {
        return props.batchData.name;
    }

    return `${startYear}-${startYear + 1}`;
});

const openCourses = () => {
    router.get(
        course.index.url({
            query: { batch: props.batchData.id },
        }),
    );
};
</script>

<template>
    <Card 
    class="group cursor-pointer transition hover:shadow-md hover:border-primary/40"
    @click="openCourses"
  >
    <CardContent class="py-3 px-4">
      <div class="flex items-center justify-between">

        <!-- Left Content -->
        <div class="space-y-1">
          <p class="text-xs text-muted-foreground flex items-center gap-1">
            <Calendar class="h-3 w-3" />
            Batch
          </p>
          <h2 class="text-base font-semibold">
            {{ displayYear }}
          </h2>
          <p class="text-xs text-muted-foreground flex items-center gap-1">
            <BookOpen class="h-3 w-3" />
            Academic Year
          </p>
        </div>

        <!-- Right Actions -->
        <div class="flex gap-1 opacity-70 group-hover:opacity-100" @click.stop>
          <BatchEditModal :batch-data="batchData" />
          <BatchDeleteModal :batch-data="batchData" />
        </div>

      </div>
    </CardContent>
  </Card>
</template>
