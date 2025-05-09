<!-- resources/views/aap_raffle/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="custom-card-header">
                    <h2>AAP Raffles</h2>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <!-- Members Raffles Column -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="mb-0">Members Raffles</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th width="5%">Order</th>
                                                    <th width="35%">Prize Name</th>
                                                    <th>no.</th>
                                                    <th width="20%">Image</th>
                                                    <th width="10%">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="members-tbody" class="sortable-table">
                                                @php $memberRafflesFound = false; @endphp
                                                @foreach ($raffles as $raffle)
                                                    @if($raffle->ar_members == 1)
                                                        @php $memberRafflesFound = true; @endphp
                                                        <tr data-id="{{ $raffle->ar_id }}" data-order="{{ $raffle->ar_order }}">
                                                            <td class="handle text-center" style="cursor: move;">
                                                                <span class="order-display">{{ $raffle->ar_order }}</span>
                                                                <i class="fas fa-grip-lines"></i>
                                                            </td>
                                                            <td>
                                                                <div class="editable-field prize-name" data-field="ar_nameprize" data-id="{{ $raffle->ar_id }}">
                                                                    <span class="editable-text">{{ $raffle->ar_nameprize }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="editable-fields" data-firld="ar_noprize" data-id="{{ $raffle->ar_id }}">
                                                                <span class="editable-text">{{ $raffle->ar_noprize }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="image-upload-container">
                                                                    @if($raffle->raffle_image)
                                                                        <img src="{{ asset($raffle->raffle_image) }}" class="img-thumbnail" style="max-height: 50px;">
                                                                        <button type="button" class="btn btn-sm btn-outline-secondary change-image-btn" data-id="{{ $raffle->ar_id }}">
                                                                            <i class="fas fa-sync-alt"></i>
                                                                        </button>
                                                                    @else
                                                                        <button type="button" class="btn btn-sm btn-outline-primary add-image-btn" data-id="{{ $raffle->ar_id }}">
                                                                            <i class="fas fa-plus"></i> Add Image
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <form action="">
                                                                    <button type="button" class="Edit-button btn btn-primary btn-sm" data-id="{{ $raffle->ar_id }}">
                                                                        <i class="fas fa-edit"></i> Edit
                                                                    </button>
                                                                    </form>
                                                                    <form action="{{ route('aap_raffles.destroy', $raffle->ar_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this raffle?');" style="display: inline-block;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="delete-button">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                
                                                @if(!$memberRafflesFound)
                                                    <tr class="no-sort">
                                                        <td colspan="6" class="text-center">No member raffles found</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        
                                        @if($memberRafflesFound)
                                            <button type="button" class="btn btn-success save-order-btn" data-type="members" onclick="saveOrder('members')">
                                                <i class="fas fa-save"></i> Save Members Order
                                            </button>
                                        @endif
                                        @include('aap_raffle.members_modal')
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#attendeesRaffleModal" onclick="setNextOrderNumber('members-tbody')">
                                        Create Members Raffle
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Attendees Raffles Column -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h3 class="mb-0">Attendees Raffles</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th width="5%">Order</th>
                                                    <th width="35%">Prize Name</th>
                                                    <th width="20%">Image</th>
                                                    <th>no.</th>
                                                    <th width="10%">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="attendees-tbody" class="sortable-table">
                                                @php $attendeeRafflesFound = false; @endphp
                                                @foreach ($raffles as $raffle)
                                                    @if($raffle->ar_members == 0)
                                                        @php $attendeeRafflesFound = true; @endphp
                                                        <tr data-id="{{ $raffle->ar_id }}" data-order="{{ $raffle->ar_order }}">
                                                            <td class="handle text-center" style="cursor: move;">
                                                                <span class="order-display">{{ $raffle->ar_order }}</span>
                                                                <i class="fas fa-grip-lines"></i>
                                                            </td>
                                                            <td>
                                                                <div class="editable-field prize-name" data-field="ar_nameprize" data-id="{{ $raffle->ar_id }}">
                                                                    <span class="editable-text">{{ $raffle->ar_nameprize }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="editable-fields" data-firld="ar_noprize" data-id="{{ $raffle->ar_id }}">
                                                                <span class="editable-text">{{ $raffle->ar_noprize }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="image-upload-container">
                                                                    @if($raffle->raffle_image)
                                                                        <img src="{{ asset($raffle->raffle_image) }}" class="img-thumbnail" style="max-height: 50px;">
                                                                        <button type="button" class="btn btn-sm btn-outline-secondary change-image-btn" data-id="{{ $raffle->ar_id }}">
                                                                            <i class="fas fa-sync-alt"></i>
                                                                        </button>
                                                                    @else
                                                                        <button type="button" class="btn btn-sm btn-outline-primary add-image-btn" data-id="{{ $raffle->ar_id }}">
                                                                            <i class="fas fa-plus"></i> Add Image
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <form action="" class="display: inline-block;">
                                                                    <button type="button" class="Edit-button btn btn-primary btn-sm" data-id="{{ $raffle->ar_id }}">
                                                                        <i class="fas fa-edit"></i> Edit
                                                                    </button>
                                                                    </form>
                                                                    <form action="{{ route('aap_raffles.destroy', $raffle->ar_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this raffle?');" style="display: inline-block;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="delete-button">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                
                                                @if(!$attendeeRafflesFound)
                                                    <tr class="no-sort">
                                                        <td colspan="6" class="text-center">No attendee raffles found</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        
                                        @if($attendeeRafflesFound)
                                            <button type="button" class="btn btn-success save-order-btn" data-type="attendees">
                                                <i class="fas fa-save"></i> Save Attendees Order
                                            </button>
                                        @endif
                                        @include('aap_raffle.attendees_modal')
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#attendeesRaffleModal" onclick="setNextOrderNumber('attendees-tbody')">
                                            Add Attendees Raffle
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Raffle Modal -->
<div class="modal fade" id="editRaffleModal" tabindex="-1" role="dialog" aria-labelledby="editRaffleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRaffleModalLabel">Edit Raffle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editRaffleForm" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <input type="hidden" class="form-control" id="ar_order" name="ar_order">
          <input type="hidden" class="form-control" id="ar_date" name="ar_date">

          <div class="form-group">
            <label for="ar_nameprize">Prize Name</label>
            <input type="text" class="form-control" id="ar_nameprize" name="ar_nameprize" required>
          </div>
          
          <div class="form-group">
            <label for="ar_noprize">Number of Prizes</label>
            <input type="number" class="form-control" id="ar_noprize" name="ar_noprize" required>
          </div>
          
          <!-- Add hidden fields for other required inputs with default values -->
          <input type="hidden" name="ar_members" value="1">
          
          <div class="form-group">
            <label for="raffle_image">Image</label>
            <input type="file" class="form-control-file" id="raffle_image" name="raffle_image">
            <img id="current_image" class="img-thumbnail mt-2" style="max-height: 100px; display: none;">
          </div>
          
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Hidden file input for image uploads -->
<form id="image-upload-form" style="display: none;">
    <input type="file" id="image-upload-input" name="raffle_image" accept="image/jpeg,image/png,image/jpg">
</form>
@include('aap_raffle.edit_modal')

<!-- CSRF Token Meta -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Required scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>

<style>
    .editable-field {
        display: flex;
        align-items: center;
    }
    .editable-field .edit-btn {
        visibility: hidden;
        margin-left: 5px;
    }
    .editable-field:hover .edit-btn {
        visibility: visible;
    }
    .image-upload-container {
        display: flex;
        align-items: center;
    }
    .image-upload-container img {
        margin-right: 5px;
    }
    .image-upload-container .change-image-btn {
        visibility: hidden;
    }
    .image-upload-container:hover .change-image-btn {
        visibility: visible;
    }
    .delete-button{
        background-color: red;
        border-radius: 5px;
        border: none;
        color: white;
        padding: 5px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 3px;
    }
    .edit-button{
        background-color: green;
        border-radius: 5px;
        border: none;
        color: white;
        padding: 5px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 3px;
    }
    .custom-card-header{
        display: flex;                    
    justify-content: space-between;   
    align-items: center;              
    padding: 0.75rem 1.25rem;       
    background-color: #f8f9fa;        
    border-bottom: 1px solid rgba(0, 0, 0, 0.125); 
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
    }
    .container{
        width: 100%;
    }
</style>

<script>
// Click handler for Edit button
$(document).on('click', '.Edit-button', function() {
    const raffleId = $(this).data('id');

    // Fetch data from table row
    const row = $(this).closest('tr');
    const prizeName = row.find('.prize-name .editable-text').text().trim();
    const prizeNo = row.find('[data-firld="ar_noprize"] .editable-text').text().trim(); // Note: fixing this typo in HTML would be better
    const order = row.data('order');
    const imageSrc = row.find('img').attr('src') || '';

    // Populate modal fields
    $('#ar_nameprize').val(prizeName);
    $('#ar_noprize').val(prizeNo);
    $('#ar_order').val(order);
    
    // Set image if it exists
    if (imageSrc) {
        $('#current_image').attr('src', imageSrc).show();
    } else {
        $('#current_image').hide();
    }

    // Set the form action - fix the route structure
    $('#editRaffleForm').attr('action', `/aap_raffles/${raffleId}`);

    // Show modal
    $('#editRaffleModal').modal('show');
});

// Form submission handler
$('#editRaffleForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const raffleId = $('#editRaffleForm').attr('action').split('/').pop();
    
    
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST', // Will be converted to PUT by the @method('PUT') in your form
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#editRaffleModal').modal('hide');
            // Show success message
            alert('Raffle updated successfully!');
            // Refresh the page to show updated data
            window.location.reload();
        },
        error: function(xhr) {
            console.error('Error updating raffle:', xhr.responseText);
            let errorMessage = 'Error updating raffle.';
            
            // Try to parse error messages from Laravel validation
            try {
                const errors = JSON.parse(xhr.responseText);
                if (errors.errors) {
                    errorMessage = Object.values(errors.errors).flat().join('\n');
                } else if (errors.message) {
                    errorMessage = errors.message;
                }
            } catch (e) {
                // If parsing fails, use generic message
            }
            
            alert(errorMessage);
        }
    });
});

