@extends('admin_layout');
@section('admin_content');
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm danh mục sản phẩm
                        </header>
                        <?php
                            $message = Session::get('message');
                            if($message)
                            {
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null); 
                            }
                        ?>
                        <div class="panel-body">
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-category-product')}}" method="post">
                                    {{csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục </label>
                                    <input type="text" name="category_product_name" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả danh mục</label>
                                <textarea name="chitiet" id="area" style="resize: none;" rows="5" type="text" class="form-control" id="exampleInputPassword1" name="category_product_desc">
                                        </textarea>
                                        <td width="400">
                                </div>
                                <div class="form-group">
                         <label for="exampleInputPassword1">Hiển thị</label>           
                                     <select name="category_product_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn </option>
                                <option value="1">Hiện</option>
                            </select>
                                </div>
                               
                                <button type="submit" name="add
                                _category_product" class="btn btn-info">Submit</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
            @endsection