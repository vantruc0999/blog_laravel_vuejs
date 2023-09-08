<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Facades\DB;

class PostsChart extends BarChartWidget
{
    protected static ?string $heading = 'Post created Chart';

    private function countPostPerDayForChart(){
        $countPostPerDayCollection = DB::table('posts')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
        ->groupBy('date')
        ->get();

        // return $countPostPerDay;
    }

    protected function getData(): array
    {
        dd($this->countPostPerDayForChart());
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
