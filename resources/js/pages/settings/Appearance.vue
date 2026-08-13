<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/DashboardLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'تنظیمات نمایش',
        href: '/settings/appearance',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="تنظیمات نمایش" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="تنظیمات نمایش"
                              description="حالت صفحات را به دلخواه خود انتخاب نمایید" />
                <AppearanceTabs />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
