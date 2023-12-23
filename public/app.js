const browseFile = $("#browse-file");

const resumable = new Resumable({
    target: fileUploadingRoute,
    query: {
        _token: csrfToken,
    },
    chunkSize: 2 * 1024 * 1024,
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
    resumable.upload();
});

resumable.on("fileProgress", function (file) {
    updateProgress(Math.floor(file.progress() * 100));
});
resumable.on("fileSuccess", function (file, response) {
    response = JSON.parse(response);
    if (response.mime_type.includes("image")) {
        $("#imagePreview")
            .attr("src", response.path + "/" + response.name)
            .show();
    }
    if (response.mime_type.includes("video")) {
        $("#videoPreview")
            .attr("src", response.path + "/" + response.name)
            .show();
    }
    $(".card-footer").show();
});
resumable.on("fileError", function (file, response) {
    alert("file uploading error.");
});
let progress = $(".progress");

function showProgress() {
    progress.find(".progress-bar").css("width", "0%");
    progress.find(".progress-bar").html("0%");
    progress.find(".progress-bar").removeClass("bg-success");
    progress.show();
}

function updateProgress(value) {
    progress.find(".progress-bar").css("width", `${value}%`);
    progress.find(".progress-bar").html(`${value}%`);
    if (value === 100) {
        progress.find(".progress-bar").addClass("bg-success");
    }
}

function hideProgress() {
    progress.hide();
}
