@extends('admin_layout');
@section('admin_content');
       
  <div class="panel panel-default">
    <div class="panel-heading">
      Quản lí khách hàng
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
    <div class="table-responsive">
       <?php
                            $message = Session::get('message');
                            if($message)
                            {
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null); 
                            }
                        ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên khách hàng</th>
            <th>Email</th>
            <th>Mật khẩu</th>
            <th>Số điện thoại</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @foreach($all_customer as $key => $customer )
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            {{-- <td><a href="{{URL::to('/all-product/'.$cate_pro->category_id) }}">{{ $cate_pro->category_name }}</td></a> --}}
            <td>{{$customer->customer_name}}</td>
            <td>{{$customer->customer_email}}</td>
            <td>{{$customer->customer_password}}</td>
            <td>{{$customer->customer_phone}}</td>
            <td><span class="text-ellipsis">
              
            </span></td>
           {{--  <td><span class="text-ellipsis">12.5.2019</span></td>
            <td>
              <a href="{{URL::to('/edit-category-product/'.$cate_pro->category_id)}}" class="active" ui-toggle-class="">  
                <i class="fa fa-pencil-square-o text-success text-active"></i>
              <a onclick="return confirm('bạn muốn xóa danh mục sản phẩm ?')" href="{{URL::to('/delete-category-product/'.$cate_pro->category_id)}}" class="active" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i></a>  
            </td>
          </tr> --}}
          @endforeach
        </div>
</table>
    </tbody>

      </div>
    </footer>   
  </div>
</div>
            @endsection