<!doctype html>
<html lang="en">
<head>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <title>Module 06</title>
</head>
<body>
<div class="add-books__form-wrapper">
    <form name="add-new-book" id="add-new-book" method="post" action="{{url('index')}}">
    @csrf
    <div class="form-selection">
        <label for="title">Title</label>
        <input type="text" id="text" name="title" class="form-control" required>
    </div>

    <div class="form-selection">
        <label for="Author">Author</label>
        <input type="text" id="Author" name="author" class="form-control" required>
    </div>

    <div class="form-selection">
        <label for="genre">Choose Genre:</label>
        <select name="genre" id="genre">
            <option value="fantasy">Fantasy</option>
            <option value="sci-fi">Sci-Fi</option>
            <option value="mystery">Mystery</option>
            <option value="drama">Drama</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

    </form>

    <div class="alert alert-danger">
        @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}} </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>


</body>
</html>
