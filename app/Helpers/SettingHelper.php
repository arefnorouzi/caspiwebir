<?php
use App\Models\WebsiteSetting;
use App\Models\Menu;

function site()
{
    return cache()->rememberForever('site_settings', function () {
        return WebsiteSetting::first();
    });
}


function main_menu()
{
    return cache()->rememberForever('main_menu', function () {
        return Menu::where('position', 'main_menu')
            ->where('parent_id', null)
            ->where('status', true)
            ->with(['children'])->get();
    });
}

function footer_menu()
{
    return cache()->rememberForever('footer_menu', function () {
        return Menu::where('position', 'footer_menu')
            ->where('parent_id', null)
            ->where('status', true)
            ->with(['children'])->get();
    });
}

function footer_social_networks()
{
    return cache()->rememberForever('footer_social_networks', function () {
        return \App\Models\SocialNetwork::where('position', 'footer')
            ->whereNotNull('image')
            ->whereNotNull('link')
            ->where('status', true)
            ->get();
    });
}
