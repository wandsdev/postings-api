<?php


namespace App\Services;


use App\Models\Posting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PostingService
{
    /**
     * @var mixed
     */
    private $userId;

    public function __construct()
    {
        $this->userId = auth()->user()->getAuthIdentifier();
    }

    /**
     * @param $params
     * @return Posting
     */
    public function create($params): Posting
    {
        extract($params);

        $posting = new Posting();
        $posting->person_id = $person_id;
        $posting->value = $value;
        $posting->date = $date;
        $posting->description = $description;
        $posting->user_id = $this->userId;
        $posting->save();
        return $posting;
    }

    /**
     * @param $params
     * @param $id
     * @return Posting|Posting[]|Collection|Model
     */
    public function update($params, $id)
    {
        extract($params);

        $posting = Posting::findOrFail($id);
        $posting->person_id = $person_id;
        $posting->value = $value;
        $posting->date = $date;
        $posting->description = $description;
        $posting->user_id = $this->userId;
        $posting->save();
        return $posting;
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id): int
    {
        return Posting::destroy($id);
    }

}
