

 @extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">CREATE new Author</div>


               <div class="card-body">
                 
                <form method="POST" action="{{route('author.store')}}" enctype="multipart/form-data">

                    <div class="form-group">
                        <label>Name: </label>
                        <input type="text" class="form-control" value="{{old('author_name')}}" name="author_name">
                        <small class="form-text text-muted">Please enter new Authors Name</small>
                      </div>
                    

                      <div class="form-group">
                        <label>Surname: </label>
                        <input type="text" class="form-control" value="{{old('author_surname')}}" name="author_surname">
                        <small class="form-text text-muted">Please enter new Authors Surname</small>
                      </div>


                      <div class="form-group">
                        <label>Portrait: </label>
                        <input type="file" class="form-control" name="author_portret" >
                        <small class="form-text text-muted">Please upload Authors portrait</small>
                      </div>
                      
                    

                    @csrf
                    <button type="submit" class="btn btn-primary">ADD</button>
                 </form>

               </div>
           </div>
       </div>
   </div>
</div>
@endsection
