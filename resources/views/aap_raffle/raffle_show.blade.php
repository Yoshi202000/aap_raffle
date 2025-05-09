{{-- resources/views/aap_raffle/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AAP Raffle Entries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .raffle-card {
            transition: transform 0.3s;
            height: 100%;
        }
        .raffle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .raffle-image {
            height: 200px;
            object-fit: cover;
        }
        .prize-count {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255,255,255,0.8);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>AAP Raffle Entries</h1>
            <a href="{{ route('aap_raffles.create') }}" class="btn btn-primary">Add New Raffle</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse($raffles as $raffle)
                <div class="col">
                    <div class="card raffle-card h-100">
                        <div class="position-relative">
                            <img src="{{ asset($raffle->raffle_image) }}" class="card-img-top raffle-image" alt="{{ $raffle->ar_nameprize }}">
                            <div class="prize-count" title="Number of Prizes">
                                {{ $raffle->ar_noprize }}
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $raffle->ar_nameprize }}</h5>
                            @if($raffle->ar_nameprizet)
                                <p class="card-text text-muted">{{ $raffle->ar_nameprizet }}</p>
                            @endif
                            
                            @if($raffle->ar_date)
                                <p class="card-text"><small class="text-muted">Date: {{ \Carbon\Carbon::parse($raffle->ar_date)->format('M d, Y') }}</small></p>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="btn-group w-100">
                                <a href="{{ route('aap_raffles.show', $raffle->ar_id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                <a href="{{ route('aap_raffles.edit', $raffle->ar_id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form action="{{ route('aap_raffles.destroy', $raffle->ar_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this raffle?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        No raffle entries found. <a href="{{ route('aap_raffles.create') }}">Create one now</a>.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>