@extends('layouts.master')

@section('title')
Danh sach User
@endsection

@section('content')

<div class="row justify-content-center">
  <div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
      <div class="white_card_header">
        <div class="box_header m-0">
          <div class="main-title">
            <h1 class="m-0">Danh sach San Pham</h1>
          </div>
        </div>
      </div>
      <div class="white_card_body">

        <a class="btn btn-primary" href="{{ url('admin/products/create' ) }}">Them moi</a>
        @if (isset($_SESSION['status']) && $_SESSION['status'])
        <div class="alert alert-success">
          {{ $_SESSION['msg']}}
        </div>
        @php
        unset($_SESSION['status']);
        unset($_SESSION['msg']);
        @endphp
        @endif
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>IMAGE</th>
                <th>NAME</th>
                <th>Category Name</th>
                <th>Category At</th>
                <th>UPDATE AT</th>
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $product )
              <tr>
                <td>{{ $product['id'] }}</td>
                <td>
                  <img src="{{ asset($product['img_thumbnail'])}}" alt="" width="100px">
                </td>
                <td><?= $product['name'] ?></td>
                <td><?= $product['c_name'] ?></td>
                <td><?= $product['created_at'] ?></td>
                <td><?= $product['update_at'] ?></td>
                <td>
                  <a class="btn btn-info" href="{{ url('admin/products/' . $product['id'] . '/show') }}">Xem</a>
                  <a class="btn btn-warning" href="{{ url('admin/products/' . $product['id'] . '/edit') }}">Cap nhat</a>

                  <a class="btn btn-danger" href="{{ url('admin/products/' . $product['id'] . '/delete') }}" onclick="return confirm('Chac chan xoa khong ?')" type="submit">DELETE</a>

                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>



@endsection