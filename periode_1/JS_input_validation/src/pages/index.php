<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/cssreset.css">
    <link rel="stylesheet" href="../style/main.css">
    <title>Project - Input Validation</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/parsley.min.js"></script>
</head>

<body>
    <main>
        <section class="form">
            <form action="POST" data-parsley-validate>
                <label for="emailaddress">Enter email address *</label>
                <input type="email" data-parsley-type="email" name="emailaddress" id="emailaddress" placeholder="Enter email address" required>
                <button type="submit" value="Submit">Start Booking</button>
            </form>
            <p class="error" id="emailaddress-error"></p>
        </section>
    </main>
</body>

</html>