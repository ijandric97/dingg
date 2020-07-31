@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Breadcrumb --}}
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('restaurant.index') }}">Restaurant</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('restaurant.show', $restaurant->id) }}">{{ $restaurant->name }}</a></li>
                <li class="breadcrumb-item active">Tables</li>
            </ol>
        </nav>

        {{-- Title --}}
        <h1>Tables</h1>
        <br>

        <form method="POST" action="{{ route('restaurant.table.store', $restaurant->id) }}">
            @csrf

            {{-- Create / Submit --}}
            <div class="mb-2">
                <button type="button" class="btn btn-success" onclick="addTableRow()">📄 Create</button>
                <button type="submit" class="btn btn-primary">✉️ Submit</button>
            </div>

            <div class="form-group"> {{-- Tables --}}
                <label class="d-block" for="tables">Tables</label>
                <div class="table-responsive">
                    <table id="tables" class="table table-striped border">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 6.25rem;">Seat Count</th>
                                <th scope="col">Description</th>
                                <th scope="col" style="width: 6.75rem;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count(old('seat_count', $tables)
                                ); $i++)
                                <tr id="{{ 'tr_' . $i }}">
                                    <td>
                                        <input type="number"
                                            class="form-control @error('seat_count.'.$i) is-invalid @enderror"
                                            name="seat_count[]"
                                            value="{{ old('seat_count.' . $i, $tables[$i]['seat_count']) }}" min="1"
                                            max="99" required>
                                        @error('seat_count.'.$i)
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text"
                                            class="form-control @error('description.'.$i) is-invalid @enderror"
                                            name="description[]"
                                            value="{{ old('description.' . $i, $tables[$i]['description']) }}">
                                        @error('description.'.$i)
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" name="id[]" value="{{ old('id.' . $i, $tables[$i]['id']) }}"
                                            hidden>
                                        <button type="button" class=" btn btn-danger on-top"
                                            onclick="deleteTableRow({{ $i }})">🗑️ Delete</button>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                    @error('id')
                    <small class="form-text text-danger">You need at least 1 table!</small>
                    @enderror
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function deleteTableRow($id) {
            $('#tr_' + $id).remove();
        }

        var tablesMaxId = {{ $tables->max('id') }};

        function addTableRow() {
            var rowCount = $('#tables tr').length - 2; // Because header and 0 based
            var insertString = ' \
                <tr id="tr_' + rowCount + '"> \
                <td><input type="number" class="form-control" name="seat_count[]" value="1" min="1" max="99" required></td> \
                <td><input type="text" class="form-control" name="description[]" value=""></td> \
                <td> \
                <input type="number" name="id[]" value="" hidden> \
                <button type="button" class="btn btn-danger on-top" onclick="deleteTableRow(' + rowCount + ')">🗑️ Delete</button> \
                    </td> \
                    </tr> \
                ';

            $('#tables').append(insertString);
        }

    </script>
@endpush