// Add form submission handler to ensure proper submission
$('#editRaffleForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const raffleId = $('#raffle_id').val();
    
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#editRaffleModal').modal('hide');
            // Refresh the page or update the row with new data
            window.location.reload();
        },
        error: function(xhr) {
            console.error('Error updating raffle:', xhr.responseText);
            alert('Error updating raffle. Please check the form and try again.');
        }
    });
});



// Function to get next order number for a specific table
function getNextOrderNumber(tableId) {
    const rows = document.querySelectorAll(`#${tableId} tr:not(.no-sort)`);
    if (rows.length === 0) {
        return 1;
    }
    let maxOrder = 0;
    rows.forEach(row => {
        const orderValue = parseInt(row.getAttribute('data-order')) || 0;
        maxOrder = Math.max(maxOrder, orderValue);
    });
    return maxOrder + 1;
}

document.addEventListener('DOMContentLoaded', function() {
    // CSRF token setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize sortable tables
    initializeSortableTables();
    
    // Initialize order numbers on page load - STARTING FROM 1
    initializeOrderNumbers();
    
    // Set up inline editing
    setupInlineEditing();
    
    // Set up image upload functionality
    setupImageUpload();
    
    // Set up save order button handlers
    setupSaveOrderButtons();
});

// Initialize sortable tables
function initializeSortableTables() {
    const sortableTables = document.querySelectorAll('.sortable-table');
    sortableTables.forEach(table => {
        new Sortable(table, {
            handle: '.handle',
            animation: 150,
            ghostClass: 'bg-light',
            onEnd: function() {
                updateOrderNumbers(table.id);
            }
        });
    });
}

