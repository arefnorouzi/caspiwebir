<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import {
    LayoutGrid,
    NotepadText, User,
    BadgeInfo, MessageCircleMore
} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'پیشخوان',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'فاکتورها',
        href: '/dashboard/invoice',
        icon: NotepadText,
    },
    {
        title: 'پروفایل',
        href: '/dashboard/profile',
        icon: User,
    },
    {
        title: 'پشتیبانی',
        href: '/dashboard/ticket',
        icon: MessageCircleMore,
    },

];

const footerNavItems: NavItem[] = [
    {
        title: 'فروشگاه ساز مارلیک',
        href: 'https://caspiweb.ir',
        icon: BadgeInfo,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset" style="left: auto; right: 0">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link href="/dashboard">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
