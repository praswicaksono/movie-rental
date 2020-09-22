<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class MemberRepository
{
    /**
     * @var Member|Builder
     */
    private Member $model;

    public function __construct(Member $model)
    {
        $this->model = $model;
    }

    public function findAll(): Collection
    {
        return $this->model->all();
    }

    public function findActiveMembers(): Collection
    {
        return $this->model->where('is_active', '=', true)->get();
    }

    public function findOrFail(int $id): Member
    {
        return $this->model->findOrFail($id);
    }

    public function delete(Member $member): void
    {
        $member->delete();
    }

    public function store(Member $member): Member
    {
        $member->save();
        return $member;
    }
}
