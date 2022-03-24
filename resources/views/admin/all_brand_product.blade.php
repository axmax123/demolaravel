@extends('admin_layout');
@section('admin_content');
       
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê thương hiệu sản phẩm
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
            <th>Tên thương hiệu</th>
            <th>Hiển thị</th>
            <th>Ngày thêm</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @foreach($all_brand_product as $key => $brand_pro )
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{ $brand_pro->brand_name }}</td>
            <td><span class="text-ellipsis">
                <?php
                if($brand_pro ->brand_status ==0 )
                {
                 ?>
                    <a href="{{URL::to('/unactive-brand-product/'.$brand_pro->brand_id)}}"><i class="fa fa-check-square-o" aria-hidden="true"></i>
                 <?php
                   } 
                else
                {?>
                   <a href="{{URL::to('/active-brand-product/'.$brand_pro->brand_id)}}"><i class="fa fa-refresh" aria-hidden="true"></i></span>             
                   <?php  }
                ?>
            </span></td>
            <td><span class="text-ellipsis">12.5.2019</span></td>
            <td>
              <a href="{{URL::to('/edit-brand-product/'.$brand_pro->brand_id)}}" class="active" ui-toggle-class="">  
               <i class="fa fa-pencil" aria-hidden="true"></i>

              <a onclick="return confirm('bạn muốn xóa danh mục sản phẩm ?')" href="{{URL::to('/delete-brand-product/'.$brand_pro->brand_id)}}" class="active" ui-toggle-class="">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
</a>  
            </td>
          </tr>
          @endforeach
        </div>
</table>
    </tbody>

      </div>
    </footer>   
  </div>
</div>
            @endsection