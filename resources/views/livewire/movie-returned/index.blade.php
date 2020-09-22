<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Return Lent Movie
    </h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            @if($isModalOpen)
                @include('livewire.movie-returned.form')
            @endif
            <table class="table-fixed w-full">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Movie Title</th>
                    <th class="border px-4 py-2">Member Name</th>
                    <th class="border px-4 py-2">Lent Date</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($records as $record)
                    <tr>
                        <td class="border px-4 py-2">{{ $record->movie->title }}</td>
                        <td class="border px-4 py-2">{{ $record->member->name }}</td>
                        <td class="border px-4 py-2">{{ $record->lending_date }}</td>
                        <td class="border px-4 py-2">
                            <button wire:click="returnRecord({{ $record->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Return Movie</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
