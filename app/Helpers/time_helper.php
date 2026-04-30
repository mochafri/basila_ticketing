<?php

if (!function_exists('format_duration')) {
    function format_duration($start, $end = null)
    {
        if (!$start) return '-';
        
        $startTime = new DateTime($start);
        $endTime = $end ? new DateTime($end) : new DateTime();
        
        $interval = $startTime->diff($endTime);
        
        $days = $interval->days;
        $hours = $interval->h;
        $minutes = $interval->i;
        
        if ($days >= 1) {
            return "{$days} hari {$hours} jam";
        }
        
        if ($hours >= 1) {
            return "{$hours} jam {$minutes} menit";
        }
        
        return "{$minutes} menit";
    }
}

if (!function_exists('format_minutes')) {
    function format_minutes($totalMinutes)
    {
        $totalMinutes = round($totalMinutes);
        if ($totalMinutes <= 0) return '0 menit';

        $days = floor($totalMinutes / (24 * 60));
        $remainingMinutes = $totalMinutes % (24 * 60);
        $hours = floor($remainingMinutes / 60);
        $minutes = $remainingMinutes % 60;

        if ($days >= 1) {
            return "{$days} hari {$hours} jam";
        }
        
        if ($hours >= 1) {
            return "{$hours} jam {$minutes} menit";
        }
        
        return "{$minutes} menit";
    }
}

if (!function_exists('format_datetime_indo')) {
    function format_datetime_indo($datetime)
    {
        if (!$datetime) return '-';
        
        $date = new DateTime($datetime);
        $months = [
            1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'
        ];
        
        $d = $date->format('d');
        $m = $months[(int)$date->format('m')];
        $y = $date->format('Y');
        $t = $date->format('H:i');
        
        return "{$d} {$m} {$y}, {$t} WIB";
    }
}

if (!function_exists('time_ago')) {
    function time_ago($datetime)
    {
        if (!$datetime) return '-';
        
        $time = strtotime($datetime);
        $diff = time() - $time;
        
        if ($diff < 1) return 'baru saja';
        
        $intervals = [
            31536000 => 'tahun',
            2592000  => 'bulan',
            604800   => 'minggu',
            86400    => 'hari',
            3600     => 'jam',
            60       => 'menit',
            1        => 'detik'
        ];
        
        foreach ($intervals as $secs => $str) {
            $d = $diff / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . $str . ' yang lalu';
            }
        }
    }
}
