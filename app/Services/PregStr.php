<?php

namespace App\Services;

class PregStr
{
    public static function preg_amount($amount): float
    {
        return floatval($amount);
    }

    public static function preg_all($text)
    {
        $text = str_replace('#', '', $text);
        $text = str_replace('&', '', $text);
        $text = str_replace(';', '', $text);
        $text = str_replace(' ', '', $text);
        $text = str_replace('!', '', $text);
        $text = str_replace('"', '', $text);
        $text = str_replace('$', '', $text);
        $text = str_replace('%', '', $text);
        $text = str_replace("'", '', $text);
        $text = str_replace('(', '', $text);
        $text = str_replace(')', '', $text);
        $text = str_replace('+', '', $text);
        $text = str_replace(',', '', $text);
        $text = str_replace('-', '', $text);
        $text = str_replace('/', '', $text);
        $text = str_replace(':', '', $text);
        $text = str_replace('<', '', $text);
        $text = str_replace('=', '', $text);
        $text = str_replace('>', '', $text);
        $text = str_replace('?', '', $text);
        $text = str_replace('[', '', $text);
        $text = str_replace('\\', '', $text);
        $text = str_replace(']', '', $text);
        $text = str_replace('^', '', $text);
        $text = str_replace('_', '', $text);
        $text = str_replace('`', '', $text);
        $text = str_replace('{', '', $text);
        $text = str_replace('|', '', $text);
        $text = str_replace('}', '', $text);
        $text = str_replace('~', '', $text);

        return $text;
    }

    public static function preg_sql($text): string
    {
        $text = str_replace(';', '', $text);
        $text = str_replace(' ', ' ', $text);
        $text = str_replace('!', '', $text);
        $text = str_replace('"', '', $text);
        $text = str_replace('$', '', $text);
        $text = str_replace('%', '', $text);
        $text = str_replace("'", '', $text);
        $text = str_replace('(', '', $text);
        $text = str_replace(')', '', $text);
        $text = str_replace('+', '', $text);
        $text = str_replace(',', '', $text);
        $text = str_replace('-', '-', $text);
        $text = str_replace('/', '', $text);
        $text = str_replace(':', '', $text);
        $text = str_replace('<', '', $text);
        $text = str_replace('=', '', $text);
        $text = str_replace('>', '', $text);
        $text = str_replace('?', '', $text);
        $text = str_replace('[', '', $text);
        $text = str_replace('\\', '', $text);
        $text = str_replace(']', '', $text);
        $text = str_replace('^', '', $text);
        $text = str_replace('_', '_', $text);
        $text = str_replace('`', '', $text);
        $text = str_replace('{', '', $text);
        $text = str_replace('|', '', $text);
        $text = str_replace('}', '', $text);
        $text = str_replace('~', '', $text);

        return $text;
    }

    public static function preg_pass($text): string
    {
        $text = str_replace(';', '', $text);
        $text = str_replace(' ', '', $text);
        $text = str_replace('!', '', $text);
        $text = str_replace('"', '', $text);
        $text = str_replace("'", '', $text);
        $text = str_replace('+', '', $text);
        $text = str_replace(',', '', $text);
        $text = str_replace('-', '-', $text);
        $text = str_replace('/', '', $text);
        $text = str_replace(':', '', $text);
        $text = str_replace('<', '', $text);
        $text = str_replace('=', '', $text);
        $text = str_replace('>', '', $text);
        $text = str_replace('?', '', $text);
        $text = str_replace('[', '', $text);
        $text = str_replace('\\', '', $text);
        $text = str_replace(']', '', $text);
        $text = str_replace('^', '', $text);
        $text = str_replace('_', '_', $text);
        $text = str_replace('`', '', $text);
        $text = str_replace('{', '', $text);
        $text = str_replace('|', '', $text);
        $text = str_replace('}', '', $text);
        $text = str_replace('~', '', $text);

        return $text;
    }

    public static function preg_text($text): string
    {
        $text = str_replace(';', '', $text);
        $text = str_replace(' ', ' ', $text);
        $text = str_replace('!', '', $text);
        $text = str_replace('"', '', $text);
        $text = str_replace("'", '', $text);
        $text = str_replace('+', '', $text);
        $text = str_replace(',', ' ', $text);
        $text = str_replace('-', ' - ', $text);
        $text = str_replace('/', '', $text);
        $text = str_replace(':', ' : ', $text);
        $text = str_replace('<', '', $text);
        $text = str_replace('=', ' = ', $text);
        $text = str_replace('>', '', $text);
        $text = str_replace('?', '?', $text);
        $text = str_replace('[', '', $text);
        $text = str_replace('\\', '', $text);
        $text = str_replace(']', '', $text);
        $text = str_replace('^', '', $text);
        $text = str_replace('_', '', $text);
        $text = str_replace('`', '', $text);
        $text = str_replace('{', '', $text);
        $text = str_replace('|', '', $text);
        $text = str_replace('}', '', $text);
        $text = str_replace('~', '', $text);

        return $text;
    }

    public static function preg_id($text): int
    {
        $text = self::preg_all($text);

        return intval($text);
    }

    public static function preg_slug($text): string
    {
        $text = str_replace(';', '', $text);
        $text = str_replace(' ', '', $text);
        $text = str_replace('!', '', $text);
        $text = str_replace('"', '', $text);
        $text = str_replace("'", '', $text);
        $text = str_replace('+', '', $text);
        $text = str_replace(',', '', $text);
        $text = str_replace('/', '', $text);
        $text = str_replace(':', '', $text);
        $text = str_replace('<', '', $text);
        $text = str_replace('=', '', $text);
        $text = str_replace('>', '', $text);
        $text = str_replace('?', '', $text);
        $text = str_replace('[', '', $text);
        $text = str_replace('\\', '', $text);
        $text = str_replace(']', '', $text);
        $text = str_replace('^', '', $text);
        $text = str_replace('_', '', $text);
        $text = str_replace('`', '', $text);
        $text = str_replace('{', '', $text);
        $text = str_replace('|', '', $text);
        $text = str_replace('}', '', $text);
        $text = str_replace('~', '', $text);

        return $text;
    }
}
