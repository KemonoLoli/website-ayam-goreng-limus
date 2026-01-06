<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Helper Functions
 * Utility functions for admin views and controllers
 */

if (!function_exists('admin_url')) {
    /**
     * Generate admin URL
     * @param string $path Path after /admin/
     * @return string
     */
    function admin_url($path = '')
    {
        return site_url('admin/' . ltrim($path, '/'));
    }
}

if (!function_exists('is_role')) {
    /**
     * Check if current user has one of the specified roles
     * @param array|string $roles Role(s) to check
     * @return bool
     */
    function is_role($roles)
    {
        $ci =& get_instance();
        $user_role = $ci->session->userdata('role');

        if (empty($user_role)) {
            return false;
        }

        if (is_array($roles)) {
            return in_array($user_role, $roles);
        }

        return $user_role === $roles;
    }
}

if (!function_exists('format_rupiah')) {
    /**
     * Format number as Indonesian Rupiah
     * @param float $amount Amount to format
     * @param bool $with_symbol Include Rp symbol
     * @return string
     */
    function format_rupiah($amount, $with_symbol = true)
    {
        $formatted = number_format($amount, 0, ',', '.');
        return $with_symbol ? 'Rp ' . $formatted : $formatted;
    }
}

if (!function_exists('format_date')) {
    /**
     * Format date to Indonesian format
     * @param string $date Date string
     * @param string $format Output format
     * @return string
     */
    function format_date($date, $format = 'd M Y')
    {
        if (empty($date))
            return '-';

        $months = [
            'Jan' => 'Jan',
            'Feb' => 'Feb',
            'Mar' => 'Mar',
            'Apr' => 'Apr',
            'May' => 'Mei',
            'Jun' => 'Jun',
            'Jul' => 'Jul',
            'Aug' => 'Ags',
            'Sep' => 'Sep',
            'Oct' => 'Okt',
            'Nov' => 'Nov',
            'Dec' => 'Des'
        ];

        $formatted = date($format, strtotime($date));

        foreach ($months as $en => $id) {
            $formatted = str_replace($en, $id, $formatted);
        }

        return $formatted;
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Format datetime to Indonesian format
     * @param string $datetime Datetime string
     * @return string
     */
    function format_datetime($datetime)
    {
        if (empty($datetime))
            return '-';
        return format_date($datetime, 'd M Y H:i');
    }
}

if (!function_exists('time_ago')) {
    /**
     * Get human readable time ago string
     * @param string $datetime Datetime string
     * @return string
     */
    function time_ago($datetime)
    {
        $time = strtotime($datetime);
        $diff = time() - $time;

        if ($diff < 60) {
            return 'Baru saja';
        } elseif ($diff < 3600) {
            $mins = floor($diff / 60);
            return $mins . ' menit lalu';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' jam lalu';
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return $days . ' hari lalu';
        } else {
            return format_date($datetime);
        }
    }
}

if (!function_exists('status_badge')) {
    /**
     * Generate status badge HTML
     * @param string $status Status value
     * @param string $type Badge type (transaction, employee, etc)
     * @return string
     */
    function status_badge($status, $type = 'transaction')
    {
        $colors = [
            'transaction' => [
                'pending' => 'warning',
                'dikonfirmasi' => 'info',
                'diproses' => 'primary',
                'siap' => 'success',
                'dikirim' => 'info',
                'selesai' => 'success',
                'dibatalkan' => 'danger'
            ],
            'employee' => [
                'aktif' => 'success',
                'nonaktif' => 'secondary',
                'cuti' => 'warning',
                'resign' => 'danger'
            ],
            'attendance' => [
                'hadir' => 'success',
                'izin' => 'info',
                'sakit' => 'warning',
                'alpha' => 'danger',
                'libur' => 'secondary',
                'cuti' => 'primary'
            ],
            'payroll' => [
                'draft' => 'secondary',
                'diproses' => 'warning',
                'dibayar' => 'success'
            ],
            'purchase' => [
                'draft' => 'secondary',
                'dipesan' => 'warning',
                'diterima' => 'success',
                'dibatalkan' => 'danger'
            ],
            'inventory' => [
                'baik' => 'success',
                'rusak_ringan' => 'warning',
                'rusak_berat' => 'danger',
                'hilang' => 'dark'
            ]
        ];

        $color = 'secondary';
        if (isset($colors[$type][$status])) {
            $color = $colors[$type][$status];
        }

        $label = ucfirst(str_replace('_', ' ', $status));

        return '<span class="badge bg-' . $color . '">' . $label . '</span>';
    }
}

if (!function_exists('role_label')) {
    /**
     * Get role display label
     * @param string $role Role value
     * @return string
     */
    function role_label($role)
    {
        $labels = [
            'master' => 'Master Admin',
            'owner' => 'Owner',
            'admin' => 'Administrator',
            'kasir' => 'Kasir',
            'koki' => 'Koki/Chef',
            'waiter' => 'Waiter',
            'driver' => 'Driver',
            'member' => 'Member'
        ];

        return isset($labels[$role]) ? $labels[$role] : ucfirst($role);
    }
}

if (!function_exists('active_menu')) {
    /**
     * Check if current page matches menu item
     * @param string|array $segments URI segment(s) to match
     * @return string 'active' or empty
     */
    function active_menu($segments)
    {
        $ci =& get_instance();
        $current = $ci->uri->segment(2); // After 'admin'

        if (is_array($segments)) {
            return in_array($current, $segments) ? 'active' : '';
        }

        return $current === $segments ? 'active' : '';
    }
}

if (!function_exists('show_menu')) {
    /**
     * Check if menu item is expanded
     * @param array $segments URI segments for submenu items
     * @return string 'show' or empty
     */
    function show_menu($segments)
    {
        return active_menu($segments) ? 'show' : '';
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate CSRF hidden input
     * @return string
     */
    function csrf_field()
    {
        $ci =& get_instance();
        return '<input type="hidden" name="' . $ci->security->get_csrf_token_name() . '" value="' . $ci->security->get_csrf_hash() . '">';
    }
}

if (!function_exists('old')) {
    /**
     * Get old input value (for form repopulation)
     * @param string $field Field name
     * @param string $default Default value
     * @return string
     */
    function old($field, $default = '')
    {
        $ci =& get_instance();
        return set_value($field, $default);
    }
}

if (!function_exists('flash_messages')) {
    /**
     * Render flash messages as alerts
     * @return string HTML output
     */
    function flash_messages()
    {
        $ci =& get_instance();
        $output = '';

        $types = [
            'success' => 'success',
            'error' => 'danger',
            'warning' => 'warning',
            'info' => 'info'
        ];

        foreach ($types as $key => $class) {
            $message = $ci->session->flashdata($key);
            if ($message) {
                $output .= '<div class="alert alert-' . $class . ' alert-dismissible fade show" role="alert">';
                $output .= $message;
                $output .= '<button type="button" class="btn-close" data-coreui-dismiss="alert"></button>';
                $output .= '</div>';
            }
        }

        return $output;
    }
}

if (!function_exists('truncate')) {
    /**
     * Truncate text to specified length
     * @param string $text Text to truncate
     * @param int $length Maximum length
     * @param string $suffix Suffix to append
     * @return string
     */
    function truncate($text, $length = 100, $suffix = '...')
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . $suffix;
    }
}

if (!function_exists('get_initials')) {
    /**
     * Get initials from name
     * @param string $name Full name
     * @param int $count Number of initials
     * @return string
     */
    function get_initials($name, $count = 2)
    {
        $words = explode(' ', trim($name));
        $initials = '';

        foreach ($words as $word) {
            if (!empty($word) && strlen($initials) < $count) {
                $initials .= strtoupper($word[0]);
            }
        }

        return $initials;
    }
}
