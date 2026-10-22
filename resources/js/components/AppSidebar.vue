<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { LayoutGrid, UsersRound, ReceiptText, Hexagon, ChartBar, Vibrate, CloudDownload, Warehouse,
    BookImage, Boxes, TicketPercent, Newspaper, Images, Combine, Settings, HelpCircle, BadgeInfo, MessageCircleMore,
    MessageCircle, ShoppingCart} from 'lucide-vue-next';

import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'پیشخوان',
        href: '/admin',
        icon: LayoutGrid,
        children: []
    },
    {
        title: 'صفحات',
        href: '/admin/page',
        icon: Combine,
        children: []
    },

    {
        title: 'کاربران',
        href: '/admin/user',
        icon: UsersRound
    },
    {
        title: 'سبد کاربران',
        href: '/admin/cart',
        icon: ShoppingCart
    },
    {
        title: 'فاکتورها',
        href: '/admin/invoice',
        icon: ReceiptText
    },
    {
        title: 'برندها',
        href: '/admin/brand',
        icon: Hexagon
    },
    {
        title: 'دسته بندی ها',
        href: '/admin/category',
        icon: BookImage
    },
    {
        title: 'محصولات',
        href: '/admin/product',
        icon: Boxes
    },
    {
        title: 'نمودارها',
        href: '/admin/chart',
        icon: ChartBar,
    },
    {
        title: 'کوپن تخفیف',
        href: '/admin/coupon',
        icon: TicketPercent,
    },
    {
        title: 'چند رسانه ای',
        href: '/admin/media',
        icon: CloudDownload,
    },
    {
        title: 'نظرات',
        href: '/admin/comment',
        icon: MessageCircle,
    },
    {
        title: 'دسته بندی مقالات',
        href: '/admin/blog/category',
        icon: BookImage,
    },
    {
        title: 'مقالات',
        href: '/admin/post',
        icon: Newspaper,
    },
    {
        title: 'اسلایدرهای محصول',
        href: '/admin/product-slider',
        icon: Vibrate,
    },
    {
        title: 'اسلایدر تصاویر',
        href: '/admin/slider',
        icon: Images,
    },
    {
        title: 'بنرهای سایت',
        href: '/admin/banner',
        icon: Images,
    },
    {
        title: 'آیکون باکس',
        href: '/admin/box',
        icon: Warehouse,
    },
    {
        title: 'درخواست پشتیبانی',
        href: '/admin/ticket',
        icon: MessageCircleMore,
    },
    {
        title: 'تنظیمات',
        href: '/admin/setting',
        icon: Settings,
    }

];

const footerNavItems: NavItem[] = [
    {
        title: 'مارلیک افزار',
        href: 'https://caspiweb.ir',
        icon: BadgeInfo,
    },
    {
        title: 'ارتباط با پشتیبان',
        href: 'https://rubika.ir/caspiweb_ir',
        icon: HelpCircle,
    }
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset" style="left: auto; right: 0;">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link href="/admin">
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
