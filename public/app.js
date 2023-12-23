const browseFile = $("#browse-file");

const resumable = new Resumable({
    target: fileUploadingRoute,
    query: {
        _token: csrfToken,
    },
    chunkSize: 4 * 1024 * 1024,
    headers: {
        Accept: "application/json",
    },
    testChunks: false,
    throttleProgressCallbacks: 1,
});

// !INFO: Target The File
resumable.assignBrowse(browseFile[0]);

// !INFO: Assign Event
resumable.on("fileAdded", function (file) {
    showProgress();
    showFileInfoContainer(file);
    resumable.upload();
});

// !INFO: Show progress bar on update
resumable.on("fileProgress", function (file) {
    updateProgress(Math.floor(file.progress() * 100));
});

// !SUCCESS: File Uploaded
resumable.on("fileSuccess", function (file, response) {
    response = JSON.parse(response);
    if (response.mime_type.includes("video")) {
        showVideoPerview(response);
    }
});

// !WARN: Handle Error
resumable.on("fileError", function (file, response) {
    $("#error-alert").show();
});

// !INFO: Helper Function
const progress = $(".progress");
const videoContainer = $("#video-container");

hideProgress();

function showProgress() {
    progress.show();
}

function showFileInfoContainer(file) {
    $("#file-info-container").show();
    $("#file-name").html(file.fileName);
    $("#file-size").html(`${(file.size / (1024 * 1024)).toFixed(2)} MB`);
}

function showVideoPerview(response) {
    $("#video-preview")
        .attr("src", response.path + "/" + response.name)
        .show();
}

function hideProgress() {
    progress.hide();
}

function updateProgress(value) {
    progress.find(".progress-bar").css("width", `${value}%`);
    progress.find(".progress-bar").html(`${value}%`);

    if (value == 100) {
        hideProgress();
        $("#success-alert").show();
    }
}
