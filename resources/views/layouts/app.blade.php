<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SITS Admin Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon" />
    <!-- Fonts and icons -->
    <script src="{{ asset('js/plugin/webfont/webfont.min.js') }}"></script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/fonts.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />


</head>

<body>
    <div class="wrapper">

        @include('layouts.side-navigation')


        <!-- Page Content -->
        <div class="main-panel">
            <div class="main-header">

                @include('layouts.navigation')

            </div>
            <div class="container">
                <div class="page-inner">

                    @yield('contents')
                </div>
            </div>
        </div>

    </div>



    <script>
        function confirmDelete(ItemId) {
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, this Item cannot be recovered!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + ItemId).submit();
                }
            });
        }
    </script>
@if (session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: @json(__(session('status'))), 
                confirmButtonText: 'Okay'
            });
        });
    </script>
@endif

   
    @if(session('related'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let message = "{{ session('related') }}";
                let title = "";
                let text = "";

                if (message === "Item-related") {
                    title = "This Item can't be Deleted!";
                    text = "This Item has related to other  Items, First remove the relations.";
                }else if (message === "Item-parent") {
                    title = "This Item can't be Created!";
                    text = "This Item needa a Parent Item.";
                }

                Swal.fire({
                    icon: 'danger',
                    title: title,
                    text: text,
                    confirmButtonText: 'Okay'
                });
            });
        </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    let feedbackModal = document.getElementById("feedbackModal");

    feedbackModal.addEventListener("show.bs.modal", function (event) {
        let button = event.relatedTarget;
        let taskId = button.getAttribute("data-task-id");

        document.getElementById("task_id").value = taskId;
        document.getElementById("feedback_id").value = ""; // Reset reply field

        loadFeedback(taskId);
    });

    document.getElementById("feedbackForm").addEventListener("submit", function (event) {
        event.preventDefault();
        submitFeedback();
    });
});

function loadFeedback(taskId) {
    fetch(`/feedback/${taskId}`)
        .then(response => response.json())
        .then(data => {
            let feedbackList = document.getElementById("feedback-list");
            feedbackList.innerHTML = "";

            if (data.length === 0) {
                feedbackList.innerHTML = "<p class='text-muted text-center'>No feedback yet. Be the first to comment!</p>";
            } else {
                data.forEach(feedback => {
                    let feedbackHtml = renderFeedback(feedback);
                    feedbackList.innerHTML += feedbackHtml;
                });
            }
        })
        .catch(error => console.error("Error fetching feedback:", error));
}

function submitFeedback() {
    let formData = new FormData(document.getElementById("feedbackForm"));

    fetch("/feedback", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        }
    })
    .then(response => response.json())
    .then(data => {
        let feedbackList = document.getElementById("feedback-list");
        let newFeedbackHtml = renderFeedback(data);
        feedbackList.insertAdjacentHTML("afterbegin", newFeedbackHtml); // Add new feedback on top

        document.getElementById("comment").value = "";
        document.getElementById("feedback_id").value = ""; // Reset reply field
    })
    .catch(error => console.error("Error submitting feedback:", error));
}

function renderFeedback(feedback) {
    let replies = feedback.replies ? feedback.replies.map(reply => `
        <div class="feedback-message replies">
            <div class="feedback-avatar"></div>
            <div class="feedback-content">
                <div class="feedback-username">${reply.user.name}</div>
                <div class="feedback-text">${reply.comment}</div>
                <div class="feedback-time">${new Date(reply.created_at).toLocaleString()}</div>
            </div>
        </div>
    `).join("") : "";

    return `
        <div class="feedback-message">
            <div class="feedback-avatar"></div>
            <div class="feedback-content">
                <div class="feedback-username">${feedback.user.name}</div>
                <div class="feedback-text">${feedback.comment}</div>
                <div class="feedback-time">${new Date(feedback.created_at).toLocaleString()}</div>
                <span class="reply-btn" onclick="setReply(${feedback.id})">Reply</span>
                ${replies}
            </div>
        </div>
    `;
}

function setReply(feedbackId) {
    document.getElementById("feedback_id").value = feedbackId;
    document.getElementById("comment").focus();
}

    </script>
    <!--   Core JS Files   -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('js/kaiadmin.min.js') }}"></script>
    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    </script>
</body>

</html>
