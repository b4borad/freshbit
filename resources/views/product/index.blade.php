@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
           @if ($message = Session::get('success'))
          <div class="alert alert-success">
              <p>{{ $message }}</p>
          </div>
        @endif
            <div class="card">
                <div class="card-header">{{ __('Product') }}

                <a href="{{route('products.create')}}" class="btn btn-primary" style="float:right;">Add {{ __('Product') }}</a>
                </div>
               
               <div class="card-body">
                  <div class="container">
                    <div class="col-12">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col"><input type="checkbox" name="main_action" id="main_action" class="main_action">
                          
                          </th>
                            <th scope="col">#</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Price</th>
                            <th scope="col">Product Upc</th>
                            <th scope="col">Product Status</th>
                            <th scope="col">Product Image</th>
                            <th scope="col">#Action</th>
                          </tr>
                          @if($productAry)
                            @foreach($productAry as $key=>$productVal)
                          <tr>
                            <td><input type="checkbox" value="{{$productVal['id']}}" name="action_del" class="action_del"></td>
                            <td>{{$key+1}}</td>
                            <td>{{$productVal['name']}}</td>
                            <td>{{$productVal['price']}}</td>
                            <td>{{$productVal['upc']}}</td>
                            <td>{{($productVal['status']==1) ? "Active" : "Inactive"}}</td>
                            <td>

                            @if($productVal['image'])
                            <img height="30" src="images/{{$productVal['image']}}" style="border-radius:4px;">
                            @endif
                            </td>
                            <td>
                            <form action="{{ route('products.destroy',$productVal['id']) }}" method="POST">  
                            <a href="{{ route('products.edit',$productVal['id']) }}" class="btn btn-primary">Edit</a>  
                             @csrf
                            @method('DELETE')
      
                          <button type="submit" class="btn btn-danger">Delete</button></td>
                          </form>
                          </tr>
                          @endforeach
                          @else
                          <tr>
                            <td colspan="7" align="center">Product not found..!</td>
                          </tr>
                            @endif
                        </thead>
                      <tbody>
                    </tbody>
                  </table>
                  <input type= "button" value="Delete Selected" id="delete_btn" class="btn btn-danger delete_btn">
                  
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  $( document ).ready(function() {
    $("#main_action").click(function(){
     
    $('input:checkbox').not(this).prop('checked', this.checked);
}); 


$("#delete_btn").click(function(){
  var allVals = []; 
  $(".action_del").each(function(){
    if(this.checked){
      var vl=$(this).attr('value');
      allVals.push(vl);  
    }
    
  });
if($('.action_del:checked').length<=0){
alert("Please select atleast one checkbox to delete");
return false;
}
  var check = confirm("Are you sure you want to delete selected record?");  
  if(check == true){  

    var strIds = allVals.join(",");
      //var join_selected_values = allVals.join(","); 

      $.ajax({
      url: "{{ route('product.multiple-delete') }}",
      type: 'DELETE',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: 'ids='+strIds,
          success: function (data) {
              window.location.reload();
            }
    });
  }
});
});



  </script>