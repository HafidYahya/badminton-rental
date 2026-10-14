@extends('layouts.admin')
@section('page-heading', 'Dashboard')
@section('title', 'Dashboard')
@section('content')
    <div class="row mb-3">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Transaksi</h6>
                    <h3>{{ $totalTransaksi }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Transaksi Hari Ini</h6>
                    <h3>{{ $totalTransaksiHariIni }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Transaksi Bulan Ini</h6>
                    <h3>{{ $totalTransaksiBulanIni }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Lapangan</h6>
                    <h3>{{ $totalLapangan }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Pelanggan</h6>
                    <h3>{{ $totalPelanggan }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Baru: Filter Transaksi Per Bulan -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Filter Transaksi Per Bulan</h6>

                    <form method="GET" action="{{ route('dashboard') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-5">
                                <label for="bulan" class="form-label">Bulan</label>
                                <select name="bulan" id="bulan" class="form-select">
                                    <option value="1" {{ $bulanDipilih == 1 ? 'selected' : '' }}>Januari</option>
                                    <option value="2" {{ $bulanDipilih == 2 ? 'selected' : '' }}>Februari</option>
                                    <option value="3" {{ $bulanDipilih == 3 ? 'selected' : '' }}>Maret</option>
                                    <option value="4" {{ $bulanDipilih == 4 ? 'selected' : '' }}>April</option>
                                    <option value="5" {{ $bulanDipilih == 5 ? 'selected' : '' }}>Mei</option>
                                    <option value="6" {{ $bulanDipilih == 6 ? 'selected' : '' }}>Juni</option>
                                    <option value="7" {{ $bulanDipilih == 7 ? 'selected' : '' }}>Juli</option>
                                    <option value="8" {{ $bulanDipilih == 8 ? 'selected' : '' }}>Agustus</option>
                                    <option value="9" {{ $bulanDipilih == 9 ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ $bulanDipilih == 10 ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ $bulanDipilih == 11 ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ $bulanDipilih == 12 ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="tahun" class="form-label">Tahun</label>
                                <select name="tahun" id="tahun" class="form-select">
                                    @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                        <option value="{{ $i }}" {{ $tahunDipilih == $i ? 'selected' : '' }}>
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                    </form>

                    <div class="alert alert-info">
                        <strong>Total Transaksi:</strong>
                        <h3 class="mb-0 mt-2">{{ $totalTransaksiBulanDipilih }}</h3>
                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($tahunDipilih . '-' . $bulanDipilih . '-01')->locale('id')->translatedFormat('F') }}
                            {{ $tahunDipilih }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
