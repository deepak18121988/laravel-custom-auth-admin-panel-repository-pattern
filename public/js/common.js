// ======================
// 🔄 Loader
// ======================
function showLoader(){
    document.getElementById('globalLoader').style.display = 'flex';
}

function hideLoader(){
    document.getElementById('globalLoader').style.display = 'none';
}

// ======================
// 🔔 Alerts
// ======================
function showSuccess(message){
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: message,
        timer: 2000,
        showConfirmButton: false
    });
}

function showError(message){
    Swal.fire({
        icon: 'error',
        title: 'Error',
        html: message
    });
}

function confirmDelete(callback){
    Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33'
    }).then(result => {
        if(result.isConfirmed){
            callback();
        }
    });
}

function handleValidationErrors(errors){

    // 🔥 remove old
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.text-danger').forEach(el => el.innerHTML = '');

    // 🔥 loop errors
    for(let key in errors){

        let input = document.getElementById(key);
        let errorBox = document.getElementById(key + '_error');

        if(input){
            input.classList.add('is-invalid');
        }

        if(errorBox){
            errorBox.innerHTML = errors[key][0];
        }
    }
}

// ======================
// 🌐 GLOBAL FETCH
// ======================
async function apiFetch(url, options = {}){
    showLoader();

    try {
        let response = await fetch(url, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            ...options
        });

        let data = await response.json();

        if(!response.ok){
            if(data.errors){
                handleValidationErrors(data.errors);
            }else{
                showError(data.message || 'Something went wrong');
            }
            throw new Error("API Error");
        }

        return data;

    } catch (error){
        console.error(error);
    } finally {
        hideLoader();
    }
}
async function apiFetch(url, options = {}) {

    showLoader();

    try {
        let res = await fetch(url, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            ...options
        });

        // ❌ VALIDATION ERROR
        if (!res.ok) {

            let data = await res.json();

            if (data.errors) {

                // 🔥 INLINE ERROR HANDLE
                handleValidationErrors(data.errors);

                showError('Validation failed');
            }

            hideLoader();
            return null;
        }

        let data = await res.json();
        hideLoader();
        return data;

    } catch (e) {
        hideLoader();
        showError('Something went wrong');
        return null;
    }
}
