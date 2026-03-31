<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Lead, type PaginatedData } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Building2, Mail, MessageSquare, Phone, Plus } from 'lucide-vue-next';

const props = defineProps<{
    leads: PaginatedData<Lead & { notes_count: number }>;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Leads', href: '/leads' },
];

const statusConfig: Record<string, { label: string; color: string; bg: string }> = {
    new: { label: 'New', color: 'text-blue-700 dark:text-blue-400', bg: 'bg-blue-50 dark:bg-blue-950/50 border-blue-200 dark:border-blue-800' },
    contacted: { label: 'Contacted', color: 'text-amber-700 dark:text-amber-400', bg: 'bg-amber-50 dark:bg-amber-950/50 border-amber-200 dark:border-amber-800' },
    qualified: { label: 'Qualified', color: 'text-emerald-700 dark:text-emerald-400', bg: 'bg-emerald-50 dark:bg-emerald-950/50 border-emerald-200 dark:border-emerald-800' },
    proposal: { label: 'Proposal', color: 'text-purple-700 dark:text-purple-400', bg: 'bg-purple-50 dark:bg-purple-950/50 border-purple-200 dark:border-purple-800' },
};

function getStatus(status: string) {
    return statusConfig[status] ?? { label: status, color: 'text-gray-700 dark:text-gray-400', bg: 'bg-gray-50 dark:bg-gray-950/50 border-gray-200 dark:border-gray-800' };
}

function getInitials(name: string): string {
    return name
        .split(' ')
        .map((w) => w[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
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
</script>

<template>
    <Head title="Leads" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-4 md:p-6">
            <!-- Header -->
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-foreground">Leads</h1>
                    <p class="text-sm text-muted-foreground">
                        Manage your wholesale partner pipeline.
                        <span class="font-medium">{{ leads.total }}</span> total leads.
                    </p>
                </div>
            </div>

            <!-- Leads Grid -->
            <div v-if="leads.data.length" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <Link
                    v-for="lead in leads.data"
                    :key="lead.id"
                    :href="`/leads/${lead.id}`"
                    class="group relative flex flex-col gap-4 rounded-xl border border-sidebar-border/70 bg-card p-5 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:border-primary/20 dark:border-sidebar-border dark:hover:border-primary/30"
                >
                    <!-- Status Badge -->
                    <span
                        :class="[getStatus(lead.status).color, getStatus(lead.status).bg]"
                        class="absolute top-4 right-4 inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors"
                    >
                        {{ getStatus(lead.status).label }}
                    </span>

                    <!-- Avatar & Name -->
                    <div class="flex items-center gap-3">
                        <div
                            :class="getAvatarColor(lead.id)"
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br text-sm font-bold text-white shadow-sm"
                        >
                            {{ getInitials(lead.name) }}
                        </div>
                        <div class="min-w-0">
                            <h3 class="truncate text-sm font-semibold text-foreground group-hover:text-primary transition-colors">
                                {{ lead.name }}
                            </h3>
                            <p v-if="lead.company" class="flex items-center gap-1 truncate text-xs text-muted-foreground">
                                <Building2 class="h-3 w-3 shrink-0" />
                                {{ lead.company }}
                            </p>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="flex flex-col gap-1.5 text-xs text-muted-foreground">
                        <span v-if="lead.email" class="flex items-center gap-1.5 truncate">
                            <Mail class="h-3 w-3 shrink-0" />
                            {{ lead.email }}
                        </span>
                        <span v-if="lead.phone" class="flex items-center gap-1.5">
                            <Phone class="h-3 w-3 shrink-0" />
                            {{ lead.phone }}
                        </span>
                    </div>

                    <!-- Notes Count -->
                    <div class="flex items-center gap-1.5 border-t border-border/50 pt-3 text-xs text-muted-foreground">
                        <MessageSquare class="h-3.5 w-3.5" />
                        <span>{{ lead.notes_count }} {{ lead.notes_count === 1 ? 'note' : 'notes' }}</span>
                    </div>
                </Link>
            </div>

            <!-- Empty State -->
            <div v-else class="flex flex-1 flex-col items-center justify-center gap-4 rounded-xl border border-dashed border-sidebar-border/70 p-12 dark:border-sidebar-border">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-muted">
                    <Plus class="h-6 w-6 text-muted-foreground" />
                </div>
                <div class="text-center">
                    <h3 class="text-sm font-semibold text-foreground">No leads yet</h3>
                    <p class="text-sm text-muted-foreground">Get started by adding your first lead.</p>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="leads.last_page > 1" class="flex items-center justify-center gap-1">
                <template v-for="link in leads.links" :key="link.label">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        :class="[
                            'inline-flex h-9 min-w-9 items-center justify-center rounded-md px-3 text-sm font-medium transition-colors',
                            link.active
                                ? 'bg-primary text-primary-foreground shadow-sm'
                                : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground',
                        ]"
                        v-html="link.label"
                    />
                    <span
                        v-else
                        class="inline-flex h-9 min-w-9 items-center justify-center rounded-md px-3 text-sm text-muted-foreground/50"
                        v-html="link.label"
                    />
                </template>
            </div>
        </div>
    </AppLayout>
</template>
