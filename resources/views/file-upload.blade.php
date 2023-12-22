<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GigaChunk</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.js"
        integrity="sha512-yyr/AZnf9KbRjIKQpglQyZeyz2sOJCa0bcAt+qBnY/jfatfojXGz3eymOoZisKcIv9P49K/PzSJwdL5dwOfgGQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Acme&family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('app.css') }}">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow-sm p-4">
            {{-- !INFO: Title --}}
            <h1 class="text-center mb-0 text-success font-acme">GigaChunk</h1>
            <h4 class="text-center font-great-vibes">Get Chunky, Upload Happy</h4>

            {{-- !INFO: Select file --}}
            <form enctype="multipart/form-data" method="POST" action="{{ route('store.upload') }}">
                @csrf
                <div class="form-group">
                    <input name="uploaded-file" type="file" class="form-control" id="upload-file">
                </div>
            </form>

            {{-- !INFO: Progress bar --}}
            <div class="progress mt-2">
                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar"
                    style="width: 90%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">90%</div>
            </div>

            {{-- !INFO: Show video preview --}}
            <div class="card mt-5">
                <video class="embed-responsive embed-responsive-16by9" controls>
                    <source src="http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4" type="video/mp4">
                </video>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('app.js') }}"></script>
</body>

</html>
