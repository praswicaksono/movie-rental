<?php
declare(strict_types=1);

namespace App\Http\Livewire;

use App\Repositories\LendingRepository;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class MovieReturned extends Component
{
    public ?Collection $records = null;

    public bool $isModalOpen = false;

    public ?float $lateness_charge = 0.0;

    public ?int $return_record = null;

    protected array $rules = [
        'lateness_charge' => 'numeric'
    ];

    public function render(LendingRepository $lendingRepository)
    {
        $this->records = $lendingRepository->findNotReturnedRecord();

        return view('livewire.movie-returned.index');
    }

    public function returnRecord($id)
    {
        $this->return_record = $id;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetErrorBag();
    }

    public function store(LendingRepository $lendingRepository)
    {
        $lending = $lendingRepository->findOrFail((int) $this->return_record);
        $lendingRepository->returnMovie($lending, $this->lateness_charge);

        $this->closeModal();

        session()->flash('message', 'Movie successfully returned');
    }
}
