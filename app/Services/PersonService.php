<?php


namespace App\Services;

use App\Models\Person;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PersonService
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
        return Person::where('user_id', $this->userId)->get();
    }

    /**
     * @param $params
     * @return Person
     */
    public function create($params): Person
    {
        extract($params);

        $person = new Person();
        $person->name = $name;
        $person->user_id = $this->userId;
        $person->save();
        return $person;
    }

    /**
     * @param $params
     * @param $id
     * @return Person|Person[]|Collection|Model
     */
    public function update($params, $id)
    {
        extract($params);

        $person = Person::findOrFail($id);
        $person->name = $name;
        $person->user_id = $this->userId;
        $person->save();
        return $person;
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id): int
    {
        return Person::destroy($id);
    }
}
