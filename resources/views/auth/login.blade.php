<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in to SIMPEL-SOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #9b9ea1;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
        }

        .login-logo {
            font-size: 48px;
            color: #24292f;
            margin-bottom: 24px;
        }

        .login-card {
            background-color: #9ba5ae;
            border: 1px solid #d8dee4;
            border-radius: 6px;
            padding: 20px;
            width: 100%;
            max-width: 340px;
            margin-bottom: 16px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
            color: #24292f;
            font-weight: 300;
            font-size: 24px;
        }

        .form-label {
            font-weight: 400;
            font-size: 14px;
            color: #24292f;
        }

        .form-control {
            background-color: #f6f8fa;
            border: 1px solid #d0d7de;
            box-shadow: inset 0 1px 2px rgba(175, 184, 193, 0.2);
            border-radius: 6px;
            padding: 5px 12px;
            font-size: 14px;
            line-height: 20px;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #0969da;
            box-shadow: 0 0 0 3px rgba(9, 105, 218, 0.3);
            outline: none;
        }

        .btn-primary {
            background-color: #2da44e;
            color: #ffffff;
            border: 1px solid rgba(27, 31, 36, 0.15);
            border-radius: 6px;
            font-weight: 600;
            padding: 5px 16px;
            width: 100%;
            margin-top: 16px;
            box-shadow: 0 1px 0 rgba(27, 31, 36, 0.1);
        }

        .btn-primary:hover {
            background-color: #2c974b;
        }

        .login-footer {
            margin-top: 24px;
            font-size: 12px;
            color: #57606a;
            text-align: center;
        }

        .login-footer a {
            color: #0969da;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-logo">
        <i class="fab fa-github"></i>
    </div>

    <h1 class="login-header">Sign in to SIMPEL-SOS</h1>

    @if ($errors->any())
        <div class="alert alert-danger py-2 px-3 small w-100 max-w-340 mb-3"
            style="max-width: 340px; background: #ffebe9; border: 1px solid rgba(255,129,130,0.4); color: #cf222e; border-radius: 6px;">
            <i class="fas fa-times-circle me-1"></i> {{ $errors->first() }}
        </div>
    @endif

    <div class="login-card">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" autofocus required>
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label">Password</label>
                    <a href="#" style="font-size: 12px; text-decoration: none; color: #0969da;">Forgot
                        password?</a>
                </div>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
    </div>

    <div class="p-3 border rounded-3 text-center small"
        style="width: 100%; max-width: 340px; border-color: #d0d7de !important;">
        New to system? <a href="{{ route('home') }}" style="color: #0969da; text-decoration: none;">Back to public
            site</a>.
    </div>

    <div class="login-footer">
        <a href="#">Terms</a> &nbsp;&bull;&nbsp; <a href="#">Privacy</a> &nbsp;&bull;&nbsp; <a
            href="#">Security</a>
    </div>
</body>

</html>
