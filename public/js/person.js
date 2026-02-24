function showToast(type, message) {
    if (type === 'success') {
        toastr.success(message, 'Success');
    } else {
        toastr.error(message, 'Error');
    }
}

$(document).ready(function () {
    // Initialize DataTable
    $('#personTable').DataTable({
        "responsive": true,
        "autoWidth": false
    });

    // --- SAVE PERSON ---
    $('#addPersonForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
          // This ensures there is always exactly one slash between the base and the route
           url: baseUrl + 'person/save',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#addPersonModal').modal('hide');
                    $('#addPersonForm')[0].reset();
                    showToast('success', 'Person added successfully!');
                    // Small delay before reload so the user sees the toast
                    setTimeout(() => { location.reload(); }, 1000); 
                } else {
                    showToast('error', response.message || 'Failed to add record.');
                }
            },
            error: function () {
                showToast('error', 'An error occurred during save.');
            }
        });
    });

    // --- DELETE PERSON ---
   $(document).on('click', '.delete-person', function () {
    const personId = $(this).data('id');
    // This finds the CSRF input regardless of what you named it in Config
    const $csrfInput = $('input[type="hidden"][name^="csrf_"]'); 
    const csrfName = $csrfInput.attr('name');
    const csrfToken = $csrfInput.val();

    if (confirm('Are you sure?')) {
        $.ajax({
            url: baseUrl + '/person/delete/' + personId,
            method: 'POST',
            data: { [csrfName]: csrfToken },
            // ... rest of codeS
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        showToast('success', 'Deleted successfully!');
                        setTimeout(() => { location.reload(); }, 1000);
                    } else {
                        showToast('error', response.message || 'Delete failed.');
                    }
                },
                error: function () {
                    showToast('error', 'An error occurred during deletion.');
                }
            });
        }
    });

   // Use $(document).on to ensure even new rows respond to clicks
$(document).on('click', '.edit-person', function (e) {
    e.preventDefault();
    
    const personId = $(this).data('id');
    console.log("Edit button clicked for ID:", personId); // Check your console for this!

    $.ajax({
        url: baseUrl + 'person/edit/' + personId,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                // Fill the hidden ID and the input fields
                $('#editPersonModal #editId').val(response.data.id);
                $('#editPersonModal #editName').val(response.data.name);
                $('#editPersonModal #editBirthday').val(response.data.birthday);
                
                // Manually trigger the modal
                $('#editPersonModal').modal('show');
            } else {
                alert("Data not found");
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert("Could not fetch data. Check Console.");
        }
    });
});
$(document).on('submit', '#editPersonForm', function (e) {
    e.preventDefault(); 

    $.ajax({
        url: baseUrl + 'person/update',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#editPersonModal').modal('hide');
                showToast('success', 'Information updated!');
                
                // This line forces the table to show the new data
                setTimeout(function(){ 
                    window.location.reload(); 
                }, 1000); 
            } else {
                showToast('error', response.message || 'Update failed');
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            showToast('error', 'System error: Check console');
        }
    });
});
})
