<?php
declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Member;
use App\Repositories\MemberRepository;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Members extends Component
{
    public ?Collection $members = null;

    public ?int $member_id = null;

    public ?string $name = null;

    public int $age = 0;

    public ?string $address = null;

    public ?string $telephone = null;

    public ?string $identity_number = null;

    public ?\DateTime $created = null;

    public bool $is_active = false;

    public bool $isModalOpen = false;

    protected $rules = [
        'name' => 'required',
        'age' => 'numeric',
        'identity_number' => 'required|unique:members,identity_number'
    ];

    public function render(MemberRepository $memberRepository)
    {
        $this->members = $memberRepository->findAll();
        return view('livewire.members.index');
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
        $this->member_id = null;
        $this->name = null;
        $this->age = 0;
        $this->address = null;
        $this->telephone = null;
        $this->created = null;
        $this->is_active = false;
        $this->identity_number = null;
    }

    public function store(MemberRepository $memberRepository)
    {
        $rules = $this->rules;
        if (! is_null($this->member_id)) {
            $rules['identity_number'] = $rules['identity_number'] . ',' . $this->member_id;
        }

        $this->validate($rules);

        $member = new Member();
        if (! is_null($this->member_id)) {
            $member = $memberRepository->findOrFail($this->member_id);
        }
        $member->name = $this->name;
        $member->age = (int) $this->age;
        $member->address = $this->address;
        $member->telephone = $this->telephone;
        $member->identity_number = $this->identity_number;
        $member->is_active = $this->is_active;

        $memberRepository->store($member);

        $this->closeModal();

        session()->flash('message',
            $this->member_id ? 'Member Updated Successfully.' : 'Member Created Successfully.');

        $this->clearFields();
    }

    public function edit($id, MemberRepository $memberRepository)
    {
        $member = $memberRepository->findOrFail((int) $id);

        $this->member_id = $id;
        $this->name = $member->name;
        $this->age = $member->age;
        $this->address = $member->address;
        $this->telephone = $member->telephone;
        $this->created = $member->created_at;
        $this->identity_number = $member->identity_number;
        $this->is_active = (bool) $member->is_active;

        $this->openModal();
    }

    public function delete($id, MemberRepository $memberRepository)
    {
        $movie = $memberRepository->findOrFail((int) $id);

        $memberRepository->delete($movie);

        session()->flash('message', 'Member successfully deleted from database');
    }
}
