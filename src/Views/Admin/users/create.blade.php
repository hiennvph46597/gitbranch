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
  <h1>Them moi nguoi dung</h1>

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

  <form action="{{ url('admin/users/store') }}" method="post" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
      <label for="name" class="form-label">Name:</label>
      <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="mb-3">
      <label for="avatar" class="form-label">Avatar:</label>
      <input type="file" class="form-control" name="avatar">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">password:</label>
      <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
    </div>
    <div class="mb-3">
      <label for="pwd" class="form-label">confirm password:</label>
      <input type="confirm_password" class="form-control" id="confirm_password" placeholder="Enter confirm_password" name="confirm_password">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</body>

</html>