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
        class="group relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:scale-[1.02] hover:border-primary/30 cursor-pointer"
        @click="openCourses"
    >
        <!-- Decorative gradient overlay on hover -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <!-- Top accent bar -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary/40 via-primary to-primary/40 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
        
        <CardHeader class="relative">
            <div class="flex items-start justify-between">
                <div class="space-y-1.5">
                    <!-- Batch label with icon -->
                    <div class="flex items-center gap-1.5 text-sm text-muted-foreground">
                        <Calendar class="h-4 w-4" />
                        <span>Batch</span>
                    </div>
                    <CardTitle class="text-lg font-semibold tracking-tight">
                        {{ displayYear }}
                    </CardTitle>
                    <CardDescription class="flex items-center gap-1 text-xs">
                        <BookOpen class="h-3.5 w-3.5" />
                        <span>Academic Year</span>
                    </CardDescription>
                </div>
                
                <!-- Actions with better visibility -->
                <CardAction class="flex gap-1 opacity-70 group-hover:opacity-100 transition-opacity" @click.stop>
                    <BatchEditModal :batch-data="batchData" />
                    <BatchDeleteModal :batch-data="batchData" />
                </CardAction>
            </div>
        </CardHeader>

        <CardContent class="relative pb-6">
            <!-- Main year display with enhanced styling -->
            <div class="flex flex-col items-center justify-center py-4">
                <div class="relative">
                    <!-- Background decoration -->
                    <div class="absolute inset-0 rounded-full bg-primary/5 blur-xl group-hover:bg-primary/10 transition-colors duration-500"></div>
                    
                    <!-- Year text -->
                    <h2 class="relative text-3xl font-bold bg-gradient-to-br from-foreground to-foreground/80 bg-clip-text">
                        {{ displayYear }}
                    </h2>
                </div>
                
                <!-- View courses indicator -->
                <div class="mt-3 flex items-center gap-1 text-xs text-muted-foreground group-hover:text-primary transition-colors">
                    <span>View Courses</span>
                    <ChevronRight class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5" />
                </div>
            </div>

            <!-- Decorative pattern (optional) -->
            <div class="absolute bottom-0 right-0 opacity-5">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="60" cy="60" r="20" stroke="currentColor" stroke-width="2"/>
                    <circle cx="40" cy="40" r="30" stroke="currentColor" stroke-width="2" stroke-opacity="0.5"/>
                </svg>
            </div>
        </CardContent>

        <!-- Bottom indicator for click action -->
        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-primary/0 group-hover:bg-primary/20 transition-colors duration-300"></div>
    </Card>
</template>
