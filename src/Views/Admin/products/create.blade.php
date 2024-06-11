<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Danh sach User</title>
  <!-- Latest compiled and minified CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Latest compiled JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <h1>Them moi San Pham</h1>

  @if (!empty($_SESSION['errors']))
  <div class="alert alert-warning">
    <ul>
      @foreach ( $_SESSION['errors'] as $error )
      <li>{{ $error }}</li>
      @endforeach
    </ul>
    @php
    unset($_SESSION['errors']);
    @endphp
  </div>

  @endif

  <form action="{{ url('admin/products/store') }}" method="post" enctype="multipart/form-data">
  <div class="mb-3 mt-3">
  <label for="category_id" class="form_label">Category: </label>
      <select name="category_id" id="category_id" class="form-select">
        @foreach ($categoryPluck as $id =>$name )
        <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-3 mt-3">
      <label for="name" class="form-label">Name:</label>
      <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
    </div>
    <div class="mb-3 mt-3">
      <label for="img_thumbnail" class="form-label">Img :</label>
      <input type="file" class="form-control" id="img_thumbnail" placeholder="Enter img_thumbnail" name="img_thumbnail">
    </div>
    <div class="col-md-6">
    <div class="mb-3 mt-3">
      <label for="overview" class="form-label">Overview:</label>
     <textarea class="form-control" name="overview" placeholder="Enter overview" id="overview"></textarea>
    </div>
    <div class="mb-3 mt-3">
      <label for="content" class="form-label">Content:</label>
      <textarea class="form-control" name="content" placeholder="Enter content"  id="content"></textarea>
    </div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</body>

</html>