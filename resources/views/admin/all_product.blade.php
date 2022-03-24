@extends('admin_layout');
@section('admin_content');
       
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê  sản phẩm
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
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Hình ảnh</th>
            <th>Danh mục</th>
            <th>Thương hiệu</th>
            <th>Hiển thị</th>
            <th>Ngày thêm</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @foreach($all_product as $key => $pro )
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{ $pro->product_name }}</td>
            <td>{{ $pro->product_price }}</td>
            <td><img src="public/upload/product/{{$pro->product_image }}" height="50%" width="50%"></td>
            <td>{{ $pro->category_name }}</td>
            <td>{{ $pro->brand_name }}</td>
          

            <td><span class="text-ellipsis">
                <?php
                if($pro->product_status ==0 )
                {
                 ?>
                    <a href="{{URL::to('/unactive-product/'.$pro->product_id)}}"><i class="fa fa-check-square-o" aria-hidden="true"></i>
                 <?php
                   } 
                else
                {?>
                   <a href="{{URL::to('/active-product/'.$pro->product_id)}}"><i class="fa fa-refresh" aria-hidden="true"></i>

                   <?php  }
                ?>
            </span></td>
            <td><span class="text-ellipsis">12.5.2019</span></td>
            <td>
              <a href="{{URL::to('/edit-product/'.$pro->product_id)}}" class="active" ui-toggle-class="">  
              <i class="fa fa-pencil" aria-hidden="true"></i>
              <a onclick="return confirm('bạn muốn xóa  sản phẩm ?')" href="{{URL::to('/delete-product/'.$pro->product_id)}}" class="active" ui-toggle-class="">
                    <i class="fa fa-trash-o" aria-hidden="true"></i></a>  
            </td>
          </tr>
        </div>
      @endforeach
     </table>
    </tbody>

      </div>
    </footer>   
  </div>
</div>
            @endsection