<?php


namespace App\Repositories;


use App\Models\Period;
use App\Models\Posting;
use Illuminate\Support\Facades\DB;

class PostingRepository extends Repository
{
    /** @var Posting $model*/
    protected $model;

    /**
     * @param Posting $posting
     */
    public function __construct(Posting $posting)
    {
        parent::__construct($posting);
    }

    /**
     * @param $filter
     * @param $userId
     * @return array
     */
    public function findAllPostings($filter, $userId): array
    {
        if (empty($filter['periods'])) {
            $periodStartFilter = '';
            $periodEndFilter = '';
        } else {
            $periodStartFilter = "and pos.date >= '{$filter['periods'][0]}'";
            $periodEndFilter = "and pos.date <= '{$filter['periods'][1]}'";
        }

        $personIdFilter = empty($filter['person_id']) ? '': "and pos.person_id = {$filter['person_id']}";

        if (empty($filter['period_id'])) {
            $periodFilter = '';
        } else {
            $period = Period::findOrFail($filter['period_id']);
            $periodFilter = "and pos.date >= '{$period->start_date}' and pos.date <= '{$period->end_date}'";
        }

        $query = "select pos.id, pos.person_id, peo.name, pos.value, pos.date, pos.description
                    from postings pos
                    join people peo on peo.id = pos.person_id
                   where 1 = 1
                     and pos.user_id = $userId
                     $personIdFilter
                     $periodStartFilter
                     $periodEndFilter
                     $periodFilter
                    order by pos.date desc";

        return DB::select($query);
    }
}
