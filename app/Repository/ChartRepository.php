<?php

namespace App\Repository;

use App\Interface\ChartInterface;
use App\Models\Api\Post;
use Illuminate\Support\Facades\DB;

class ChartRepository implements ChartInterface
{
    /**
     * @return mixed
     */
    public function getMonthlyPostsCount()
    {
        return
            /**
             * لاختيار الشهر و عدد Posts فى الشهر
             */
            Post::select(
            /**
             * يعنى اننا بنحول تاريخ انشاء POST الى رقم الشهر من 1:12
             */
                DB::raw('MONTH(created_at) as month'),
                /**
                 * بنعد عدد Post فى ذلك الشهر
                 */
                DB::raw('COUNT(*) as count'))
                /**
                 * بنحدد السنه الحاليه فقط
                 */
            ->whereYear('created_at', date('Y')) // بنحول الشهر الى اربعه ارقام
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
}
