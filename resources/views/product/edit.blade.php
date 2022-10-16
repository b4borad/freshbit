@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Edit Product') }}</div>
                <div class="card-body">
                    <form action="{{ route('products.update',$productAry['id']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                   <div class="row">
                    <div class="form-group">
                        <div class="col-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" value="{{$productAry['name']}}" class="form-control">
                    </div>
                

                <div class="form-group">
                        <div class="col-6">
                        <label for="name" class="form-label">Price</label>
                        <input type="text"  name="price" value="{{$productAry['price']}}" class="form-control">
                    </div>
                </div>


                <div class="form-group">
                        <div class="col-6">
                        <label for="name" class="form-label">UPC</label>
                        <input type="text" name="upc" value="{{$productAry['upc']}}"  class="form-control">
                    </div>
                </div>

                <div class="form-group">
                        <div class="col-6">
                        <label for="name" class="form-label">Status</label>
                       <select name="status" class="form-control">
                        <option value="1" {{($productAry['status']==1) ? 'selected' : ''}}>Active</option>
                        <option value="0" {{($productAry['status']==0) ? 'selected' : ''}}>Deactive</option>
                       </select>
                    </div>
                </div>

                <div class="form-group">
                        <div class="col-6">
                        <label for="name" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control">
                        @if(file_exists( public_path().'/images/'.$productAry['image'] ))
                        <img src="../../images/{{$productAry['image']}}" height="50" style="border-radius:4px;">
                        <input type="hidden" name="old_image" value="{{$productAry['image']}}">
                        @endif
                    </div>
                </div><br>
                <button type="submit" class="btn btn-success btn-md">Update</button>
                   </div>
                   </form>
                </div>
                </div>
              
            </div>
        </div>
    </div>
</div>
@endsection
