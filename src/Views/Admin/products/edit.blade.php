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
  <h1> Cap nhap san pham: {{ $product['name'] }}</h1>

  @if (isset($_SESSION['status']) && $_SESSION['status'])
  <div class="alert alert-success">
    {{ $_SESSION['msg']}}
  </div>
  @php
  unset($_SESSION['status']);
  unset($_SESSION['msg']);
  @endphp
  @endif
  @if (isset($_SESSION['status']) && !$_SESSION['status'])
  <div class="alert alert-success">
    {{ $_SESSION['msg']}}
  </div>
  @php
  unset($_SESSION['status']);
  unset($_SESSION['msg']);
  @endphp
  @endif


  <form action="{{ url("admin/products/{$product['id']}/update") }}" method="post" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
      <label for="category_id" class="form_label">Category: </label>
      <select name="category_id" id="category_id" class="form-select">
        @foreach ($categoryPluck as $id =>$name )
        <option @if ($product['category_id']==$id) selected @endif value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-3 mt-3">
      <label for="name" class="form-label">Name:</label>
      <input type="text" class="form-control" id="name" placeholder="Enter name" value="{{ $product['name'] }}" name="name">
    </div>
    <div class="mb-3 mt-3">
      <label for="img_thumbnail" class="form-label">Img :</label>
      <input type="file" class="form-control" id="img_thumbnail" placeholder="Enter img_thumbnail" name="img_thumbnail">
      <img src="{{ asset($product['img_thumbnail']) }}" width="100px" alt="">
    </div>
    <div class="col-md-6">
      <div class="mb-3 mt-3">
        <label for="overview" class="form-label">Overview:</label>
        <textarea class="form-control" name="overview" placeholder="Enter overview" id="overview">{{ $product['overview'] }}</textarea>
      </div>
      <div class="mb-3 mt-3">
        <label for="content" class="form-label">Content:</label>
        <textarea class="form-control" name="content" placeholder="Enter content" id="content">{{ $product['content'] }}</textarea>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</body>

</html>