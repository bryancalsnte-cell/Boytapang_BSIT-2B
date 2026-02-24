function showToast(type, message) {
    if (type === 'success') {
        toastr.success(message, 'Success');
    } else {
        toastr.error(message, 'Error');
    }
}

$('#addUserForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + 'users/save',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#AddNewModal').modal('hide');
                $('#addUserForm')[0].reset();
                showToast('success', 'User added successfully!');
                setTimeout(() => {
                    location.reload();
                }, 1000); 
            } else {
                showToast('error', response.message || 'Failed to add user.');
            }
        },
        error: function () {
            showToast('error', 'An error occurred.');
        }
    });
});

$(document).on('click', '.edit-btn', function () {
   const userId = $(this).data('id'); 
   $.ajax({
    url: baseUrl + 'users/edit/' + userId,
    method: 'GET',
    dataType: 'json',
    success: function (response) {
        if (response.data) {
            $('#editUserModal #name').val(response.data.name);
            $('#editUserModal #userId').val(response.data.id);
            $('#editUserModal #email').val(response.data.email);
            $('#editUserModal #password').val('');
            $('#editUserModal #role').val(response.data.role);
            $('#editUserModal #status').val(response.data.status);
            $('#editUserModal #phone').val(response.data.phone);
            $('#editUserModal').modal('show');
        } else {
            alert('Error fetching user data');
        }
    },
    error: function () {
        alert('Error fetching user data');
    }
});
});


$(document).ready(function () {
    $('#editUserForm').on('submit', function (e) {
        e.preventDefault(); 

        $.ajax({
            url: baseUrl + 'users/update',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#editUserModal').modal('hide');
                    showToast('success', 'User Updated successfully!');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    alert('Error updating: ' + (response.message || 'Unknown error'));
                }
            },
            error: function (xhr) {
                alert('Error updating');
                console.error(xhr.responseText);
            }
        });
    });
});

$(document).on('click', '.deleteUserBtn', function () {
    const userId = $(this).data('id');
    const csrfName = $('meta[name="csrf-name"]').attr('content');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    if (confirm('Are you sure you want to delete this user?')) {
        $.ajax({
            url: baseUrl + 'users/delete/' + userId,
            method: 'POST', 
            data: {
                _method: 'DELETE',
                [csrfName]: csrfToken
            },
            success: function (response) {
                if (response.success) {
                    showToast('success', 'Users deleted successfully.');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    alert(response.message || 'Failed to delete.');
                }
            },
            error: function () {
                alert('Something went wrong while deleting.');
            }
        });
    }
});

$(document).ready(function () {
    const $table = $('#example1');

    const csrfName = 'csrf_test_name'; 
    const csrfToken = $('input[name="' + csrfName + '"]').val();

    $table.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: baseUrl + 'users/fetchRecords',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        },
        columns: [
        { data: 'row_number' },
        { data: 'id', visible: false },
        { data: 'name' },
        { data: 'email' },
        { data: 'role' },
        { data: 'status' },
        { data: 'phone' },
        { data: 'created_at' },
        {
            data: null,
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
                return `
                <button class="btn btn-sm btn-warning edit-btn" data-id="${row.id}">
                <i class="far fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger deleteUserBtn" data-id="${row.id}">
                <i class="fas fa-trash-alt"></i>
                </button>
                `;
            }
        }
        ],
        responsive: true,
        autoWidth: false

        
    });
    document.addEventListener('DOMContentLoaded', function() {
    function updateClock() {
        const now = new Date();
        
        // Match the IDs from your HTML exactly
        const clockEl = document.getElementById('live-clock');
        const dateEl = document.getElementById('live-date');
        const greetingEl = document.getElementById('greeting');

        // Philippines Timezone formatting
        const timeOptions = { 
            timeZone: 'Asia/Manila', 
            hour12: true, 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit' 
        };

        if (clockEl) {
            clockEl.textContent = now.toLocaleTimeString('en-US', timeOptions);
        }

        if (dateEl) {
            const dateOptions = { timeZone: 'Asia/Manila', weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            dateEl.textContent = now.toLocaleDateString('en-US', dateOptions);
        }

        if (greetingEl) {
            const hr = now.getHours();
            let g = (hr < 12) ? "Good Morning" : (hr < 18) ? "Good Afternoon" : "Good Evening";
            greetingEl.textContent = g + "!";
        }
    }

    // Start the clock
    updateClock(); 
    setInterval(updateClock, 1000);
});
   
    });
    