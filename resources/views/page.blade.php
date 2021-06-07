<!-- table -->
<table class="table" id="usertable">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Designation</th>
       <th scope="col" width="200px">Perform</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($user as $data)
    <tr id="uid{{ $data->id  }}">
            <td>{{ $data->id  }}</td>
            <td>{{ $data->name  }}</td>
            <td>{{ $data->email  }}</td>
            <td>{{ $data->Designation  }}</td>
            <td>
                <a href="javascript:void(0)" onclick="edituser({{ $data->id }})" class="btn btn-info">Edit</a>
                <a href="javascript:void(0)" onclick="deleteuser({{ $data->id }})"  class="btn btn-danger">Delete</a>
            </td>
    </tr>
     @endforeach
  </tbody>
</table>

<div class="d-flex pagination justify-content-center">
    {!! $user->links() !!}
</div>
