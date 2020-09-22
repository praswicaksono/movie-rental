<?php
declare(strict_types=1);

namespace App\Http\Livewire;

use App\Repositories\LendingRepository;
use App\Repositories\MemberRepository;
use App\Repositories\MovieRepository;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Lending extends Component
{
    public bool $isModalOpen = false;

    public ?Collection $movies = null;

    public ?Collection $members = null;

    public ?int $lend_to = null;

    public ?int $movie = null;

    public array $rules = [
        'lend_to' => 'required'
    ];

    public function render(MovieRepository $moviesRepository, MemberRepository $memberRepository)
    {
        $this->movies = $moviesRepository->findAvailableMovies();
        $this->members = $memberRepository->findActiveMembers();

        return view('livewire.lending.index');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetErrorBag();
    }

    public function lend($movieId)
    {
        $this->movie = $movieId;
        $this->isModalOpen = true;
    }

    public function store(
        LendingRepository $lendingRepository,
        MemberRepository $memberRepository,
        MovieRepository $moviesRepository
    ) {
        $this->validate();

        $movie = $moviesRepository->findOrFail($this->movie);
        $member = $memberRepository->findOrFail($this->lend_to);

        $lendingRepository->save($member, $movie);

        $this->closeModal();

        session()->flash('message', 'Movie successfully lent to user');
    }
}
