<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Interface\ChartInterface;
use App\Models\Api\Post;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    /**
     * @var ChartInterface
     */
    protected $postRepository;

    /**
     * @param ChartInterface $postRepository
     */
    public function __construct(ChartInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @return mixed
     */
    public function lineChartData()
    {
        $postsData = $this->postRepository->getMonthlyPostsCount();

        $months = range(1, 12);
        $categories = [];
        $seriesData = [];

        foreach ($months as $month) {
            /**
             * date('F')
             * تعرض اسم الشهر باللغه الانجليزيه اول حرف كابتل
             */
            $monthName = date('F', mktime(0, 0, 0, $month, 1));
            $categories[] = $monthName;
            $count = $postsData->where('month', $month)->first();

            $seriesData[] = $count ? $count->count : 0;
        }

        $series = [
            [
                'name' => 'Posts',
                'data' => $seriesData
            ]
        ];

        return ResponseHelper::success('success', 'Data retrieved successfully', [
            'categories' => $categories,
            'series' => $series
        ]);
    }
}
