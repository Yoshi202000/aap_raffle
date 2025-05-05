<!DOCTYPE html>
<html>
<head>
    <title>Edit Raffle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .prize {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        input[type="text"], input[type="date"], input[type="number"], input[type="file"] {
            padding: 8px;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-right: 10px;
            border-radius: 4px;
        }
        button:hover {
            background-color: #45a049;
        }
        hr {
            margin: 30px 0;
            border: 0;
            border-top: 1px solid #eee;
        }
        .current-prizes {
            margin-top: 30px;
            margin-bottom: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .prize-image {
            max-width: 100px;
            margin-top: 10px;
        }
        .prize-image-container {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .error-container {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            display: none;
        }
        .form-text {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Raffle</h1>

        <div id="error-container" class="error-container"></div>

        <form action="{{ url('/raffles/'.$raffle->raffle_id) }}" method="POST" enctype="multipart/form-data" id="raffle-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Raffle Name:</label>
                <input type="text" name="raffle_name" value="{{ $raffle->raffle_name }}" required>
            </div>

            <div class="form-group">
                <label>Start Date:</label>
                <input type="date" name="start_date" value="{{ $raffle->start_date }}" required>
            </div>

            <div class="form-group">
                <label>End Date:</label>
                <input type="date" name="end_date" value="{{ $raffle->end_date }}" required>
            </div>

            <div class="form-group">
                <label>Background Image:</label>
                <input type="file" name="bg_image">
            </div>

            @if ($raffle->bg_image)
                <div class="prize-image-container">
                    <p>Current Background Image:</p>
                    <img src="{{ asset($raffle->bg_image) }}" alt="Current Background Image" style="max-width: 200px;">
                </div>
            @endif

            <!-- Display current prizes for this raffle -->
            <div class="current-prizes">
                <h2>Current Prizes</h2>
                
                @if($prizes->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Prize ID</th>
                                <th>Prize Name</th>
                                <th>Value</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prizes as $prize)
                                <tr>
                                    <td>{{ $prize->prize_id }}</td>
                                    <td>{{ $prize->prize_name }}</td>
                                    <td>${{ number_format($prize->prize_value, 2) }}</td>
                                    <td>
                                        @if($prize->prize_image)
                                            <img src="{{ asset($prize->prize_image) }}" alt="{{ $prize->prize_name }}" class="prize-image">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p><strong>Total Prize Value:</strong> ${{ number_format($prizes->sum('prize_value'), 2) }}</p>
                @else
                    <p>No prizes have been added to this raffle yet.</p>
                @endif
            </div>

            <hr>
            
            <h2>Add/Edit Prizes</h2>
            <p>You can update existing prizes or add new ones below.</p>

            <div id="prize-container">
                @foreach($prizes as $index => $prize)
                    <div class="prize">
                        <input type="hidden" name="prizes[{{ $index }}][prize_id]" value="{{ $prize->prize_id }}">
                        <input type="hidden" name="prizes[{{ $index }}][existing_image]" value="{{ $prize->prize_image }}">

                        <div class="form-group">
                            <label>Prize Name:</label>
                            <input type="text" name="prizes[{{ $index }}][prize_name]" value="{{ $prize->prize_name }}" required>
                        </div>

                        <div class="form-group">
                            <label>Prize Value:</label>
                            <input type="number" step="0.01" min="0" max="9999999.99" name="prizes[{{ $index }}][prize_value]" value="{{ $prize->prize_value }}" required>
                            <small class="form-text">Enter a value between 0 and 9,999,999.99</small>
                        </div>

                        <div class="form-group">
                            <label>Prize Image:</label>
                            <input type="file" name="prize_image_{{ $index }}" accept="image/*">
                            <small class="form-text">Upload a new image or leave empty to keep the current one</small>
                        </div>

                        @if($prize->prize_image)
                            <div class="prize-image-container">
                                <p>Current Image:</p>
                                <img src="{{ asset($prize->prize_image) }}" alt="{{ $prize->prize_name }}" class="prize-image">
                            </div>
                        @endif
                    </div>
                @endforeach

                {{-- If there are no prizes yet, show one blank input by default --}}
                @if ($prizes->isEmpty())
                    <div class="prize">
                        <div class="form-group">
                            <label>Prize Name:</label>
                            <input type="text" name="prizes[0][prize_name]" required>
                        </div>

                        <div class="form-group">
                            <label>Prize Value:</label>
                            <input type="number" step="0.01" min="0" max="9999999.99" name="prizes[0][prize_value]" required>
                            <small class="form-text">Enter a value between 0 and 9,999,999.99</small>
                        </div>

                        <div class="form-group">
                            <label>Prize Image:</label>
                            <input type="file" name="prize_image_0" accept="image/*">
                        </div>
                    </div>
                @endif
            </div>

            <button type="button" onclick="addPrize()">Add Another Prize</button>
            <button type="button" onclick="handleFormSubmit(event)">Update Raffle & Prizes</button>
        </form>

        <script>
            // Keep track of the next prize index
            let nextPrizeIndex = {{ $prizes->count() > 0 ? $prizes->count() : 1 }};

            function addPrize() {
                const container = document.getElementById('prize-container');
                const index = nextPrizeIndex++;

                const prizeDiv = document.createElement('div');
                prizeDiv.classList.add('prize');

                prizeDiv.innerHTML = `
                    <div class="form-group">
                        <label>Prize Name:</label>
                        <input type="text" name="prizes[${index}][prize_name]" required>
                    </div>

                    <div class="form-group">
                        <label>Prize Value:</label>
                        <input type="number" step="0.01" min="0" max="9999999.99" name="prizes[${index}][prize_value]" required>
                        <small class="form-text">Enter a value between 0 and 9,999,999.99</small>
                    </div>

                    <div class="form-group">
                        <label>Prize Image:</label>
                        <input type="file" name="prize_image_${index}" accept="image/*">
                    </div>
                `;

                container.appendChild(prizeDiv);
            }

            function validatePrizeValues() {
                const prizeValues = document.querySelectorAll('[name^="prizes"][name$="[prize_value]"]');
                const errorContainer = document.getElementById('error-container');
                
                let valid = true;
                let errorMessage = '';
                
                prizeValues.forEach((input, index) => {
                    const value = parseFloat(input.value);
                    
                    if (isNaN(value)) {
                        valid = false;
                        errorMessage = `Prize #${index + 1}: Value must be a number`;
                    } else if (value < 0) {
                        valid = false;
                        errorMessage = `Prize #${index + 1}: Value cannot be negative`;
                    } else if (value > 9999999.99) {
                        valid = false;
                        errorMessage = `Prize #${index + 1}: Value exceeds the maximum limit of 9,999,999.99`;
                    }
                });
                
                if (!valid) {
                    errorContainer.textContent = errorMessage;
                    errorContainer.style.display = 'block';
                } else {
                    errorContainer.style.display = 'none';
                }
                
                return valid;
            }

            function handleFormSubmit(e) {
    e.preventDefault();
    
    // Validate prize values before submission
    if (!validatePrizeValues()) {
        return; // Stop form submission if validation fails
    }
    
    const form = document.getElementById('raffle-form');
    const formData = new FormData(form);

    // Show a loading indicator
    const submitButton = e.target;
    const originalButtonText = submitButton.innerText;
    submitButton.innerText = 'Saving...';
    submitButton.disabled = true;

    // Step 1: Submit raffle form via fetch
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(async response => {
        if (!response.ok) {
            const text = await response.text();
            console.error(text);
            document.getElementById('error-container').textContent = "Failed to update raffle.";
            document.getElementById('error-container').style.display = 'block';
            submitButton.innerText = originalButtonText;
            submitButton.disabled = false;
            return Promise.reject("Raffle update failed");
        }

        // Step 2: Now submit prizes
        const prizeFormData = new FormData();
        prizeFormData.append('raffle_id', {{ $raffle->raffle_id }});
        
        // Add each prize as separate form data entries (not JSON)
        const prizeNames = document.querySelectorAll('[name^="prizes"][name$="[prize_name]"]');
        const prizeValues = document.querySelectorAll('[name^="prizes"][name$="[prize_value]"]');
        const existingImages = document.querySelectorAll('[name^="prizes"][name$="[existing_image]"]');
        
        for (let i = 0; i < prizeNames.length; i++) {
            prizeFormData.append(`prizes[${i}][prize_name]`, prizeNames[i].value);
            prizeFormData.append(`prizes[${i}][prize_value]`, prizeValues[i].value);
            
            // Add existing image if available
            if (i < existingImages.length && existingImages[i] && existingImages[i].value) {
                prizeFormData.append(`prizes[${i}][existing_image]`, existingImages[i].value);
            }
            
            // Add image file if available
            const fileInput = document.querySelector(`input[name="prize_image_${i}"]`);
            if (fileInput && fileInput.files.length > 0) {
                prizeFormData.append(`prize_image_${i}`, fileInput.files[0]);
            }
        }
        
        // Return the fetch for the next then handler
        return fetch('{{ url("/prizes") }}', {
            method: 'POST',
            body: prizeFormData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    })
    .then(async res => {
        if (!res.ok) {
            let errorMessage = "Failed to save prizes.";
            try {
                const errorResponse = await res.json();
                errorMessage = errorResponse.error || errorMessage;
            } catch (e) {
                const errorText = await res.text();
                console.error("Server error:", errorText);
            }
            
            document.getElementById('error-container').textContent = errorMessage;
            document.getElementById('error-container').style.display = 'block';
            
            submitButton.innerText = originalButtonText;
            submitButton.disabled = false;
            return Promise.reject("Prize update failed");
        } 
        
        // Success! Redirect or show success message
        alert("Raffle and prizes updated successfully!");
        window.location.href = '/raffles';
    })
    .catch(error => {
        console.error("Error in form submission:", error);
        submitButton.innerText = originalButtonText;
        submitButton.disabled = false;
    });
}
        </script>
    </div>
</body>
</html>