// Update order numbers after drag - STARTING FROM 1
function updateOrderNumbers(tableId) {
    const rows = document.querySelectorAll(`#${tableId} tr:not(.no-sort)`);
    rows.forEach((row, index) => {
        const orderSpan = row.querySelector('.order-display');
        if (orderSpan) {
            // Set display to index + 1 (starting from 1 instead of 0)
            const displayOrder = index + 1;
            orderSpan.textContent = displayOrder;
            row.setAttribute('data-order', displayOrder);
        }
    });
}

// Initialize order numbers on page load - STARTING FROM 1
function initializeOrderNumbers() {
    ['members-tbody', 'attendees-tbody'].forEach(tableId => {
        const rows = document.querySelectorAll(`#${tableId} tr:not(.no-sort)`);
        rows.forEach((row, index) => {
            const orderSpan = row.querySelector('.order-display');
            if (orderSpan) {
                // Set display to index + 1 (starting from 1 instead of 0)
                const displayOrder = index + 1;
                orderSpan.textContent = displayOrder;
                row.setAttribute('data-order', displayOrder);
            }
        });
    });
}

// Set up save order button handlers
function setupSaveOrderButtons() {
    document.querySelectorAll('.save-order-btn').forEach(button => {
        button.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            const tableId = type === 'members' ? 'members-tbody' : 'attendees-tbody';
            saveOrder(tableId);
        });
    });
}

