{{-- edit_modal.blade.php - Save this file in resources/views/aap_raffle/ --}}

<!-- Edit Raffle Modal -->
<div class="modal fade" id="editRaffleModal" tabindex="-1" aria-labelledby="editRaffleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editRaffleModalLabel">Edit Raffle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRaffleForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="raffle_id" id="edit_raffle_id">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ar_nameprize">Prize Name</label>
                                <input type="text" class="form-control" id="edit_ar_nameprize" name="ar_nameprize"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ar_noprize">Number of Prizes</label>
                                <input type="number" class="form-control" id="edit_ar_noprize" name="ar_noprize"
                                    required min="1">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ar_order">Display Order</label>
                                <input type="number" class="form-control" id="edit_ar_order" name="ar_order" required
                                    min="0" max="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ar_date">Raffle Date</label>
                                <input type="date" class="form-control" id="edit_ar_date" name="ar_date" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Raffle Type</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="edit_ar_members"
                                        name="ar_members" value="1">
                                    <label class="form-check-label" for="edit_ar_members">Members Raffle</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="edit_ar_attendees"
                                        name="ar_attendees" value="1">
                                    <label class="form-check-label" for="edit_ar_attendees">Attendees Raffle</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ar_noattendees">Number of Attendees</label>
                                <input type="number" class="form-control" id="edit_ar_noattendees" name="ar_noattendees"
                                    min="0">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="edit_raffle_image">Raffle Image</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="edit_raffle_image" name="raffle_image"
                                        accept="image/jpeg,image/png,image/jpg">
                                </div>
                                <div class="mt-2" id="current_image_container" style="display: none;">
                                    <p>Current Image:</p>
                                    <img id="current_raffle_image" src="" class="img-thumbnail"
                                        style="max-height: 100px;">
                                </div>
                                <small class="form-text text-muted">Leave empty to keep current image</small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add this script at the bottom of the page -->
<script>
$(document).ready(function() {
    // Handle Edit button clicks
    $(document).on('click', '.Edit-button', function(e) {
        e.preventDefault();

        // Get the raffle ID
        let raffleId = $(this).data('id');

        if (!raffleId) {
            raffleId = $(this).closest('tr').data('id');
        }

        if (!raffleId) {
            console.error('Could not determine raffle ID');
            alert('Error: Could not determine which raffle to edit');
            return;
        }

        // Fetch raffle data
        $.ajax({
            url: `/aap_raffles/${raffleId}/get-edit-data`,
            type: 'GET',
            success: function(response) {
                let raffle = response.raffle;

                // Populate the form fields
                $('#edit_raffle_id').val(raffle.ar_id);
                $('#edit_ar_nameprize').val(raffle.ar_nameprize);
                $('#edit_ar_noprize').val(raffle.ar_noprize);
                $('#edit_ar_order').val(raffle.ar_order);
                $('#edit_ar_date').val(raffle.ar_date);
                $('#edit_ar_noattendees').val(raffle.ar_noattendees);

                // Set checkboxes
                $('#edit_ar_members').prop('checked', raffle.ar_members == 1);
                $('#edit_ar_attendees').prop('checked', raffle.ar_attendees == 1);

                // Show current image if exists
                if (raffle.raffle_image) {
                    $('#current_image_container').show();
                    $('#current_raffle_image').attr('src', raffle.raffle_image);
                } else {
                    $('#current_image_container').hide();
                }

                // Set the form action
                $('#editRaffleForm').attr('action', `/aap_raffles/${raffleId}`);

                // Show the modal
                $('#editRaffleModal').modal('show');
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error fetching raffle data');
            }
        });
    });

    // Form submission handling
    $('#editRaffleForm').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        // Handle checkbox values - if not checked, add as 0
        if (!$('#edit_ar_members').is(':checked')) {
            formData.set('ar_members', '0');
        }

        if (!$('#edit_ar_attendees').is(':checked')) {
            formData.set('ar_attendees', '0');
        }

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#editRaffleModal').modal('hide');

                // Success message
                alert('Raffle updated successfully');

                // Reload the page to see changes
                window.location.reload();
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while updating the raffle.';

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = 'Validation errors:';
                    for (let field in xhr.responseJSON.errors) {
                        errorMessage += '\n- ' + xhr.responseJSON.errors[field][0];
                    }
                }

                alert(errorMessage);
            }
        });
    });
});
</script>