<?php

namespace App\Filament\Resources\PostResource\Widgets;

use App\Models\Blogger;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;


class PostStatsOverview extends BaseWidget
{
    private function getTotalLike()
    {
        return Post::withCount('likes')->get()->sum(function ($post) {
            return $post->likes_count;
        });
    }
    private function getAveragePostPerDay()
    {
        return DB::table('posts')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get()
            ->avg('count');
    }

    private function getAverageLikePerDay()
    {
        return DB::table('likes')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get()
            ->avg('count');
    }

    private function countPostPerDayForChart()
    {
        $countPostPerDayCollection = DB::table('posts')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get();

        // dd($countPostPerDayCollection);
        // die();

        $countPostPerDay = [];

        foreach ($countPostPerDayCollection->toArray() as $item) {
            $countPostPerDay[] = $item->count;
        }

        return $countPostPerDay;
    }

    private function getLikesPerDayForChart()
    {
        $likesPerDayArray = DB::table('likes')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get();

        $countLikePerDay = [];

        foreach ($likesPerDayArray->toArray() as $item) {
            $countLikePerDay[] = $item->count;
        }

        return $countLikePerDay;
    }

    private function getTheMostLikedPost()
    {
        return Post::withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->first()
            ->title;
    }

    private function getTheMostLikedPostBloggerName()
    {
        $mostLikedPost = Post::withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->first();

        return Blogger::find($mostLikedPost->blogger_id)->first()->name;
    }

    private function getNumberOfLikesInMostLikedPost()
    {
        return Post::withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->first()
            ->likes_count;
    }

    private function getTheMostCommentPost()
    {
        return Post::withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->first()
            ->title;
    }

    private function getBloggerNameInMostCommentPost()
    {
        $mostCommentPost = Post::withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->first();

        return Blogger::find($mostCommentPost)->first()->name;
    }

    private function getNumberOfCommentInMostCommentPost()
    {
        return Post::withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->first()
            ->comments_count;
    }

    protected function getCards(): array
    {
        // Lấy ra trung bình số bài viết mỗi ngày
        $averagePostsPerDay = $this->getAveragePostPerDay();

        $totalLike = $this->getTotalLike();

        // Lấy tiêu đề bài viết nhiều like nhất
        $mostLikedPost = $this->getTheMostLikedPost();

        // dd($this->getTheMostLikedPostBloggerName());

        // Lấy số lượng like trong bài viết nhiều like nhất
        $numOfLikes = $this->getNumberOfLikesInMostLikedPost();

        // Lấy bài viết có lượt comment nhiều nhất
        $mostCommentedPost = $this->getTheMostCommentPost();

        // Lấy số lượng comment có trong bài viết nhiều comment nhất
        $numOfComments = $this->getNumberOfCommentInMostCommentPost();

        // Lấy số lượng bài viết tạo ra một ngày để làm chart
        $countPostPerDay = $this->countPostPerDayForChart();

        // Lấy số lượng like trong một ngày tạo ra một ngày để làm chart
        $countLikePerDay = $this->getLikesPerDayForChart();

        $averageLikesPerDay = $this->getAverageLikePerDay();

        return [
            Card::make('Total posts', Post::all()->count())
                ->description(number_format($averagePostsPerDay, 2))
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart($countPostPerDay)
                ->color('success'),
            Card::make('Total view', Post::sum('view_count')),
            Card::make('Average post per day', number_format($averagePostsPerDay, 2)),
            Card::make('Most liked post', $mostLikedPost . ' (' . $numOfLikes . ' likes)')
                ->description($this->getTheMostLikedPostBloggerName())
                ->color('danger'),
            Card::make('Total likes', $totalLike)
                ->description(number_format($averageLikesPerDay, 2))
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart($countLikePerDay)
                ->color('success'),
            Card::make('Post has most comment', $mostCommentedPost . ' (' . $numOfComments . ' comments)')
                ->description($this->getBloggerNameInMostCommentPost())
                ->color('danger'),

        ];
    }
}