// Save order function
function saveOrder(type) {
    let orders = [];
    
    // Collect the order information from the table
    $(`#${type}-tbody tr:not(.no-sort)`).each(function(index) {
        const id = $(this).data('id');
        if (id) {
            orders.push({
                id: id,
                order: index + 1
            });
        }
    });
    
    // Send the order data to the server
    $.ajax({
        url: '/aap_raffles/update-order', // Using direct URL instead of route()
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            orders: orders
        },
        success: function(response) {
            if (response.success) {
                alert('Order saved successfully!');
                // Update the displayed order numbers
                $(`#${type}-tbody tr:not(.no-sort)`).each(function(index) {
                    $(this).find('.order-display').text(index + 1);
                });
            }
        },
        error: function(xhr) {
            alert('Error saving order');
            console.error(xhr.responseText);
        }
    });
}

// Make the tables sortable if jQuery UI is available
$(document).ready(function() {
    if ($.fn.sortable) {
        $(".sortable-table").sortable({
            handle: ".handle",
            update: function(event, ui) {
                // Update the displayed order after drag
                $(this).find('tr').each(function(index) {
                    $(this).find('.order-display').text(index + 1);
                });
            }
        });
    }
});
// Set up inline editing
function setupInlineEditing() {
    // Edit button click handlers
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const editableField = this.closest('.editable-field');
            const fieldName = editableField.getAttribute('data-field');
            const raffleId = editableField.getAttribute('data-id');
            const currentValue = editableField.querySelector('.editable-text').textContent.trim();
            
            // Set values in the modal
            document.getElementById('edit-field-name').value = fieldName;
            document.getElementById('edit-raffle-id').value = raffleId;
            document.getElementById('edit-field-value').value = currentValue;
            
            // Set modal title based on field
            let modalTitle = 'Edit Field';
            if (fieldName === 'ar_nameprize') {
                modalTitle = 'Edit Prize Name';
            } else if (fieldName === 'ar_noattendees') {
                modalTitle = 'Edit Number of Attendees';
                // Change input type to number for attendees
                document.getElementById('edit-field-value').type = 'number';
                document.getElementById('edit-field-value').min = '0';
            }
            document.getElementById('editModalLabel').textContent = modalTitle;
            
            // Show the modal
            $('#inline-edit-modal').modal('show');
        });
    });
    
    // Save edit button click handler
    document.getElementById('save-edit-btn').addEventListener('click', function() {
        const fieldName = document.getElementById('edit-field-name').value;
        const raffleId = document.getElementById('edit-field-id').value;
        let fieldValue = document.getElementById('edit-field-value').value;
        
        // Validate value
        if (fieldName === 'ar_noattendees') {
            fieldValue = parseInt(fieldValue) || 0;
        }
        
        // Send AJAX request to update the field
        $.ajax({
            url: `/aap_raffles/update-field/${raffleId}`,
            method: 'POST',
            data: {
                field: fieldName,
                value: fieldValue
            },
            success: function(response) {
                // Update the display value
                const editableField = document.querySelector(`.editable-field[data-field="${fieldName}"][data-id="${raffleId}"]`);
                if (editableField) {
                    editableField.querySelector('.editable-text').textContent = fieldValue;
                }
                
                // Hide the modal
                $('#inline-edit-modal').modal('hide');
                
                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success';
                alertDiv.textContent = 'Field updated successfully!';
                alertDiv.style.position = 'fixed';
                alertDiv.style.top = '20px';
                alertDiv.style.right = '20px';
                alertDiv.style.zIndex = '9999';
                document.body.appendChild(alertDiv);
                
                // Remove alert after 3 seconds
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            },
            error: function(error) {
                console.error('Error updating field:', error);
                
                // Show error message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger';
                alertDiv.textContent = 'Error updating field. Please try again.';
                alertDiv.style.position = 'fixed';
                alertDiv.style.top = '20px';
                alertDiv.style.right = '20px';
                alertDiv.style.zIndex = '9999';
                document.body.appendChild(alertDiv);
                
                // Remove alert after 3 seconds
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            }
        });
    });
}

