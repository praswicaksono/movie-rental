<?php
declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Movie;
use App\Repositories\MovieRepository;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Movies extends Component
{
    public ?Collection $movies = null;

    public ?int $movies_id = null;

    public ?string $title = null;

    public ?string $genre = null;

    public ?string $category = null;

    public ?string $released_date = null;


    public bool $isModalOpen = false;

    protected $rules = [
        'title' => 'required',
        'genre' => 'required',
        'category' => 'required',
        'released_date' => 'required'
    ];

    public function render(MovieRepository $movieReposiotory)
    {
        $this->movies = $movieReposiotory->findAll();
        return view('livewire.movies.index');
    }

    public function create()
    {
        $this->clearFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetErrorBag();
    }

    private function clearFields()
    {
        $this->movies_id = null;
        $this->title = null;
        $this->genre = null;
        $this->category = null;
        $this->released_date = null;
    }

    public function store(MovieRepository $movieRepository)
    {
        $this->validate();

        $movie = new Movie();
        if (! is_null($this->movies_id)) {
            $movie = $movieRepository->findOrFail($this->movies_id);
        }
        $movie->title = $this->title;
        $movie->category = $this->category;
        $movie->genre = $this->genre;
        $movie->released_date = \DateTime::createFromFormat('Y-m-d', $this->released_date);

        $movieRepository->store($movie);

        $this->closeModal();

        session()->flash('message',
            $this->movies_id ? 'Movie Updated Successfully.' : 'Movie Created Successfully.');

        $this->clearFields();
    }

    public function edit($id, MovieRepository $movieRepository)
    {
        $movie = $movieRepository->findOrFail((int) $id);

        $this->movies_id = $id;
        $this->title = $movie->title;
        $this->genre = $movie->genre;
        $this->category = $movie->category;
        $this->released_date = explode(' ', $movie->released_date)[0];

        $this->openModal();
    }

    public function delete($id, MovieRepository $movieRepository)
    {
        $movie = $movieRepository->findOrFail((int) $id);

        $movieRepository->delete($movie);

        session()->flash('message', 'Movie successfully deleted from database');
    }
}
