<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class MovieRepository
{
    /**
     * @var Movie|Builder
     */
    private Movie $model;

    public function __construct(Movie $model)
    {
        $this->model = $model;
    }

    public function findAll(): Collection
    {
        return $this->model->all();
    }

    public function findOrFail(int $id): Movie
    {
        return $this->model->findOrFail($id);
    }

    public function findAvailableMovies(): Collection
    {
        return $this->model
            ->doesntHave('lendings')
            ->orWhereDoesntHave('lendings', function (Builder $query) {
                $query->whereNull('returned_date');
            })
            ->get();
    }

    public function delete(Movie $movie): void
    {
        $movie->delete();
    }

    public function store(Movie $movie): Movie
    {
        $movie->save();
        return $movie;
    }
}
