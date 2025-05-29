{{-- resources/views/aap_raffle/raffle_showcase.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $aap_raffle->ar_nameprize }} - Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.js"></script>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        overflow-x: hidden;
        font-family: Arial, sans-serif;
        background-image: url('/images/bg.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
    }

    .container {
        margin: auto;
        width: 100%;
    }

    .raffle-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .main-title {
        font-size: 3rem;
        font-weight: 900;
        text-transform: uppercase;
        line-height: 0.9;
        transform: skew(-10deg);
        text-shadow: 2px 2px 0 rgba(0, 0, 0, 0.2);
        color: #fff;
        margin-bottom: 10px;
        text-align: center;
    }

    .subtitle {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fde047;
        transform: skew(-10deg);
        margin-bottom: 20px;
        text-align: center;
    }

    .raffle-details {
        background-color: rgba(255, 255, 255, 0.8);
        margin: 20px 0;
        padding: 15px;
        border-radius: 8px;
    }

    .back-link {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 15px;
        background-color: #3490dc;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .carousel-container {
        width: 100%;
        position: relative;
        height: 500px;
        overflow: hidden;
        margin: 40px 0;
    }

    .slide {
        position: absolute;
        border-radius: 8px;
        overflow: hidden;
        transition: all 1.5s cubic-bezier(.22, 1, .36, 1);
    }

    .slide img {
        width: 100%;
        height: 70%;
        object-fit: contain;
        padding: 10px;
    }

    .slide-content {
        padding: 15px;
        text-align: center;
    }

    .product-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1e3a8a;
        text-transform: uppercase;
        margin-bottom: 5px;
        text-align: center;
        position: absolute;
        bottom: 15%;
        left: 0;
        right: 0;
        margin: 10px;
    }

    .prize-value {
        font-size: 1rem;
        color: #333;
        margin-bottom: 10px;
    }

    .navigation {
        position: absolute;
        bottom: 38%;
        left: 0;
        right: 0;
        display: flex;
        justify-content: space-between;
        padding: 0 21%;
        z-index: 200;
    }

    .nav-button-right {
        width: 0;
        height: 0;
        border-top: 35px solid transparent;
        border-bottom: 35px solid transparent;
        border-left: 35px solid #fde047;
        cursor: pointer;
    }

    .nav-button-left {
        width: 0;
        height: 0;
        border-top: 35px solid transparent;
        border-bottom: 35px solid transparent;
        border-right: 35px solid #fde047;
        cursor: pointer;
    }

    .nav-button-right:hover,
    .nav-button-left:hover {
        transform: scale(1.1);
    }

    .prize-counter {
        text-align: center;
        margin: 20px 0;
        font-weight: bold;
        color: white;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }

    .prize-details {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        margin: 40px auto;
        max-width: 800px;
    }

    .prize-image {
        max-width: 100%;
        height: auto;
        max-height: 400px;
        object-fit: contain;
        margin-bottom: 20px;
        border-radius: 8px;
    }

    .prize-name {
        font-size: 2rem;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 10px;
    }

    .prize-count {
        font-size: 1.5rem;
        font-weight: 600;
        background-color: #fde047;
        color: #1e3a8a;
        padding: 8px 20px;
        border-radius: 30px;
        display: inline-block;
        margin-top: 15px;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="raffle-header">
            <h1 class="main-title">Prize Showcase</h1>
            <p class="subtitle">Check out this amazing prize!</p>
        </div>

        <div class="prize-details">
            <img src="{{ asset($aap_raffle->raffle_image) }}" alt="{{ $aap_raffle->ar_nameprize }}" class="prize-image">
            <h2 class="prize-name">{{ $aap_raffle->ar_nameprize }}</h2>

            @if($aap_raffle->ar_nameprizet)
            <p class="prize-description">{{ $aap_raffle->ar_nameprizet }}</p>
            @endif

            <div class="prize-count">
                <span>{{ $aap_raffle->ar_noprize }}</span> Prize(s) Available
            </div>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('aap_raffles.index') }}" class="back-link">← Back to Raffles</a>
        </div>
    </div>
</body>

</html>