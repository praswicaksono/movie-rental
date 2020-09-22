<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Lending Form
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
                @include('livewire.lending.form')
            @endif
            <table class="table-fixed w-full">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Movie Title</th>
                    <th class="border px-4 py-2">Category</th>
                    <th class="border px-4 py-2">Genre</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($movies as $movie)
                    <tr>
                        <td class="border px-4 py-2">{{ $movie->title }}</td>
                        <td class="border px-4 py-2">{{ $movie->category }}</td>
                        <td class="border px-4 py-2">{{ $movie->genre }}</td>
                        <td class="border px-4 py-2">
                            <button wire:click="lend({{ $movie->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Lend To Member</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
