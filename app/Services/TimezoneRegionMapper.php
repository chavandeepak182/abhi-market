<?php

namespace App\Services;

/**
 * The public enquiry form auto-detects the visitor's exact browser timezone
 * (e.g. "Asia/Kolkata", "America/Chicago", "Europe/Madrid") via JS, and that
 * is what gets saved on the lead. But agents are assigned to one of 8 broad
 * regions (not hundreds of individual city timezones).
 *
 * This class maps any incoming IANA timezone string to the correct one of
 * those 8 regions, so a visitor detected as e.g. "Europe/Madrid" still
 * correctly matches an agent assigned to the "Europe" region, even though
 * "Europe/Madrid" itself is never a region name.
 *
 * The 8 canonical regions (must match App\Models\Region rows, seeded by
 * RegionSeeder):
 *   North America, South America, Europe, Africa, Middle East,
 *   South Asia, East Asia, Australia & Oceania
 */
class TimezoneRegionMapper
{
    /**
     * Direct, curated mapping for the IANA identifiers real browsers most
     * commonly report. Anything not listed here falls back to the
     * continent-prefix heuristic in resolve().
     */
    private const MAP = [

        // North America
        'America/New_York' => 'North America', 'America/Detroit' => 'North America',
        'America/Chicago' => 'North America', 'America/Denver' => 'North America',
        'America/Los_Angeles' => 'North America', 'America/Anchorage' => 'North America',
        'America/Phoenix' => 'North America', 'America/Indiana/Indianapolis' => 'North America',
        'America/Toronto' => 'North America', 'America/Vancouver' => 'North America',
        'America/Winnipeg' => 'North America', 'America/Edmonton' => 'North America',
        'America/Halifax' => 'North America', 'America/St_Johns' => 'North America',
        'America/Mexico_City' => 'North America', 'America/Tijuana' => 'North America',
        'America/Monterrey' => 'North America', 'America/Cancun' => 'North America',
        'America/Havana' => 'North America', 'America/Jamaica' => 'North America',
        'America/Nassau' => 'North America', 'America/Panama' => 'North America',
        'America/Costa_Rica' => 'North America', 'America/Guatemala' => 'North America',
        'America/El_Salvador' => 'North America', 'America/Tegucigalpa' => 'North America',
        'America/Managua' => 'North America', 'America/Belize' => 'North America',
        'America/Puerto_Rico' => 'North America', 'America/Santo_Domingo' => 'North America',
        'America/Port-au-Prince' => 'North America', 'America/Barbados' => 'North America',
        'America/Grand_Turk' => 'North America', 'Pacific/Honolulu' => 'North America',

        // South America
        'America/Sao_Paulo' => 'South America', 'America/Argentina/Buenos_Aires' => 'South America',
        'America/Santiago' => 'South America', 'America/Bogota' => 'South America',
        'America/Lima' => 'South America', 'America/Caracas' => 'South America',
        'America/Guayaquil' => 'South America', 'America/La_Paz' => 'South America',
        'America/Montevideo' => 'South America', 'America/Asuncion' => 'South America',
        'America/Cayenne' => 'South America', 'America/Paramaribo' => 'South America',
        'America/Guyana' => 'South America', 'America/Manaus' => 'South America',
        'America/Recife' => 'South America', 'America/Fortaleza' => 'South America',

        // Europe
        'Europe/London' => 'Europe', 'Europe/Dublin' => 'Europe', 'Europe/Lisbon' => 'Europe',
        'Europe/Madrid' => 'Europe', 'Europe/Paris' => 'Europe', 'Europe/Berlin' => 'Europe',
        'Europe/Rome' => 'Europe', 'Europe/Amsterdam' => 'Europe', 'Europe/Brussels' => 'Europe',
        'Europe/Vienna' => 'Europe', 'Europe/Zurich' => 'Europe', 'Europe/Stockholm' => 'Europe',
        'Europe/Oslo' => 'Europe', 'Europe/Copenhagen' => 'Europe', 'Europe/Helsinki' => 'Europe',
        'Europe/Warsaw' => 'Europe', 'Europe/Prague' => 'Europe', 'Europe/Budapest' => 'Europe',
        'Europe/Bucharest' => 'Europe', 'Europe/Athens' => 'Europe', 'Europe/Sofia' => 'Europe',
        'Europe/Kiev' => 'Europe', 'Europe/Kyiv' => 'Europe', 'Europe/Moscow' => 'Europe',
        'Europe/Istanbul' => 'Europe', 'Atlantic/Reykjavik' => 'Europe',

        // Africa
        'Africa/Johannesburg' => 'Africa', 'Africa/Cairo' => 'Africa', 'Africa/Lagos' => 'Africa',
        'Africa/Nairobi' => 'Africa', 'Africa/Casablanca' => 'Africa', 'Africa/Algiers' => 'Africa',
        'Africa/Tunis' => 'Africa', 'Africa/Accra' => 'Africa', 'Africa/Addis_Ababa' => 'Africa',
        'Africa/Khartoum' => 'Africa', 'Africa/Kinshasa' => 'Africa', 'Africa/Dar_es_Salaam' => 'Africa',
        'Africa/Kampala' => 'Africa', 'Africa/Harare' => 'Africa', 'Africa/Lusaka' => 'Africa',
        'Africa/Maputo' => 'Africa', 'Indian/Mauritius' => 'Africa', 'Indian/Antananarivo' => 'Africa',

        // Middle East
        'Asia/Dubai' => 'Middle East', 'Asia/Riyadh' => 'Middle East', 'Asia/Qatar' => 'Middle East',
        'Asia/Bahrain' => 'Middle East', 'Asia/Kuwait' => 'Middle East', 'Asia/Muscat' => 'Middle East',
        'Asia/Baghdad' => 'Middle East', 'Asia/Tehran' => 'Middle East', 'Asia/Jerusalem' => 'Middle East',
        'Asia/Tel_Aviv' => 'Middle East', 'Asia/Amman' => 'Middle East', 'Asia/Beirut' => 'Middle East',
        'Asia/Damascus' => 'Middle East', 'Asia/Nicosia' => 'Middle East',

        // South Asia
        'Asia/Kolkata' => 'South Asia', 'Asia/Calcutta' => 'South Asia', 'Asia/Karachi' => 'South Asia',
        'Asia/Dhaka' => 'South Asia', 'Asia/Colombo' => 'South Asia', 'Asia/Kathmandu' => 'South Asia',
        'Asia/Thimphu' => 'South Asia', 'Indian/Maldives' => 'South Asia', 'Asia/Kabul' => 'South Asia',

        // East Asia (also covers Southeast Asia)
        'Asia/Singapore' => 'East Asia', 'Asia/Shanghai' => 'East Asia', 'Asia/Hong_Kong' => 'East Asia',
        'Asia/Tokyo' => 'East Asia', 'Asia/Seoul' => 'East Asia', 'Asia/Taipei' => 'East Asia',
        'Asia/Bangkok' => 'East Asia', 'Asia/Jakarta' => 'East Asia', 'Asia/Manila' => 'East Asia',
        'Asia/Kuala_Lumpur' => 'East Asia', 'Asia/Ho_Chi_Minh' => 'East Asia', 'Asia/Yangon' => 'East Asia',
        'Asia/Phnom_Penh' => 'East Asia', 'Asia/Vientiane' => 'East Asia', 'Asia/Macau' => 'East Asia',
        'Asia/Ulaanbaatar' => 'East Asia', 'Asia/Brunei' => 'East Asia',

        // Australia & Oceania
        'Australia/Sydney' => 'Australia & Oceania', 'Australia/Melbourne' => 'Australia & Oceania',
        'Australia/Brisbane' => 'Australia & Oceania', 'Australia/Perth' => 'Australia & Oceania',
        'Australia/Adelaide' => 'Australia & Oceania', 'Australia/Darwin' => 'Australia & Oceania',
        'Australia/Hobart' => 'Australia & Oceania', 'Pacific/Auckland' => 'Australia & Oceania',
        'Pacific/Fiji' => 'Australia & Oceania', 'Pacific/Guam' => 'Australia & Oceania',
        'Pacific/Port_Moresby' => 'Australia & Oceania', 'Pacific/Noumea' => 'Australia & Oceania',
        'Pacific/Tongatapu' => 'Australia & Oceania',
    ];

    /**
     * Resolve any IANA timezone string to one of the 8 canonical region
     * names, or null if it can't be classified at all (e.g. "UTC").
     */
    public static function resolve(?string $timezone): ?string
    {
        if (! $timezone) {
            return null;
        }

        if (isset(self::MAP[$timezone])) {
            return self::MAP[$timezone];
        }

        // Fallback for any IANA identifier not explicitly listed above:
        // classify by continent prefix so we still get a sensible bucket
        // instead of missing the match entirely.
        $continent = explode('/', $timezone, 2)[0] ?? '';

        return match ($continent) {
            'Europe' => 'Europe',
            'Africa' => 'Africa',
            'Australia' => 'Australia & Oceania',
            'Pacific' => 'Australia & Oceania',
            'Atlantic' => 'Europe',
            'Indian' => 'South Asia',
            'Asia' => 'South Asia',
            'America' => 'North America',
            default => null,
        };
    }
}
