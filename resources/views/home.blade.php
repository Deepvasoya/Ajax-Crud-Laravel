@extends('Layout.app')
@section('content')
<div class="container">
    <h2 class="bg-primary text-center">Ajax-CRUD-Laravel-8 <button type="button" class="my-1 mx-3 btn btn-danger btn-sm float-end" data-bs-toggle="modal" data-bs-target="#userModal">
  Add User
</button></h2>

            @csrf
            <div class="table-responsive" id="table_data">
            @include('page')
            </div>
<div>


<!--Add New User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="userdata">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Name...">
                <span class="text-danger" id="nameError"></span>
            </div>
             <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email...">
                <span class="text-danger" id="emailError"></span>
            </div>
             <div class="mb-3">
                <label class="form-label">Designation</label>
                <input type="text" class="form-control" name="Designation" id="Designation" placeholder="Designation...">
                <span class="text-danger" id="DesignationError"></span>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!--Edit User Modal -->
<div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="userEditdata">
            @csrf
            <input type="hidden" name="id" id="id">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="editname" id="editname" required>
            </div>
             <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="editemail" id="editemail" required>
            </div>
             <div class="mb-3">
                <label class="form-label">Designation</label>
                <input type="text" class="form-control" name="editDesignation" id="editDesignation" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection



@section('script')


<!--Create User Jquery -->
<script type="text/javascript">
   $(document).ready(function(){
        $(document).on("submit","#userdata", function(e){
              e.preventDefault();

              let name = $("#name").val();
              let email = $("#email").val();
              let Designation = $("#Designation").val();
              let _token = $("input[name=_token]").val();

               $.ajax({
                url:"{{ route('user.create') }}",
                type:'POST',
                data:{
                    name:name,
                    email:email,
                    Designation:Designation,
                    _token:_token
                },
                success:function(response){
                    if(response)
                    {
                      $("#usertable tbody").prepend('<tr><td>'+response.id+'</td><td>'+response.name+'</td><td>'+response.email+'</td><td>'+response.Designation+'</td><td><a href="javascript:void(0)" onclick="edituser('+response.id+')" class="btn btn-info">Edit</a></td><td><a href="javascript:void(0)" onclick="deleteuser('+response.id+')" class="btn btn-danger">Delete</a></td></tr>');
                      $("#userdata")[0].reset();
                      $("#userModal").modal('hide');
                    }
                },
                 error:function (response) {
                    $('#nameError').text(response.responseJSON.errors.name);
                    $('#emailError').text(response.responseJSON.errors.email);
                    $('#DesignationError').text(response.responseJSON.errors.Designation);
                    }
             });
         });
});
</script>


<!--Edit and Update User Jquery -->
<script type="text/javascript">
    function edituser(id)
    {
        $.get('/user/'+id,function(user){
                $("#id").val(user.id);
                $("#editname").val(user.name);
                $("#editemail").val(user.email);
                $("#editDesignation").val(user.Designation);
                $("#userEditModal").modal('toggle');
        });
    }

        $(document).on("submit","#userEditdata", function(e){
              e.preventDefault();
              let id = $("#id").val();
              let name = $("#editname").val();
              let email = $("#editemail").val();
              let Designation = $("#editDesignation").val();
              let _token = $("input[name=_token]").val();
               $.ajax({
                url:"{{ route('user.update') }}",
                type:'PUT',
                data:{
                    id:id,
                    name:name,
                    email:email,
                    Designation:Designation,
                    _token:_token
                },
                success:function(response){
                      $("#uid"+response.id+'td:nth-child(1)').text(response.name);
                      $("#uid"+response.id+'td:nth-child(2)').text(response.email);
                      $("#uid"+response.id+'td:nth-child(3)').text(response.Designation);
                      $("#userEditModal").modal('toggle');
                      $("#userdata")[0].reset();
                      location.reload(true);
                    }
             });
         });
</script>

<!--Delete User Jquery -->
<script type="text/javascript">
    function deleteuser(id)
    {
        if(confirm("Do you realy want to delete this record?"))
        {
             $.ajax({
                url: '/user/'+id,
                type:'DELETE',
                data:{
                    _token: $("input[name=_token]").val()
                },
                success:function(response){
                      $("#uid"+id).remove();
                    }
             });
        }
    }
</script>


<!--pagination Jquery -->
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', '.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });

    function fetch_data(page)
    {
    var _token = $("input[name=_token]").val();
    $.ajax({
        url:"{{ route('user.pagination') }}",
        method:"POST",
        data:{_token:_token, page:page},
        success:function(response)
        {
        $('#table_data').html(response);
        }
        });
    }
});
</script>
@endsection

