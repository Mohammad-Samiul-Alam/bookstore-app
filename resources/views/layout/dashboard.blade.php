<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bookstore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-bottom: 50px;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        a {
            text-decoration: none;
        }

        .hidden.space-x-8.sm\:-my-px.sm\:ms-10.sm\:flex {
            margin-left: 2px !important;
        }

        svg.w-5.h-5 {
            width: 15px;
        }

        nav.flex.items-center.justify-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        p {
            margin-top: 0;
            margin-bottom: 0;
            margin-left: 10px;
        }

        nav.flex.items-center.justify-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
        }

        span.relative.z-0.inline-flex.rtl\:flex-row-reverse.shadow-sm.rounded-md {
            margin-left: 10px;
        }

        .btn-custom {
            margin: 2px 0;
        }

        .flex.justify-between.flex-1.sm\:hidden {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .flex.justify-between.flex-1 span {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        span.relative.z-0.inline-flex.rtl\:flex-row-reverse.shadow-sm.rounded-md {
            margin-left: 11px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }



        @media (max-width: 576px) {
            .action-buttons {
                display: flex;
                flex-direction: column;
                gap: 0.3rem;
            }

            nav.flex.items-center.justify-between {
                overflow-x: scroll;
            }
        }
    </style>
</head>

<body class="bg-light">

    <!-- Header -->
    <div class="bg-dark py-3 text-center text-white mb-4">
        <h2 class="mb-0"><a href="{{ route('book') }}" class="text-white">Bookstore</a></h2>
    </div>

    <div class="container">
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    < /body>
</html>
