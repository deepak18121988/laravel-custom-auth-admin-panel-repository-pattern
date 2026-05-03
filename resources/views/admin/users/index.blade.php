@extends('layouts.admin')

@section('admin-content')

<h3>Users</h3>

<button class="btn btn-success mb-2" onclick="openCreateModal()">Add User</button>

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
                <button class="btn btn-primary btn-sm" onclick="editUser({{ $user->id }})">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- ================= MODALS ================= --}}

<!-- EDIT MODAL -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Edit User</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="editForm">

                    <input type="hidden" id="user_id">

                    <input type="text" id="name" class="form-control mb-2" placeholder="Name">
                    <input type="email" id="email" class="form-control mb-2" placeholder="Email">

                    <select id="role_id" class="form-control mb-2">
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>

                    <button class="btn btn-success w-100">Update</button>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- CREATE MODAL -->
<div class="modal fade" id="createModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Create User</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="createForm">

                    <input type="text" id="c_name" class="form-control mb-2" placeholder="Name">
                    <input type="email" id="c_email" class="form-control mb-2" placeholder="Email">
                    <input type="password" id="c_password" class="form-control mb-2" placeholder="Password">

                    <select id="c_role_id" class="form-control mb-2">
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>

                    <button class="btn btn-success w-100">Save</button>

                </form>

            </div>
        </div>
    </div>
</div>

{{-- ================= ROUTES ================= --}}
<script>
const userRoutes = {
    store: "{{ route('admin.users.store') }}",
    base: "{{ url('admin/users') }}"
};
</script>

{{-- ================= SCRIPTS ================= --}}
<script>
let table, modal, createModal;

// 🔥 ELEMENTS (IMPORTANT FIX)
const createForm = document.getElementById('createForm');

const user_id = document.getElementById('user_id');
const name = document.getElementById('name');
const email = document.getElementById('email');
const role_id = document.getElementById('role_id');

const c_name = document.getElementById('c_name');
const c_email = document.getElementById('c_email');
const c_password = document.getElementById('c_password');
const c_role_id = document.getElementById('c_role_id');

// ================= INIT =================
$(document).ready(function(){
    table = $('#userTable').DataTable();

    modal = new bootstrap.Modal(document.getElementById('editModal'));
    createModal = new bootstrap.Modal(document.getElementById('createModal'));
});

// ================= DELETE =================
function deleteUser(id){
    confirmDelete(async () => {

        let data = await apiFetch(`${userRoutes.base}/${id}`, {
            method:'POST',
            body: JSON.stringify({_method:'DELETE'})
        });

        if(!data) return;

        showSuccess('User deleted');

        let row = $(`button[onclick="deleteUser(${id})"]`).closest('tr');
        table.row(row).remove().draw(false);
    });
}

// ================= EDIT =================
function editUser(id){
    fetch(`${userRoutes.base}/${id}/edit`)
    .then(res => res.json())
    .then(data => {

        user_id.value = data.id;
        name.value = data.name;
        email.value = data.email;
        role_id.value = data.role_id;

        modal.show();
    });
}

// ================= UPDATE =================
document.getElementById('editForm').addEventListener('submit', async function(e){
    e.preventDefault();

    let id = user_id.value;

    let data = await apiFetch(`${userRoutes.base}/${id}`, {
        method:'POST',
        body: JSON.stringify({
            _method:'PUT',
            name:name.value,
            email:email.value,
            role_id:role_id.value
        })
    });

    if(!data) return;

    showSuccess('User updated');

    let row = $(`button[onclick="editUser(${id})"]`).closest('tr');

    table.row(row).data([
        row.find('td:eq(0)').text(),
        name.value,
        email.value,
        $('#role_id option:selected').text(),
        row.find('td:eq(4)').html()
    ]).draw(false);

    modal.hide();
});

// ================= CREATE =================
function openCreateModal(){
    createForm.reset();
    createModal.show();
}

document.getElementById('createForm').addEventListener('submit', async function(e){
    e.preventDefault();

    let data = await apiFetch(userRoutes.store, {
        method:'POST',
        body: JSON.stringify({
            name:c_name.value,
            email:c_email.value,
            password:c_password.value,
            role_id:c_role_id.value
        })
    });

    if(!data) return;

    showSuccess('User created');

    table.row.add([
        table.rows().count()+1,
        data.user.name,
        data.user.email,
        data.user.role.name,
        `<button class="btn btn-sm btn-primary" onclick="editUser(${data.user.id})">Edit</button>
         <button class="btn btn-danger btn-sm" onclick="deleteUser(${data.user.id})">Delete</button>`
    ]).draw(false);

    createModal.hide();
});
</script>

@endsection