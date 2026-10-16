@extends('layouts.admin')
@section('page-heading', 'Jam Operasional')
@section('title', 'Jam Operasional')
@section('content')
    <form action="{{ route('jam-operasional.update-batch') }}" method="POST" class="operating-hours-form">
        @csrf
        @method('PUT')
        <div class="operating-hours-toolbar">
            <p class="operating-hours-description mb-0">
                Atur jam buka, jam tutup, dan hari libur untuk setiap hari.
            </p>
            <button type="submit" class="btn operating-hours-save">
                <i class="fas fa-rotate me-2" aria-hidden="true"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
        <section class="card operating-hours-card">
            <div class="card-header operating-hours-card-header">
                <div>
                    <h2 class="operating-hours-card-title">Jadwal Mingguan</h2>
                    <p class="mb-0">Perubahan berlaku setelah disimpan.</p>
                </div>
                <span class="operating-hours-card-icon" aria-hidden="true">
                    <i class="fas fa-clock"></i>
                </span>
            </div>
            <div class="table-responsive">
                <table class="table operating-hours-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Hari</th>
                            <th scope="col">Jam Buka</th>
                            <th scope="col">Jam Tutup</th>
                            <th scope="col" class="text-center">Hari Libur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jamOperasional as $jo)
                            <tr>
                                <th scope="row" class="operating-hours-day-cell">
                                    <span class="operating-hours-day {{ $jo->jo_is_hari_libur === 1 ? 'is-closed' : 'is-open' }}">
                                        {{ $jo->jo_hari }}
                                    </span>
                                </th>
                                <td>
                                    <input type="time" name="jam_buka[{{ $jo->jo_id }}]"
                                        value="{{ $jo->jo_jam_buka }}" class="form-control operating-hours-time"
                                        aria-label="Jam buka {{ $jo->jo_hari }}" />
                                </td>
                                <td>
                                    <input type="time" name="jam_tutup[{{ $jo->jo_id }}]"
                                        value="{{ $jo->jo_jam_tutup }}" class="form-control operating-hours-time"
                                        aria-label="Jam tutup {{ $jo->jo_hari }}" />
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch operating-hours-switch">
                                        <input type="checkbox" class="form-check-input"
                                            id="hari-libur-{{ $jo->jo_id }}" name="hari_libur[{{ $jo->jo_id }}]"
                                            value="1" aria-label="Tandai {{ $jo->jo_hari }} sebagai hari libur"
                                            {{ $jo->jo_is_hari_libur ? 'checked' : '' }} />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

    </form>
    @include('sweetalert2::index')
@endsection
