<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Facades\DB;

class PostsChart extends BarChartWidget
{
    protected static ?string $heading = 'Post created Chart';
    // protected static string $color = 'danger';

    private function getDataSet()
    {
        $countPostPerDayCollection = DB::table('posts')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get();

        $data = [];

        foreach ($countPostPerDayCollection->toArray() as $item) {
            $data[] = $item->count;
        }

        return $data;
    }

    private function getDateLabel()
    {
        $countPostPerDayCollection = DB::table('posts')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get();

        $data = [];

        foreach ($countPostPerDayCollection->toArray() as $item) {
            $data[] = $item->date;
        }

        return $data;
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $this->getDataSet(),
                    'backgroundColor' => ['#229c41', '#0341fc'],
                ],
            ],
            'labels' => $this->getDateLabel(),
        ];
    }
}