// Set up image upload functionality
function setupImageUpload() {
    // Add/Change image button click handlers
    document.querySelectorAll('.add-image-btn, .change-image-btn').forEach(button => {
        button.addEventListener('click', function() {
            const raffleId = this.getAttribute('data-id');
            document.getElementById('image-upload-input').setAttribute('data-raffle-id', raffleId);
            document.getElementById('image-upload-input').click();
        });
    });
    
    // File input change handler
    document.getElementById('image-upload-input').addEventListener('change', function() {
        if (this.files.length === 0) return;
        
        const raffleId = this.getAttribute('data-raffle-id');
        const file = this.files[0];
        
        // Create FormData
        const formData = new FormData();
        formData.append('raffle_image', file);
        
        // Show loading indicator
        const imageContainer = document.querySelector(`.image-upload-container button[data-id="${raffleId}"]`).parentElement;
        const originalContent = imageContainer.innerHTML;
        imageContainer.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Uploading...</div>';
        
        // Send AJAX request
        $.ajax({
            url: `/aap_raffles/update-image/${raffleId}`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Update the image display
                imageContainer.innerHTML = `
                    <img src="${response.image_url}" class="img-thumbnail" style="max-height: 50px;">
                    <button type="button" class="btn btn-sm btn-outline-secondary change-image-btn" data-id="${raffleId}">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                `;
                
                // Reattach event listener
                imageContainer.querySelector('.change-image-btn').addEventListener('click', function() {
                    document.getElementById('image-upload-input').setAttribute('data-raffle-id', raffleId);
                    document.getElementById('image-upload-input').click();
                });
                
                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success';
                alertDiv.textContent = 'Image updated successfully!';
                alertDiv.style.position = 'fixed';
                alertDiv.style.top = '20px';
                alertDiv.style.right = '20px';
                alertDiv.style.zIndex = '9999';
                document.body.appendChild(alertDiv);
                
                // Remove alert after 3 seconds
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            },
            error: function(error) {
                console.error('Error uploading image:', error);
                
                // Restore original content
                imageContainer.innerHTML = originalContent;
                
                // Reattach event listener
                imageContainer.querySelector('.add-image-btn, .change-image-btn').addEventListener('click', function() {
                    document.getElementById('image-upload-input').setAttribute('data-raffle-id', raffleId);
                    document.getElementById('image-upload-input').click();
                });
                
                // Show error message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger';
                alertDiv.textContent = 'Error uploading image. Please try again.';
                alertDiv.style.position = 'fixed';
                alertDiv.style.top = '20px';
                alertDiv.style.right = '20px';
                alertDiv.style.zIndex = '9999';
                document.body.appendChild(alertDiv);
                
                // Remove alert after 3 seconds
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            }
        });
    });
}

</script>