<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Import</title>
</head>

<body>
    <h1>Import Customers CSV</h1>
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif


    {{-- <form action="{{ route('import.csv') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="csv_file">Choose CSV File:</label>
        <input type="file" accept=".csv" name="csv_file" id="csv_file">
        @error('csv_file')
            <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <br>
        <button type="submit">Import</button>
    </form> --}}
    <form action="{{ route('customers.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="csv_file" required />
        <button type="submit">Upload CSV</button>
    </form>
    
</body>

</html>
