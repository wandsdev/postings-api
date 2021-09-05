<?php


namespace App\Services;


use App\Models\Period;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PeriodService
{
    /**
     * @var mixed
     */
    private $userId;

    public function __construct()
    {
        $this->userId = auth()->user()->getAuthIdentifier();
    }

    public function findAll()
    {
        return Period::where('user_id', $this->userId)
                    ->orderBy('id', 'desc')
                    ->get();
    }

    /**
     * @param $params
     * @return Period
     */
    public function create($params): Period
    {
        extract($params);

        $period = new Period();
        $period->name = $name;
        $period->start_date = $start_date;
        $period->end_date = $end_date;
        $period->user_id = $this->userId;
        $period->save();
        return $period;
    }

    /**
     * @param $id
     * @param $name
     * @param $start_date
     * @param $end_date
     * @return Period|Period[]|Collection|Model
     */
    public function update($id, $name, $start_date, $end_date)
    {
        $period = Period::findOrFail($id);
        $period->name = $name;
        $period->start_date = $start_date;
        $period->end_date = $end_date;
        $period->user_id = $this->userId;
        $period->save();
        return $period;
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id): int
    {
        return Period::destroy($id);
    }
}
