<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Lead } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Building2, ChevronLeft, Clock, Loader2, Mail, MessageSquare, Phone, Send, User } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps<{
    lead: Lead & { notes_count: number };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Leads', href: '/leads' },
    { title: props.lead.name, href: `/leads/${props.lead.id}` },
];

const form = useForm({
    note: '',
});

const isSubmitting = ref(false);

function submitNote() {
    if (!form.note.trim()) return;

    isSubmitting.value = true;
    form.post(`/leads/${props.lead.id}/notes`, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('note');
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
}

const statusConfig: Record<string, { label: string; color: string; bg: string }> = {
    new: { label: 'New', color: 'text-blue-700 dark:text-blue-400', bg: 'bg-blue-50 dark:bg-blue-950/50 border-blue-200 dark:border-blue-800' },
    contacted: { label: 'Contacted', color: 'text-amber-700 dark:text-amber-400', bg: 'bg-amber-50 dark:bg-amber-950/50 border-amber-200 dark:border-amber-800' },
    qualified: { label: 'Qualified', color: 'text-emerald-700 dark:text-emerald-400', bg: 'bg-emerald-50 dark:bg-emerald-950/50 border-emerald-200 dark:border-emerald-800' },
    proposal: { label: 'Proposal', color: 'text-purple-700 dark:text-purple-400', bg: 'bg-purple-50 dark:bg-purple-950/50 border-purple-200 dark:border-purple-800' },
};

function getStatus(status: string) {
    return statusConfig[status] ?? { label: status, color: 'text-gray-700 dark:text-gray-400', bg: 'bg-gray-50 dark:bg-gray-950/50 border-gray-200 dark:border-gray-800' };
}

function formatRelativeTime(dateString: string): string {
    const now = new Date();
    const date = new Date(dateString);
    const diffMs = now.getTime() - date.getTime();
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);
    const diffDays = Math.floor(diffMs / 86400000);

    if (diffMins < 1) return 'Just now';
    if (diffMins < 60) return `${diffMins}m ago`;
    if (diffHours < 24) return `${diffHours}h ago`;
    if (diffDays < 7) return `${diffDays}d ago`;
    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

const avatarColors = [
    'from-violet-500 to-purple-600',
    'from-cyan-500 to-blue-600',
    'from-emerald-500 to-teal-600',
    'from-rose-500 to-pink-600',
    'from-amber-500 to-orange-600',
    'from-indigo-500 to-blue-600',
];

function getAvatarColor(id: number): string {
    return avatarColors[id % avatarColors.length];
}

function getInitials(name: string): string {
    return name
        .split(' ')
        .map((w) => w[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
}

const notes = computed(() => props.lead.notes ?? []);
</script>

<template>
    <Head :title="lead.name" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-4 md:p-6">
            <!-- Back Link -->
            <div>
                <button
                    @click="router.visit('/leads')"
                    class="inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground transition-colors"
                >
                    <ChevronLeft class="h-4 w-4" />
                    Back to Leads
                </button>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Left Column: Lead Info -->
                <div class="flex flex-col gap-6 lg:col-span-1">
                    <!-- Lead Card -->
                    <Card class="overflow-hidden">
                        <!-- Gradient header bar -->
                        <div
                            :class="getAvatarColor(lead.id)"
                            class="h-20 bg-gradient-to-br opacity-90"
                        />
                        <div class="-mt-8 px-6">
                            <div
                                :class="getAvatarColor(lead.id)"
                                class="flex h-16 w-16 items-center justify-center rounded-xl bg-gradient-to-br text-xl font-bold text-white shadow-lg ring-4 ring-card"
                            >
                                {{ getInitials(lead.name) }}
                            </div>
                        </div>
                        <CardHeader class="pt-3">
                            <div class="flex items-start justify-between">
                                <div>
                                    <CardTitle class="text-lg">{{ lead.name }}</CardTitle>
                                    <CardDescription v-if="lead.company" class="flex items-center gap-1.5 mt-1">
                                        <Building2 class="h-3.5 w-3.5" />
                                        {{ lead.company }}
                                    </CardDescription>
                                </div>
                                <span
                                    :class="[getStatus(lead.status).color, getStatus(lead.status).bg]"
                                    class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold"
                                >
                                    {{ getStatus(lead.status).label }}
                                </span>
                            </div>
                        </CardHeader>
                        <CardContent class="space-y-3 text-sm">
                            <div v-if="lead.email" class="flex items-center gap-2.5 text-muted-foreground">
                                <Mail class="h-4 w-4 shrink-0 text-muted-foreground/60" />
                                <a :href="`mailto:${lead.email}`" class="hover:text-foreground hover:underline transition-colors truncate">
                                    {{ lead.email }}
                                </a>
                            </div>
                            <div v-if="lead.phone" class="flex items-center gap-2.5 text-muted-foreground">
                                <Phone class="h-4 w-4 shrink-0 text-muted-foreground/60" />
                                <a :href="`tel:${lead.phone}`" class="hover:text-foreground transition-colors">
                                    {{ lead.phone }}
                                </a>
                            </div>
                            <div class="flex items-center gap-2.5 text-muted-foreground">
                                <MessageSquare class="h-4 w-4 shrink-0 text-muted-foreground/60" />
                                <span>{{ lead.notes_count }} {{ lead.notes_count === 1 ? 'note' : 'notes' }}</span>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Right Column: Notes -->
                <div class="flex flex-col gap-6 lg:col-span-2">
                    <!-- Add Note Form -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="flex items-center gap-2 text-base">
                                <Send class="h-4 w-4" />
                                Add a Note
                            </CardTitle>
                            <CardDescription>
                                Record interactions, insights, and follow-up tasks for this lead.
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <form @submit.prevent="submitNote" class="space-y-4">
                                <div class="space-y-2">
                                    <Textarea
                                        id="note-input"
                                        v-model="form.note"
                                        placeholder="e.g. Buyer wants to review wholesale pricing..."
                                        :rows="3"
                                        :class="{ 'border-destructive': form.errors.note }"
                                    />
                                    <p v-if="form.errors.note" class="text-sm text-destructive flex items-center gap-1">
                                        {{ form.errors.note }}
                                    </p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-muted-foreground">
                                        {{ form.note.length }} / 5,000 characters
                                    </span>
                                    <Button
                                        id="submit-note-btn"
                                        type="submit"
                                        :disabled="isSubmitting || !form.note.trim()"
                                        class="gap-2"
                                    >
                                        <Loader2 v-if="isSubmitting" class="h-4 w-4 animate-spin" />
                                        <Send v-else class="h-4 w-4" />
                                        {{ isSubmitting ? 'Saving...' : 'Add Note' }}
                                    </Button>
                                </div>
                            </form>
                        </CardContent>
                    </Card>

                    <!-- Notes List -->
                    <div class="space-y-3">
                        <h2 class="flex items-center gap-2 text-sm font-semibold text-foreground">
                            <Clock class="h-4 w-4 text-muted-foreground" />
                            Activity Timeline
                            <span class="rounded-full bg-muted px-2 py-0.5 text-xs font-medium text-muted-foreground">
                                {{ notes.length }}
                            </span>
                        </h2>

                        <!-- Notes -->
                        <div v-if="notes.length" class="relative space-y-0">
                            <!-- Timeline line -->
                            <div class="absolute left-5 top-0 bottom-0 w-px bg-border" />

                            <div
                                v-for="(note, index) in notes"
                                :key="note.id"
                                class="relative flex gap-4 pb-6 last:pb-0"
                            >
                                <!-- Timeline dot -->
                                <div class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center">
                                    <div
                                        :class="index === 0 ? 'bg-primary shadow-sm shadow-primary/30' : 'bg-muted'"
                                        class="flex h-8 w-8 items-center justify-center rounded-full transition-colors"
                                    >
                                        <User
                                            :class="index === 0 ? 'text-primary-foreground' : 'text-muted-foreground'"
                                            class="h-4 w-4"
                                        />
                                    </div>
                                </div>

                                <!-- Note Content -->
                                <div
                                    :class="index === 0 ? 'border-primary/20 dark:border-primary/20 bg-primary/[0.02]' : ''"
                                    class="flex-1 rounded-xl border border-sidebar-border/70 bg-card p-4 shadow-sm transition-all dark:border-sidebar-border"
                                >
                                    <div class="mb-2 flex items-center justify-between gap-2">
                                        <span class="text-sm font-medium text-foreground">
                                            {{ note.user?.name ?? 'Unknown User' }}
                                        </span>
                                        <time class="flex items-center gap-1 text-xs text-muted-foreground">
                                            <Clock class="h-3 w-3" />
                                            {{ formatRelativeTime(note.created_at) }}
                                        </time>
                                    </div>
                                    <p class="text-sm leading-relaxed text-muted-foreground whitespace-pre-wrap">{{ note.note }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <Card v-else class="border-dashed">
                            <CardContent class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-muted mb-4">
                                    <MessageSquare class="h-5 w-5 text-muted-foreground" />
                                </div>
                                <h3 class="text-sm font-semibold text-foreground mb-1">No notes yet</h3>
                                <p class="text-sm text-muted-foreground max-w-sm">
                                    Add your first note above to start tracking interactions with this lead.
                                </p>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
