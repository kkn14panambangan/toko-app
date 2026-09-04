<!DOCTYPE html>
<html>
<head>
    <title>Test Upload</title>
</head>
<body>
    <h1>Test Upload Gambar</h1>
    
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
    
    @if($errors->any())
        <div style="color: red;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    
    <form action="{{ route('test.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="gambar" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>