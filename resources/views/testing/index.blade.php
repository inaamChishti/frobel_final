<!-- upload.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Upload Excel</title>
</head>
<body>
    <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="excel_file">
        <button type="submit">Submit</button>
    </form>
</body>
</html>
