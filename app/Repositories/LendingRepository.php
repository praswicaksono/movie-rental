<?php
declare(strict_types=1);

namespace App\Repositories;


use App\Models\Lending;
use App\Models\Member;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class LendingRepository
{
    /**
     * @var Lending|Builder
     */
    private Lending $model;

    public function __construct(Lending $model)
    {
        $this->model = $model;
    }

    public function findOrFail(int $id): Lending
    {
        return $this->model->findOrFail($id);
    }

    public function save(Member $member, Movie $movie): void
    {
        $lending = new Lending();
        $lending->lending_date = new \DateTime();

        $lending->member()->associate($member);
        $lending->movie()->associate($movie);

        $lending->save();
    }

    public function returnMovie(Lending $lending, float $latenessCharge): void
    {
        $lending->returned_date = new \DateTime();
        $lending->lateness_charge = $latenessCharge;
        $lending->save();
    }

    public function findNotReturnedRecord(): Collection
    {
        return $this->model->whereNull('returned_date')->get()->load(['member', 'movie']);
    }
}
