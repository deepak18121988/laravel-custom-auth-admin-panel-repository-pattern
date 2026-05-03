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

{{-- ================= MODAL ================= --}}
<div class="modal fade" id="roleModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Role</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- 🔴 INLINE ERROR -->
                <div id="role_name_error" class="text-danger mb-2"></div>

                <input type="hidden" id="role_id">

                <input type="text" id="role_name"
                       class="form-control mb-2"
                       placeholder="Role Name">

                <button onclick="saveRole()" class="btn btn-success w-100">Save</button>

            </div>

        </div>
    </div>
</div>

{{-- ================= ROUTES ================= --}}
<script>
const roleRoutes = {
    store: "{{ route('admin.roles.store') }}",
    base: "{{ url('admin/roles') }}"
};
</script>

{{-- ================= SCRIPT ================= --}}
<script>

let table, roleModal;

// 🔥 ELEMENTS
const role_id = document.getElementById('role_id');
const role_name = document.getElementById('role_name');
const role_name_error = document.getElementById('role_name_error');

// ================= INIT =================
$(document).ready(function(){
    table = $('#roleTable').DataTable();
    roleModal = new bootstrap.Modal(document.getElementById('roleModal'));
});

// ================= RESET VALIDATION =================
function resetValidation(){
    role_name.classList.remove('is-invalid');
    role_name_error.innerHTML = '';
}

// ================= OPEN MODAL =================
function openRoleModal(){
    role_id.value = '';
    role_name.value = '';
    resetValidation();
    roleModal.show();
}

// ================= EDIT =================
function editRole(id){
    fetch(`${roleRoutes.base}/${id}/edit`)
    .then(res => res.json())
    .then(data => {

        role_id.value = data.id;
        role_name.value = data.name;

        resetValidation();
        roleModal.show();
    });
}

// ================= SAVE (CREATE + UPDATE) =================
async function saveRole(){

    resetValidation();

    let id = role_id.value;

    let data = await apiFetch(
        id ? `${roleRoutes.base}/${id}` : roleRoutes.store,
        {
            method:'POST',
            body: JSON.stringify({
                _method: id ? 'PUT' : 'POST',
                name: role_name.value
            })
        }
    );

    // ❌ Validation error (handled by apiFetch → but inline also show)
    if(!data){
        showInlineError();
        return;
    }

    // ================= UPDATE =================
    if(id){

        let row = $(`button[onclick="editRole(${id})"]`).closest('tr');

        table.row(row).data([
            row.find('td:eq(0)').text(),
            role_name.value,
            row.find('td:eq(2)').html()
        ]).draw(false);

        showSuccess('Role updated');

    } else {

        // ================= CREATE =================
        table.row.add([
            table.rows().count()+1,
            data.role.name,
            `<button onclick="editRole(${data.role.id})" class="btn btn-primary btn-sm">Edit</button>
             <button onclick="deleteRole(${data.role.id})" class="btn btn-danger btn-sm">Delete</button>`
        ]).draw(false);

        showSuccess('Role created');
    }

    roleModal.hide();
}

// ================= DELETE =================
function deleteRole(id){
    confirmDelete(async () => {

        let data = await apiFetch(`${roleRoutes.base}/${id}`, {
            method:'POST',
            body: JSON.stringify({_method:'DELETE'})
        });

        if(!data) return;

        let row = $(`button[onclick="deleteRole(${id})"]`).closest('tr');
        table.row(row).remove().draw(false);

        showSuccess('Role deleted');
    });
}

// ================= INLINE ERROR =================
function showInlineError(){

    // 🔥 simple validation fallback (if API failed)
    if(!role_name.value){
        role_name.classList.add('is-invalid');
        role_name_error.innerHTML = 'Role name is required';
    }
}

</script>

@endsection