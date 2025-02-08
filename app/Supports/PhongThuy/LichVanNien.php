<?php

namespace App\Supports\PhongThuy;

class LichVanNien
{
    public static function jdFromDate(int $dd, int $mm, int $yy): float|int
    {
        $a = (int)((14 - $mm) / 12);
        $y = $yy + 4800 - $a;
        $m = $mm + 12 * $a - 3;
        $jd = $dd + (int)((153 * $m + 2) / 5) + 365 * $y + (int)($y / 4) - (int)($y / 100) + (int)($y / 400) - 32045;
        if ($jd < 2299161) {
            $jd = $dd + (int)((153 * $m + 2) / 5) + 365 * $y + (int)($y / 4) - 32083;
        }
        return $jd;
    }

    public static function getNewMoonDay($k, $timeZone): int
    {
        $T = $k / 1236.85;
        $T2 = $T * $T;
        $T3 = $T2 * $T;
        $dr = M_PI / 180;
        $Jd1 = 2415020.75933 + 29.53058868 * $k + 0.0001178 * $T2 - 0.000000155 * $T3;
        $Jd1 = $Jd1 + 0.00033 * sin((166.56 + 132.87 * $T - 0.009173 * $T2) * $dr);
        $M = 359.2242 + 29.10535608 * $k - 0.0000333 * $T2 - 0.00000347 * $T3;
        $Mpr = 306.0253 + 385.81691806 * $k + 0.0107306 * $T2 + 0.00001236 * $T3;
        $F = 21.2964 + 390.67050646 * $k - 0.0016528 * $T2 - 0.00000239 * $T3;
        $C1 = (0.1734 - 0.000393 * $T) * sin($M * $dr) + 0.0021 * sin(2 * $dr * $M);
        $C1 = $C1 - 0.4068 * sin($Mpr * $dr) + 0.0161 * sin($dr * 2 * $Mpr);
        $C1 = $C1 - 0.0004 * sin($dr * 3 * $Mpr);
        $C1 = $C1 + 0.0104 * sin($dr * 2 * $F) - 0.0051 * sin($dr * ($M + $Mpr));
        $C1 = $C1 - 0.0074 * sin($dr * ($M - $Mpr)) + 0.0004 * sin($dr * (2 * $F + $M));
        $C1 = $C1 - 0.0004 * sin($dr * (2 * $F - $M)) - 0.0006 * sin($dr * (2 * $F + $Mpr));
        $C1 = $C1 + 0.0010 * sin($dr * (2 * $F - $Mpr)) + 0.0005 * sin($dr * (2 * $Mpr + $M));
        if ($T < -11) {
            $deltaT = 0.001 + 0.000839 * $T + 0.0002261 * $T2 - 0.00000845 * $T3 - 0.000000081 * $T * $T3;
        } else {
            $deltaT = -0.000278 + 0.000265 * $T + 0.000262 * $T2;
        }
        $JdNew = $Jd1 + $C1 - $deltaT;
        return (int)($JdNew + 0.5 + $timeZone / 24);
    }

    public static function getSunLongitude(float|int $jdn, int $timeZone): int
    {
        $T = ($jdn - 2451545.5 - $timeZone / 24) / 36525;
        $T2 = $T * $T;
        $dr = M_PI / 180;
        $M = 357.52910 + 35999.05030 * $T - 0.0001559 * $T2 - 0.00000048 * $T * $T2;
        $L0 = 280.46645 + 36000.76983 * $T + 0.0003032 * $T2;
        $DL = (1.914600 - 0.004817 * $T - 0.000014 * $T2) * sin($dr * $M);
        $DL = $DL + (0.019993 - 0.000101 * $T) * sin($dr * 2 * $M) + 0.000290 * sin($dr * 3 * $M);
        $L = $L0 + $DL;
        $L = $L * $dr;
        $L = $L - M_PI * 2 * (int)($L / (M_PI * 2));
        return (int)($L / M_PI * 6);
    }

    public static function getLunarMonth11($yy, $timeZone): int
    {
        $off = static::jdFromDate(31, 12, $yy) - 2415021;
        $k = (int)($off / 29.53058867);
        $nm = static::getNewMoonDay($k, $timeZone);
        $sunLong = static::getSunLongitude($nm, $timeZone);
        if ($sunLong >= 9) {
            $nm = static::getNewMoonDay($k - 1, $timeZone);
        }
        return $nm;
    }

    public static function getLeapMonthOffset($a11, int $timeZone): int
    {
        $k = (int)(($a11 - 2415021.076998695) / 29.530588853);
        $i = 1;
        $arc = static::getSunLongitude(static::getNewMoonDay($k + $i, $timeZone), $timeZone);
        do {
            $last = $arc;
            $i++;
            $arc = static::getSunLongitude(static::getNewMoonDay($k + $i, $timeZone), $timeZone);
        } while ($arc != $last && $i < 14);
        return $i - 1;
    }

    /**
     * @param int $dd
     * @param int $mm
     * @param int $yy
     * @param int $timeZone
     * @return array [Ngay, Thang, Nam, Nhuan]
     */
    public static function convertSolar2Lunar(int $dd, int $mm, int $yy, int $timeZone): array
    {
        $dayNumber = static::jdFromDate($dd, $mm, $yy);
        $k = (int)(($dayNumber - 2415021.076998695) / 29.530588853);
        $nm = static::getNewMoonDay($k + 1, $timeZone);
        if ($nm > $dayNumber) {
            $nm = static::getNewMoonDay($k, $timeZone);
        }
        $a11 = static::getLunarMonth11($yy, $timeZone);
        $b11 = $a11;
        if ($a11 >= $nm) {
            $lunarYear = $yy;
            $a11 = static::getLunarMonth11($yy - 1, $timeZone);
        } else {
            $lunarYear = $yy + 1;
            $b11 = static::getLunarMonth11($yy + 1, $timeZone);
        }
        $lunarDay = $dayNumber - $nm + 1;
        $diff = (int)(($nm - $a11) / 29);
        $lunarLeap = 0;
        $lunarMonth = $diff + 11;
        if ($b11 - $a11 > 365) {
            $leapMonthDiff = static::getLeapMonthOffset($a11, $timeZone);
            if ($diff >= $leapMonthDiff) {
                $lunarMonth = $diff + 10;
                if ($diff == $leapMonthDiff) {
                    $lunarLeap = 1;
                }
            }
        }
        if ($lunarMonth > 12) {
            $lunarMonth = $lunarMonth - 12;
        }
        if ($lunarMonth >= 11 && $diff < 4) {
            $lunarYear -= 1;
        }
        return array($lunarDay, $lunarMonth, $lunarYear, $lunarLeap);
    }
}
