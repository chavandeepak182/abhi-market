<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Before this change, EVERY enquiry was auto-assigned to one of two
 * hardcoded agents: user 88 for APAC (country region_id == 1), user 29 for
 * everything else. Auto-assignment now runs off the visitor's detected
 * timezone -> broad region (see TimezoneRegionMapper) instead, matched
 * against the new agent_regions table.
 *
 * Without this seed, agent_regions starts empty and every new enquiry
 * would go unassigned until an admin configures region coverage by hand.
 * This preserves the old behaviour as a sensible default on day one:
 *   - user 88 (previously the APAC agent) covers the APAC-ish regions
 *   - user 29 (previously "everyone else") covers the remaining regions
 * An admin can freely add/remove rows in agent_regions afterwards to
 * assign more agents or rebalance coverage.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('agent_regions')) {
            return;
        }

        $apacAgentId = 88;
        $fallbackAgentId = 29;

        $apacRegions = ['South Asia', 'East Asia', 'Australia & Oceania'];
        $fallbackRegions = ['North America', 'South America', 'Europe', 'Africa', 'Middle East'];

        $now = now();

        $rows = [];

        if (DB::table('users')->where('id', $apacAgentId)->exists()) {
            foreach ($apacRegions as $region) {
                $rows[] = [
                    'user_id' => $apacAgentId,
                    'region_name' => $region,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (DB::table('users')->where('id', $fallbackAgentId)->exists()) {
            foreach ($fallbackRegions as $region) {
                $rows[] = [
                    'user_id' => $fallbackAgentId,
                    'region_name' => $region,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (! empty($rows)) {
            DB::table('agent_regions')->insertOrIgnore($rows);
        }
    }

    public function down(): void
    {
        DB::table('agent_regions')->whereIn('user_id', [88, 29])->delete();
    }
};
