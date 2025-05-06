<!-- resources/views/aap_raffle/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>AAP Raffles</h2>
                    <a href="{{ route('aap_raffles.create') }}" class="btn btn-primary">Add New Raffle</a>
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
                                                    <th width="15%"># Attendees</th>
                                                    <th width="20%">Image</th>
                                                    <th width="15%">Date</th>
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
                                                                    <button class="btn btn-sm btn-outline-secondary edit-btn">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="editable-field attendees" data-field="ar_noattendees" data-id="{{ $raffle->ar_id }}">
                                                                    <span class="editable-text">{{ $raffle->ar_noattendees }}</span>
                                                                    <button class="btn btn-sm btn-outline-secondary edit-btn">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </button>
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
                                                            <td>{{ \Carbon\Carbon::parse($raffle->ar_date)->format('M d, Y') }}</td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="{{ route('aap_raffles.show', $raffle->ar_id) }}" class="btn btn-info btn-sm">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('aap_raffles.edit', $raffle->ar_id) }}" class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <form action="{{ route('aap_raffles.destroy', $raffle->ar_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this raffle?');" style="display: inline-block;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                                            <i class="fas fa-trash"></i>
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
                                            <button type="button" class="btn btn-success save-order-btn" data-type="members">
                                                <i class="fas fa-save"></i> Save Members Order
                                            </button>
                                        @endif
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
                                                    <th width="15%"># Attendees</th>
                                                    <th width="20%">Image</th>
                                                    <th width="15%">Date</th>
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
                                                                    <button class="btn btn-sm btn-outline-secondary edit-btn">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="editable-field attendees" data-field="ar_noattendees" data-id="{{ $raffle->ar_id }}">
                                                                    <span class="editable-text">{{ $raffle->ar_noattendees }}</span>
                                                                    <button class="btn btn-sm btn-outline-secondary edit-btn">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </button>
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
                                                            <td>{{ \Carbon\Carbon::parse($raffle->ar_date)->format('M d, Y') }}</td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="{{ route('aap_raffles.show', $raffle->ar_id) }}" class="btn btn-info btn-sm">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('aap_raffles.edit', $raffle->ar_id) }}" class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <form action="{{ route('aap_raffles.destroy', $raffle->ar_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this raffle?');" style="display: inline-block;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                                            <i class="fas fa-trash"></i>
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

<!-- Hidden file input for image uploads -->
<form id="image-upload-form" style="display: none;">
    <input type="file" id="image-upload-input" name="raffle_image" accept="image/jpeg,image/png,image/jpg">
</form>

<!-- Inline Edit Modal -->
<div class="modal fade" id="inline-edit-modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Field</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="inline-edit-form">
                    <input type="hidden" id="edit-field-name">
                    <input type="hidden" id="edit-raffle-id">
                    
                    <div class="form-group">
                        <label for="edit-field-value">Value:</label>
                        <input type="text" class="form-control" id="edit-field-value">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="save-edit-btn">Save</button>
            </div>
        </div>
    </div>
</div>

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
</style>

<script>
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
function saveOrder(tableId) {
    const rows = document.querySelectorAll(`#${tableId} tr:not(.no-sort)`);
    const orderData = [];
    
    rows.forEach(row => {
        orderData.push({
            id: row.getAttribute('data-id'),
            order: row.getAttribute('data-order')
        });
    });
    
    // Show loading state
    const saveBtn = document.querySelector(`button[data-type="${tableId === 'members-tbody' ? 'members' : 'attendees'}"]`);
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    saveBtn.disabled = true;
    
    // Send AJAX request
    $.ajax({
        url: '{{ route("aap_raffles.updateOrder") }}',
        method: 'POST',
        data: {
            orders: orderData
        },
        success: function(response) {
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success mt-3';
            alertDiv.textContent = 'Order has been updated successfully!';
            document.querySelector(`#${tableId}`).parentElement.appendChild(alertDiv);
            
            // Remove alert after 3 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
            
            // Reset button
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
        },
        error: function(error) {
            // Show error message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger mt-3';
            alertDiv.textContent = 'Error updating order. Please try again.';
            document.querySelector(`#${tableId}`).parentElement.appendChild(alertDiv);
            
            // Remove alert after 3 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
            
            // Reset button
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
            
            console.error('Error:', error);
        }
    });
}

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
@endsecti