@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('header-title', 'Log Aktivitas')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Log Aktivitas
        </h1>

        <p class="text-gray-500 mt-1">
            Riwayat aktivitas yang terjadi di dalam sistem.
        </p>
    </div>


    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">
                Riwayat Aktivitas
            </h2>
        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50">

                    <tr class="text-left text-gray-500">

                        <th class="py-3 px-5">
                            Waktu
                        </th>

                        <th class="py-3 px-5">
                            User
                        </th>

                        <th class="py-3 px-5">
                            Aktivitas
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($logs as $log)

                        <tr class="border-t border-gray-100 hover:bg-gray-50">

                            <td class="py-3 px-5 text-gray-500 whitespace-nowrap">
                                {{ $log->created_at->format('d M Y H:i') }}
                            </td>

                            <td class="py-3 px-5 font-medium text-gray-800">
                                {{ $log->user->name ?? 'Sistem' }}
                            </td>

                            <td class="py-3 px-5 text-gray-600">
                                {{ $log->aktivitas }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="3"
                                class="py-10 text-center text-gray-500">
                                Belum ada aktivitas.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($logs->hasPages())

            <div class="px-5 py-4 border-t border-gray-100">
                {{ $logs->links() }}
            </div>

        @endif

    </div>

</div>

@endsection