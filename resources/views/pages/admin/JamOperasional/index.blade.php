@extends("layouts.admin")
@section("page-heading", "Jam Operasional")
@section("title", "Jam Operasional")
@section("content")
    <form action="{{ route("jam-operasional.update-batch") }}" method="POST">
        @csrf
        @method("PUT")
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Jam Buka</th>
                    <th>Jam Tutup</th>
                    <th>Hari Libur?</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jamOperasional as $jo)
                    <tr>
                        <td>{{ $jo->jo_hari }}</td>
                        <td>
                            <input
                                type="time"
                                name="jam_buka[{{ $jo->jo_id }}]"
                                value="{{ $jo->jo_jam_buka }}"
                                class="form-control"
                            />
                        </td>
                        <td>
                            <input
                                type="time"
                                name="jam_tutup[{{ $jo->jo_id }}]"
                                value="{{ $jo->jo_jam_tutup }}"
                                class="form-control"
                            />
                        </td>
                        <td class="text-center">
                            <input
                                type="checkbox"
                                name="hari_libur[{{ $jo->jo_id }}]"
                                value="1"
                                {{ $jo->jo_is_hari_libur ? "checked" : "" }}
                            />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Simpan Semua</button>
    </form>
@endsection
