<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Penjualan') }}
            </h2>
            <a href="/sale/create" class="py-2 px-3 rounded-lg text-white bg-indigo-500 shadow-lg hover:bg-indigo-700">Add New Data</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl px-2 mx-auto sm:px-6 lg:px-8">    
            @if($sales->count())
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs uppercase bg-gray-50">
                        <tr class="text-center">
                            <th scope="col" class="px-6 py-3">Minggu ke</th>
                            <th scope="col" class="px-6 py-3">Penjualan</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                        <tr class="bg-white border-b hover:bg-gray-50 text-center">
                        <td class="px-6 py-4">{{ $sale->week }}</td>
                        <td class="px-6 py-4">{{ $sale->sale }}</td>
                        <td class="px-6 py-4 flex justify-around">
                            <a href="/sale/{{ $sale->id }}/edit"><x-heroicon-o-pencil-square class="flex-shrink-0 w-6 h-6 hover:text-blue-500" aria-hidden="true" /></a>
                            <form action="/sale/{{ $sale->id }}" method="POST">
                                @method('delete')
                                @csrf
                                <button onclick="return confirm('Anda ingin menghapus data ini?')" value="{{ $sale->id }}"><x-heroicon-o-trash class="flex-shrink-0 w-6 h-6 hover:text-red-500" aria-hidden="true" /></button>
                              </form>
                        </td>
                    </tr>
                    @endforeach              
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-center text-lg">Tidak ada Data</p>
            @endif

            {{ $sales->links() }}
        </div>
    </div>
</x-app-layout>
