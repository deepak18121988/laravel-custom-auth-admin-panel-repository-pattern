@extends('layouts.admin')

@section('admin-content')

<h3>Users</h3>

<button class="btn btn-success mb-2" onclick="openCreateModal()">
    Add User
</button>
<table id="userTable" class="table table-bordered">

    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $key=>$user)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role->name ?? '' }}</td>

            
            <td>
                
                <button class="btn btn-primary btn-sm"
                        onclick="editUser({{ $user->id }})">
                    Edit
                </button>

                <button onclick="deleteUser({{ $user->id }})"
                        class="btn btn-danger btn-sm">
                    Delete
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Edit User</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="errorBox" class="alert alert-danger d-none"></div>
                <form id="editForm">

                    <input type="hidden" id="user_id">

                    <input type="text" id="name" class="form-control mb-2" placeholder="Name">
                    <input type="email" id="email" class="form-control mb-2" placeholder="Email">

                    <select id="role_id" class="form-control mb-2">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-success">Update</button>

                </form>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="createModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Create User</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- 🔴 Error Box -->
                <div id="createErrorBox" class="alert alert-danger d-none"></div>

                <form id="createForm">

                    <input type="text" id="c_name" class="form-control mb-2" placeholder="Name">
                    <input type="email" id="c_email" class="form-control mb-2" placeholder="Email">
                    <input type="password" id="c_password" class="form-control mb-2" placeholder="Password">

                    <select id="c_role_id" class="form-control mb-2">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-success w-100">Save</button>

                </form>

            </div>

        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('#userTable').DataTable();
});
</script>
<script>
function deleteUser(id){
    if(confirm('Are you sure you want to delete?')){
        fetch('/admin/users/'+id, {
            method:'DELETE',
            headers:{
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            }
        }).then(res=>res.json())
        .then(data=>{
            location.reload();
        });
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
let modal = new bootstrap.Modal(document.getElementById('editModal'));

// 🔹 Load data
function editUser(id){
    fetch('/admin/users/'+id+'/edit')
    .then(res => res.json())
    .then(data => {

        document.getElementById('user_id').value = data.id;
        document.getElementById('name').value = data.name;
        document.getElementById('email').value = data.email;
        document.getElementById('role_id').value = data.role_id;

        modal.show();
    });
}

// 🔹 Submit form (AJAX)
document.getElementById('editForm').addEventListener('submit', function(e){
    e.preventDefault();

    let id = document.getElementById('user_id').value;

    fetch('/admin/users/'+id, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            _method: 'PUT',
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            role_id: document.getElementById('role_id').value
        })
    })
    .then(async res => {
        if (!res.ok) {
            let data = await res.json();

            let errors = data.errors;
            let html = '';

            for (let key in errors) {
                html += errors[key][0] + '<br>';
            }

            document.getElementById('errorBox').innerHTML = html;
            document.getElementById('errorBox').classList.remove('d-none');

            throw new Error("Validation failed");
        }

        return res.json();
    })
    .then(data => {
        document.getElementById('errorBox').classList.add('d-none');
        modal.hide();
        location.reload();
    });
});

</script>
<script>
let createModal = new bootstrap.Modal(document.getElementById('createModal'));

// 🔹 open modal
function openCreateModal(){
    document.getElementById('createForm').reset();
    document.getElementById('createErrorBox').classList.add('d-none');
    createModal.show();
}

// 🔹 submit form
document.getElementById('createForm').addEventListener('submit', function(e){
    e.preventDefault();

    fetch('/admin/users', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            name: document.getElementById('c_name').value,
            email: document.getElementById('c_email').value,
            password: document.getElementById('c_password').value,
            role_id: document.getElementById('c_role_id').value
        })
    })
    .then(async res => {

        // ❌ validation error
        if (!res.ok) {
            let data = await res.json();

            let html = '';
            for (let key in data.errors) {
                html += data.errors[key][0] + '<br>';
            }

            document.getElementById('createErrorBox').innerHTML = html;
            document.getElementById('createErrorBox').classList.remove('d-none');

            return;
        }

        return res.json();
    })
    .then(data => {
        if(data){
            let table = $('#userTable').DataTable();

            table.row.add([
                 5,
                data.user.name,
                data.user.email,
                'User',
        '<button class="btn btn-sm btn-primary" onclick="editUser('+data.user.id+')">Edit</button><button class="btn btn-danger btn-sm" onclick="deleteUser('+data.user.id+')">Delete</button>'
            ]).draw();


            createModal.hide();
        }
    });
});
</script>
@endsection