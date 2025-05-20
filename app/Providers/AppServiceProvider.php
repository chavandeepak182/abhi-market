<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('frontend.layouts.footer', function ($view) {
            $allServices = DB::table('services')->select('id', 'service_name')->get();
            $allInsights = DB::table('insights')->select('id', 'insights_name')->get();
            $allIndustries = DB::table('industries')->select('id', 'industries_name')->get();
    
            $view->with([
                'allServices' => $allServices,
                'allInsights' => $allInsights,
                'allIndustries' => $allIndustries,
            ]);
        });
    
        // Header Composer (for dynamic Insights & Industries menu)
        View::composer('frontend.layouts.header', function ($view) {
            // Insights
            $insightCategories = DB::table('insights_category as c')
            ->leftJoin('insights_subcategory as s', 'c.pid', '=', 's.pid')
            ->leftJoin('insights as i', 's.insights_subcategory_id', '=', 'i.insights_subcategory_id')
            ->select('c.pid', 'c.category_name', 'i.id as insight_id', 'i.insights_name', 'i.slug')
            ->get()
            ->groupBy('pid');

            $structuredInsights = $insightCategories
            ->map(function ($items, $pid) {
                $insights = $items->map(fn($i) => [
                        'id' => $i->insight_id,
                        'name' => $i->insights_name,
                        'slug' => $i->slug
                    ])
                    ->filter(fn($i) => $i['name'] !== null)
                    ->values(); // optional: reindex insights array

                return [
                    'category_name' => $items->first()->category_name,
                    'insights' => $insights
                ];
            })
            ->filter(fn($category) => $category['insights']->isNotEmpty()) // 🔥 filter out categories with no insights
            ->values();
    
            // Industries
            $industryCategories = DB::table('industries_category as c')
            ->leftJoin('industries_subcategory as s', 'c.pid', '=', 's.pid')
            ->leftJoin('industries as i', 's.industries_subcategory_id', '=', 'i.industries_subcategory_id')
            ->select('c.pid', 'c.category_name', 'i.id as industry_id', 'i.industries_name', 'i.slug')
            ->get()
            ->groupBy('pid');

            $structuredIndustries = $industryCategories
            ->map(function ($items, $pid) {
                $industries = $items->map(fn($i) => [
                        'id' => $i->industry_id,
                        'name' => $i->industries_name,
                        'slug' => $i->slug
                    ])
                    ->filter(fn($i) => $i['name'] !== null)
                    ->values(); // optional: reindex industries array

                return [
                    'category_name' => $items->first()->category_name,
                    'industries' => $industries
                ];
            })
            ->filter(fn($category) => $category['industries']->isNotEmpty()) // 🔥 filter out categories with no industries
            ->values();

            // Services
            $serviceCategories = DB::table('property_category as c')
                ->leftJoin('property_subcategory as s', 'c.pid', '=', 's.pid')
                ->leftJoin('services as sv', 's.property_subcategory_id', '=', 'sv.property_subcategory_id')
                ->select('c.pid', 'c.category_name', 'sv.id as service_id', 'sv.service_name', 'sv.slug')
                ->get()
                ->groupBy('pid');

            $structuredServices = $serviceCategories
                ->map(function ($items, $pid) {
                    $services = $items->map(fn($s) => [
                            'id' => $s->service_id,
                            'name' => $s->service_name,
                            'slug' => $s->slug
                        ])
                        ->filter(fn($s) => $s['name'] !== null)
                        ->values(); // optional: reindex services array

                    return [
                        'category_name' => $items->first()->category_name,
                        'services' => $services
                    ];
                })
                ->filter(fn($category) => $category['services']->isNotEmpty()) // 🔥 filter out categories with no services
                ->values();

            // Reports
            $reports = DB::table('reports')
                ->select('id', 'report_name', 'slug')
                ->get()
                ->chunk(3) // Optional: split into chunks of 3 like in the Blade
                ->map(function ($chunk) {
                    return $chunk->map(function ($report) {
                        return [
                            'id' => $report->id,
                            'name' => $report->report_name,
                            'slug' => $report->slug,
                        ];
                    });
                });   

            $view->with([
                'insightMenuData' => $structuredInsights,
                'industriesMenuData' => $structuredIndustries,
                'serviceMenuData' => $structuredServices,
                'reportMenuData' => $reports,
            ]);
        });

    }
}