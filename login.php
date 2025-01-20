<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        header {
            background: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav {
            background-color: #444;
            color: white;
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        section {
            margin-bottom: 30px;
        }
        form label, form input, form button {
            display: block;
            width: 100%;
            margin-bottom: 15px;
        }
        form input {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #555;
        }

        .account-section {
            display: flex;
            align-items: center;
        }

        .account-section img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .account-section p {
            margin: 0;
        }

        .account-section a {
            color: #fff;
            text-decoration: none;
            margin-left: 10px;
        }

        .account-section a:hover {
            color: #ff6666;
        }
    </style>
</head>
<body>

<header>
    <div>
        <h1>Login</h1>
    </div>
</header>

<main>
    <section>
        <form action="ceklogin.php" method="POST">
            <h2>Login</h2>

            <div>
                <label for="Username">Username</label>
                <input type="text" name="Username" id="Username" required>
            </div>

            <div>
                <label for="Password">Password</label>
                <input type="password" name="Password" id="Password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </section>
</main>

</body>
</html>
