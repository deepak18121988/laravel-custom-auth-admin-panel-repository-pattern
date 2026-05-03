@extends('layouts.admin')

@section('admin-content')

<h3>Roles</h3>

<button class="btn btn-success mb-2" onclick="openRoleModal()">Add Role</button>

<table class="table table-bordered" id="roleTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($roles as $key=>$role)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $role->name }}</td>
            <td>
                <button onclick="editRole({{ $role->id }})" class="btn btn-primary btn-sm">Edit</button>
                <button onclick="deleteRole({{ $role->id }})" class="btn btn-danger btn-sm">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="modal fade" id="roleModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Role</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div id="roleError" class="alert alert-danger d-none"></div>

                <input type="hidden" id="role_id">
                <input type="text" id="role_name" class="form-control mb-2" placeholder="Role Name">

                <button onclick="saveRole()" class="btn btn-success w-100">Save</button>

            </div>

        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('#roleTable').DataTable();
});
</script>
<script>
let roleModal = new bootstrap.Modal(document.getElementById('roleModal'));

// open
function openRoleModal(){
    role_id.value = '';
    role_name.value = '';
    roleError.classList.add('d-none');
    roleModal.show();
}

// edit
function editRole(id){
    fetch('/admin/roles/'+id+'/edit')
    .then(res=>res.json())
    .then(data=>{
        role_id.value = data.id;
        role_name.value = data.name;
        roleModal.show();
    });
}

// save (create + update)
function saveRole(){

    let id = role_id.value;
    let url = '/admin/roles' + (id ? '/'+id : '');

    fetch(url,{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({
            _method: id ? 'PUT' : 'POST',
            name: role_name.value
        })
    })
    .then(async res=>{
        if(!res.ok){
            let data = await res.json();
            let html='';
            for(let key in data.errors){
                html += data.errors[key][0]+'<br>';
            }
            roleError.innerHTML = html;
            roleError.classList.remove('d-none');
            return;
        }

        roleModal.hide();
        location.reload();
    });
}

// delete
function deleteRole(id){
    if(confirm('Are you sure you want to delete?')){
        fetch('/admin/roles/'+id,{
            method:'POST',
            headers:{
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({_method:'DELETE'})
        }).then(()=>location.reload());
    }
}
</script>
@endsection