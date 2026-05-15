<?php

if (!function_exists('roleColor')) {
    function roleColor($role): string
    {
        return match($role) {
            'admin' => 'danger',
            'organizer' => 'warning',
            'user' => 'primary',
            default => 'secondary',
        };
    }
}

if (!function_exists('statusBadge')) {
    function statusBadge($status, $type = 'default'): string
    {
        $badges = [
            'approved' => 'bg-success',
            'active' => 'bg-success',
            'published' => 'bg-success',
            'pending' => 'bg-warning',
            'draft' => 'bg-secondary',
            'rejected' => 'bg-danger',
            'closed' => 'bg-danger',
            'cancelled' => 'bg-danger',
            'used' => 'bg-info',
        ];

        $color = $badges[$status] ?? 'bg-secondary';
        return "<span class=\"badge {$color}\">" . ucfirst($status) . "</span>";
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime($date, $format = 'd M Y, H:i'): string
    {
        return $date ? $date->format($format) : '-';
    }
}

if (!function_exists('activeMenu')) {
    function activeMenu($routeName, $activeClass = 'active'): string
    {
        return request()->routeIs($routeName) ? $activeClass : '';
    }
}